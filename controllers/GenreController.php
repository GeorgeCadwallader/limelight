<?php

namespace app\controllers;

use app\models\Genre;

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

        return $this->createResponse('view', compact('genre'));
    }

}