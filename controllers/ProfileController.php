<?php

namespace app\controllers;

use app\auth\Item;
use app\models\User;
use app\models\UserData;
use Yii;
use yii\base\Response;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;

class ProfileController extends \app\core\WebController
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
     * Displays the user profile
     *
     * @return Response
     */
    public function actionIndex(): Response
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/site/login');
        }

        $user = Yii::$app->user->identity;

        if ($user === null) {
            throw new BadRequestHttpException('Unable to verify your request');
        }

        if (Yii::$app->user->can(Item::ROLE_MEMBER)) {
            return $this->createResponse('member', compact('user'));
        }

        if (Yii::$app->user->can(Item::ROLE_ARTIST_OWNER)) {
            return $this->createResponse('artist-owner', compact('user'));
        }

        if (Yii::$app->user->can(Item::ROLE_VENUE_OWNER)) {
            return $this->createResponse('venue-owner', compact('user'));
        }

        if (Yii::$app->user->can(Item::ROLE_ADMIN)) {
            return $this->createResponse(Yii::$app->homeUrl);
        }

    }

    /**
     * Edit the user profile
     *
     * @return Response
     */
    public function actionEdit(int $user_id): Response
    {
        $user = User::findOne($user_id);

        if ($user === null || $user_id !== Yii::$app->user->id) {
            throw new BadRequestHttpException('Invalid Request');
        }

        $userData = $user->userData;

        if ($this->request->isPost) {
            if ($userData->load(Yii::$app->request->post()) && $userData->save()) {
                Yii::$app->session->addFlash('success', 'Your profile has successfully been updated');
                return $this->redirect('/profile');
            }
        }

        return $this->createResponse('edit', compact('userData'));
    }

}
