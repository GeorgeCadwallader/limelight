<?php

declare(strict_types = 1);

namespace app\controllers;

use app\auth\Item;
use app\models\Artist;
use app\models\forms\RegisterForm;
use app\models\User;
use app\models\Venue;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;

class RegisterController extends \app\core\WebController
{

    /**
     * @inheritDoc
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['?'],
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['GET', 'POST'],
                ],
            ],
        ];
    }

    public function actionIndex(): string
    {
        $user = new User([
            'status' => User::STATUS_UNVERIFIED,
            'password' => Yii::$app->security->generateRandomString(12),
            'password_reset_token' => Yii::$app->security->generateRandomString()
        ]);

        $registerForm = new RegisterForm;

        if ($this->request->isPost) {
            $user->generateAuthKey();
            $transaction = Yii::$app->db->beginTransaction();

            $user->load($this->request->post());
            $user->validate();

            $accountType = (int)ArrayHelper::getValue($this->request->post(), 'RegisterForm.account_type');

            if ($accountType === 1) {
                $user->updateAttributes(['roles' => [Item::ROLE_MEMBER]]);
            } elseif ($accountType === 2) {
                $user->updateAttributes(['roles' => [Item::ROLE_ARTIST_OWNER]]);
            } elseif ($accountType === 3) {
                $user->updateAttributes(['roles' => [Item::ROLE_VENUE_OWNER]]);
            } else {
                throw new BadRequestHttpException('Invalid Request');
            }

            if ($user->save()) {
                $transaction->commit();
                Yii::$app->mailer->compose('member-email-confirm', ['user' => $user])
                    ->setFrom(Yii::$app->params['senderEmail'])
                    ->setTo([$user->email => $user->username])
                    ->setSubject('Welcome to '.Yii::$app->name)
                    ->send();
                return $this->render('registered', compact('user'));
            } else {
                $transaction->rollBack();
                Yii::$app->session->addFlash('notice-error', 'There was an error with your registration');
            }
        }

        return $this->render('index', compact(
            'user',
            'registerForm'
        ));
    }

}
