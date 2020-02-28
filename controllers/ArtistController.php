<?php

namespace app\controllers;

use app\auth\Item;
use app\models\Artist;
use app\models\search\CountySearch;
use app\models\search\RegionSearch;
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
                return $this->redirect(['/artist/view', 'artist_id' => $artist->artist_id]);
            }
        }

        return $this->createResponse('artist-create', compact('artist'));
    }

    public function actionView(int $artist_id): Response
    {
        // get only by status of active
        $artist = Artist::findOne($artist_id);

        if ($artist === null) {
            throw new BadRequestHttpException('Invalid artist');
        }

        return $this->createResponse('view', compact('artist'));
    }

}
