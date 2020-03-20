<?php

namespace app\controllers;

use app\auth\Item;
use app\models\Genre;
use app\models\User;
use app\models\UserData;
use app\models\UserGenre;
use Yii;
use yii\base\Response;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\UploadedFile;

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
            $userData->imageFile = UploadedFile::getInstance($userData, 'imageFile');

            if ($userData->imageFile !== null && !$userData->upload()) {
                throw new BadRequestHttpException('There was an error uploading your image');
            }

            if (Yii::$app->request->post()['User']['genre']) {
                $user->unlinkAll('genre', true);

                foreach (Yii::$app->request->post()['User']['genre'] as $genre) {
                    $genreModel = Genre::findOne($genre);

                    if ($genreModel === null) {
                        throw new BadRequestHttpException('Invalid genre');
                    }

                    $user->link('genre', $genreModel);
                }
            } else {
                $user->unlinkAll('genre', true);
            }

            if ($userData->load(Yii::$app->request->post()) && $userData->save() && $user->save()) {
                Yii::$app->session->addFlash('success', 'Your profile has successfully been updated');
                return $this->redirect('/profile');
            }
        }

        return $this->createResponse('edit', compact('userData'));
    }

}
