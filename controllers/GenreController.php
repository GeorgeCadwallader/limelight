<?php

namespace app\controllers;

use app\models\Advert;
use app\models\Genre;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;
use yii\web\Response;

/**
 * Controller for genre functionality
 */
class GenreController extends \app\core\WebController
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
                        'actions' => [
                            'index',
                            'view'
                        ]
                    ]
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions(): array
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
     * Index action for Genre Controller
     * 
     * @return Response
     */
    public function actionIndex(): Response
    {
        return $this->createResponse('index');
    }

    /**
     * View a specific genre
     * 
     * @return Response
     */
    public function actionView(int $genre_id): Response
    {
        $genre = Genre::findOne($genre_id);

        if ($genre === null) {
            throw new BadRequestHttpException('Invalid Genre');
        }

        $adverts = Advert::find()
            ->where(['genre_id' => $genre_id])
            ->andWhere(['>=', 'created_at', new Expression('UNIX_TIMESTAMP(NOW() - INTERVAL 1 DAY)')])
            ->andWhere(['status' => Advert::STATUS_ACTIVE])
            ->orderBy(new Expression('rand()'))
            ->limit(4)
            ->all();

        foreach ($adverts as $advert) {
            $advert->deductBudget();
        }

        return $this->createResponse('view', compact('genre', 'adverts'));
    }

}