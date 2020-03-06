<?php

namespace app\controllers;

use app\auth\Item;
use app\models\OwnerRequest;
use app\models\ReviewVenue;
use app\models\Venue;

use Yii;
use yii\base\Response;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;

/**
 * Class for the venue actions of the app
 */
class VenueController extends \app\core\WebController
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
                        'roles' => [Item::ROLE_VENUE_OWNER],
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
     * Render the main venue listing page
     *
     * @return Response
     */
    public function actionIndex(): Response
    {
        return $this->createResponse('index');
    }

    /**
     * Create a venue
     *
     * @return Response
     */
    public function actionCreate(): Response
    {
        $venue = new Venue([
            'status' => Venue::STATUS_UNVERIFIED,
            'managed_by' => Yii::$app->user->id
        ]);

        if ($this->request->isPost) {
            $venue->load($this->request->post());
            
            if ($venue->save() && $venue->validate()) {
                Yii::$app->session->addFlash('success', 'You have successfully created your venue page');
                return $this->redirect(['/venue/edit', 'venue_id' => $venue->venue_id]);
            }
        }

        return $this->createResponse('venue-create', compact('venue'));
    }

    /**
     * Request ownership of an venue page
     */
    public function actionRequest(): Response
    {
        $venueRequest = new OwnerRequest([
            'type' => OwnerRequest::TYPE_VENUE
        ]);

        if ($this->request->isPost) {
            $venueRequest->load($this->request->post());

            if ($venueRequest->save() && $venueRequest->validate()) {
                Yii::$app->session->addFlash('success', 'You have successfully requested ownership of a venue page');
                return $this->redirect('/profile');
            }
        }

        return $this->createResponse('request', compact('venueRequest'));
    }

    /**
     * Edit the venue page
     *
     * @return Response
     */
    public function actionEdit(int $venue_id): Response
    {
        $venue = Venue::find()
            ->where(['venue_id' => $venue_id])
            ->one();

        if ($venue->managed_by === Yii::$app->user->id) {
            return $this->createResponse('edit', compact('venue'));
        }

        $roles = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);

        if (array_key_exists(Item::ROLE_ADMIN, $roles)) {
            return $this->createResponse('edit', compact('venue'));
        }

        throw new BadRequestHttpException('You do not have access to edit this venue');
    }

    /**
     * View the venue page
     *
     * @return Response
     */
    public function actionView(int $venue_id): Response
    {
        $venue = Venue::find()
            ->where(['venue_id' => $venue_id])
            ->andWhere(['status' => Venue::STATUS_ACTIVE])
            ->one();

        if ($venue === null) {
            throw new BadRequestHttpException('Invalid venue');
        }

        $newReview = new ReviewVenue([
            'status' => ReviewVenue::STATUS_ACTIVE,
        ]);

        if ($this->request->isPost) {
            $newReview->load($this->request->post());
            $newReview->link('venue', $venue);
    
            if ($newReview->save() && $newReview->validate()){
                Yii::$app->session->addFlash('success', 'Your review has successfully been created');
                return $this->redirect(['/venue/view', 'venue_id' => $venue->venue_id]);
            }
        }

        return $this->createResponse('view', compact('venue', 'newReview'));
    }

}
