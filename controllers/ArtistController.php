<?php

namespace app\controllers;

use app\auth\Item;
use app\models\Artist;
use app\models\OwnerRequest;

use Yii;
use yii\base\Response;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;

class ArtistController extends \app\core\WebController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [Item::ROLE_ARTIST_OWNER],
                    ]
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
     * Create an artist
     *
     * @return Response
     */
    public function actionCreate(): Response
    {
        $artist = new Artist([
            'status' => Artist::STATUS_UNVERIFIED,
            'managed_by' => Yii::$app->user->id
        ]);

        if ($this->request->isPost) {
            $artist->load($this->request->post());
            
            if ($artist->save() && $artist->validate()) {
                Yii::$app->session->addFlash('success', 'You have successfully created your artist page');
                return $this->redirect(['/artist/edit', 'artist_id' => $artist->artist_id]);
            }
        }

        return $this->createResponse('artist-create', compact('artist'));
    }

    /**
     * Request ownership of an artist page
     */
    public function actionRequest(): Response
    {
        $artistRequest = new OwnerRequest([
            'type' => OwnerRequest::TYPE_ARTIST
        ]);

        if ($this->request->isPost) {
            $artistRequest->load($this->request->post());

            if ($artistRequest->save() && $artistRequest->validate()) {
                Yii::$app->session->addFlash('success', 'You have successfully requested ownership of an artist page');
                return $this->redirect('/profile');
            }
        }

        return $this->createResponse('request', compact('artistRequest'));
    }

    /**
     * Edit the artist page
     *
     * @return Response
     */
    public function actionEdit(int $artist_id): Response
    {
        $artist = Artist::find()
            ->where(['artist_id' => $artist_id])
            ->one();

        if ($artist->managed_by === Yii::$app->user->id) {
            return $this->createResponse('edit', compact('artist'));
        }

        $roles = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);

        if (array_key_exists(Item::ROLE_ADMIN, $roles)) {
            return $this->createResponse('edit', compact('artist'));
        }

        throw new BadRequestHttpException('You do not have access to edit this artist');
    }

    /**
     * View the artist page
     *
     * @return Response
     */
    public function actionView(int $artist_id): Response
    {
        $artist = Artist::find()
            ->where(['artist_id' => $artist_id])
            ->andWhere(['status' => Artist::STATUS_ACTIVE])
            ->one();

        if ($artist === null) {
            throw new BadRequestHttpException('Invalid artist');
        }

        return $this->createResponse('view', compact('artist'));
    }

}
