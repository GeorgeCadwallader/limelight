<?php

namespace app\controllers;

use app\auth\Item;
use app\models\Artist;
use app\models\ArtistData;
use app\models\OwnerRequest;
use app\models\ReviewArtist;

use Yii;
use yii\base\Response;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;
use yii\web\UploadedFile;

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
                        'actions' => [
                            'create',
                            'request',
                            'edit',
                        ],
                        'roles' => [Item::ROLE_ARTIST_OWNER],
                    ],
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
     * Render the main artist listing page
     *
     * @return Response
     */
    public function actionIndex(): Response
    {
        return $this->createResponse('index');
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

        if ($artist === null) {
            throw new BadRequestHttpException('Invalid Artist');
        }

        if ($artist->data === null) {
            $artistData = new ArtistData(['artist_id' => $artist->artist_id]);

            if (!$artistData->save()) {
                throw new BadRequestHttpException('Invalid Request');
            }
        } else {
            $artistData = $artist->data;
        }

        $roles = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);

        if (array_key_exists(Item::ROLE_ADMIN, $roles) || $artist->managed_by === Yii::$app->user->id) {
            if ($this->request->isPost) {
                $artistData->imageFile = UploadedFile::getInstance($artistData, 'imageFile');

                if ($artistData->imageFile !== null && !$artistData->upload()) {
                    throw new BadRequestHttpException('There was an error uploading your image');
                }

                $artistData->load($this->request->post());

                if ($artistData->save() && $artistData->validate()) {
                    Yii::$app->session->addFlash('success', 'Artist successfully updated');
                    return $this->redirect(['/artist/view', 'artist_id' => $artist->artist_id]);
                }
            }

            return $this->createResponse('edit', compact('artist', 'artistData'));
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

        $newReview = new ReviewArtist([
            'status' => ReviewArtist::STATUS_ACTIVE,
        ]);

        if ($this->request->isPost) {
            $newReview->load($this->request->post());
            $newReview->link('artist', $artist);
    
            if ($newReview->save() && $newReview->validate()){
                Yii::$app->session->addFlash('success', 'Your review has successfully been created');
                return $this->redirect(['/artist/view', 'artist_id' => $artist->artist_id]);
            }
        }

        return $this->createResponse('view', compact('artist', 'newReview'));
    }

}
