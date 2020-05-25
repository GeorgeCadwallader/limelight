<?php

namespace app\controllers;

use app\auth\Item;
use app\models\Advert;
use app\models\Artist;
use app\models\Contact;
use Yii;
use yii\filters\AccessControl;
use yii\web\Response;
use app\models\forms\LoginForm;
use app\models\forms\RequestEmailResetForm;
use app\models\forms\RequestPasswordResetForm;
use app\models\forms\ResetPasswordForm;
use app\models\forms\UserActivationForm;
use app\models\User;
use app\models\UserData;
use app\models\Venue;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;

class SiteController extends \app\core\WebController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            'auth' => [
                'class' => AccessControl::class,
                'only' => ['touch'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $adverts = Advert::find()
            ->where(['>=', 'created_at', new Expression('UNIX_TIMESTAMP(NOW() - INTERVAL 1 DAY)')])
            ->andWhere(['status' => Advert::STATUS_ACTIVE])
            ->andWhere(['advert_type' => Advert::ADVERT_TYPE_GLOBAL])
            ->orderBy(new Expression('rand()'))
            ->limit(4)
            ->all();

        foreach ($adverts as $advert) {
            $advert->deductBudget();
        }

        if (Yii::$app->user->isGuest) {
            return $this->render('partials/guest-index', compact('adverts'));
        }

        $roles = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
        
        if (array_key_exists(Item::ROLE_ADMIN, $roles)) {
            return $this->redirect(Url::toRoute('/admin'));
        } elseif (array_key_exists(Item::ROLE_ARTIST_OWNER, $roles) && Yii::$app->user->identity->artist !== null) {
            $owner = Yii::$app->user->identity;
            return $this->render('partials/artist-owner-index', compact('owner', 'adverts'));
        } elseif (array_key_exists(Item::ROLE_VENUE_OWNER, $roles) && Yii::$app->user->identity->venue !== null) {
            $owner = Yii::$app->user->identity;
            return $this->render('partials/venue-owner-index', compact('owner', 'adverts'));
        } else {
            $member = Yii::$app->user->identity;
            $memberAdverts = Advert::find()
                ->where(['status' => Advert::STATUS_ACTIVE])
                ->andWhere(['!=', 'advert_type', Advert::ADVERT_TYPE_GLOBAL])
                ->andWhere([
                    'OR',
                    ['IN', 'genre_id', ArrayHelper::map($member->genre, 'name', 'genre_id')],
                    ['=', 'region_id', $member->userData->county_id]
                ])
                ->orderBy(new Expression('rand()'))
                ->limit(4)
                ->all();

            return $this->render('partials/member-index', compact('member', 'adverts', 'memberAdverts'));
        }

        throw new BadRequestHttpException('Unable to process your request');
    }

    /**
     * Render the contact page
     */
    public function actionContactUs(): Response
    {
        $contactForm = new Contact([
            'status' => Contact::STATUS_UNREAD
        ]);

        if ($this->request->isPost) {
            $contactForm->load($this->request->post());

            if ($contactForm->save()) {
                Yii::$app->session->addFlash('success', 'Thank you for messaging us, we will get back to you as soon as we can');
                return $this->goHome();
            }
        }

        return $this->createResponse('contact', compact('contactForm'));
    }

    /**
     * Render the privacy policy page
     */
    public function actionPrivacyPolicy(): Response
    {
        return $this->createResponse('privacy-policy');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Activate an inactive user
     *
     * @param string $token
     * @return Response
     */
    public function actionActivate(string $token): Response
    {
        $model = new UserActivationForm($token);

        if ($model->load(Yii::$app->request->post()) && $model->activate()) {
            $userData = new UserData;
            $model->user->link('userData', $userData);
            Yii::$app->user->login($model->user);
            Yii::$app->session->addFlash('success', 'Your account has now been activated');
            return $this->goHome();
        }

        $model->password = null;
        $model->password_repeat = null;

        return $this->createResponse('reset-password', ['model' => $model]);
    }

    /**
     * Reset a password request
     *
     * @param string $token
     * @return Response
     */
    public function actionResetPassword(string $token): Response
    {
        $user = User::findByPasswordResetToken($token);

        if ($user === null) {
            throw new BadRequestHttpException('Invalid token');
        }

        $model = new ResetPasswordForm($token);

        if ($this->request->isPost) {
            $model->load($this->request->post());

            if ($model->validate()) {
                $user->setPassword($model->password);
                $user->password_reset_token = null;

                if ($user->save()) {
                    Yii::$app->session->addFlash('success', 'Password sucessfully changed');
                    Yii::$app->user->login($user);
                    return $this->redirect('/');
                }
            }
        }

        $model->password = null;
        $model->password_repeat = null;

        return $this->createResponse('reset-password', ['model' => $model]);
    }

    /**
     * Request a password reset email
     *
     * @param string $token
     * @return Response
     */
    public function actionRequestPasswordReset(): Response
    {
        $requestForm = new RequestPasswordResetForm;

        if ($this->request->isPost) {
            $requestForm->load($this->request->post());

            if ($requestForm->validate()) {
                $user = User::findByEmail($requestForm->email);

                if ($user !== null) {
                    $user->generatePasswordResetToken();
                    $user->save();
                    Yii::$app->mailer->compose('password-reset-confirm', ['user' => $user])
                        ->setFrom(Yii::$app->params['senderEmail'])
                        ->setTo([$user->email => $user->username])
                        ->setSubject('Request password reset | '.Yii::$app->name)
                        ->send();
                    Yii::$app->session->addFlash('success', 'If we recognise this email address you will recieve an email with a password reset token');
                    return $this->redirect('/site/request-password-reset');
                }
            }
        }

        return $this->createResponse('request-password-reset', compact('requestForm'));
    }

    /**
     * Load page to request a new email
     * 
     * @return Response
     */
    public function actionChangeEmailRequest(): Response
    {
        if (Yii::$app->user->isGuest) {
            throw new BadRequestHttpException('You must be logged in to do this');
        }

        $user = Yii::$app->user->identity;

        $emailForm = new RequestEmailResetForm;

        if ($this->request->isPost) {
            $emailForm->load($this->request->post());

            if ($emailForm->validate()) {
                $user->generatePasswordResetToken();
                $user->email_new = $emailForm->email_new;
                $user->save();
                Yii::$app->mailer->compose(
                    'request-new-email-form',
                    ['user' => $user]
                )
                    ->setFrom(Yii::$app->params['senderEmail'])
                    ->setTo([$user->email_new => $user->username])
                    ->setSubject('Email reset request | '.Yii::$app->name)
                    ->send();
                Yii::$app->session->addFlash('success', 'Request successfully sent');
                return $this->goHome();
            }

            throw new BadRequestHttpException('Invalid Request');
        }

        return $this->createResponse('new-email-request', compact('emailForm'));
    }

    /**
     * Changes a users email
     *
     * @param string $token
     * @return Response
     */
    public function actionChangeEmail($token): Response
    {
        if ($token === null) {
            throw new BadRequestHttpException('Token can not be blank');
        }

        $user = User::findByPasswordResetToken($token);

        if ($user === null) {
            throw new BadRequestHttpException('Invalid user');
        }

        $transaction = Yii::$app->db->beginTransaction();

        if ($user->email_new !== null) {
            $user->email = $user->email_new;
            $user->email_new = null;
            $user->password_reset_token = null;

            if ($user->save()) {
                $transaction->commit();
                
                if (Yii::$app->user->isGuest) {
                    Yii::$app->user->login($user);
                }

                Yii::$app->session->addFlash('success', 'Your email has successfully been changed');
                return $this->goHome();
            }
        }
        $transaction->rollBack();
        Yii::$app->session->addFlash('error', 'There was a problem updating your email address');
        return $this->goHome();
    }

}
