<?php

namespace app\controllers;

use app\auth\Item;
use app\models\Artist;
use Yii;
use yii\filters\AccessControl;
use yii\web\Response;
use app\models\forms\LoginForm;
use app\models\forms\UserActivationForm;
use app\models\UserData;
use app\models\Venue;
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
        if (Yii::$app->user->isGuest) {
            return $this->render('index');
        }

        $roles = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);

        if (array_key_exists(Item::ROLE_ADMIN, $roles)) {
            return $this->redirect(Url::toRoute('/admin'));
        } else {
            return $this->render('index');
        }

        throw new BadRequestHttpException('Unable to verify your request');
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

}
