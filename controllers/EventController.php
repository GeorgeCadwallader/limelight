<?php

declare(strict_types = 1);

namespace app\controllers;

use app\auth\Item;
use app\models\Event;
use app\models\search\EventFilterSearch;
use app\models\UserEvent;

use Yii;
use yii\base\Response;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;

class EventController extends \app\core\WebController
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
                        'actions' => ['create'],
                        'roles' => [Item::ROLE_MEMBER],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'index',
                            'view'
                        ],
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
     * Render the main event listing page
     *
     * @return Response
     */
    public function actionIndex(): Response
    {
        $eventFilterModel = new EventFilterSearch;
        $eventDataProvider = $eventFilterModel->search($this->request->queryParams);

        return $this->createResponse('index', compact('eventFilterModel', 'eventDataProvider'));
    }

    /**
     * Action to view a single event
     * 
     * @return Response
     */
    public function actionView(int $event_id): Response
    {
        $event = Event::findOne($event_id);

        if ($event === null) {
            throw new BadRequestHttpException('Invalid Event');
        }

        return $this->createResponse('view', compact('event'));
    }

    /**
     * Action for creating a new event
     * 
     * @return Response
     */
    public function actionCreate(): Response
    {
        $event = new Event;

        if ($this->request->isPost) {
            $query = Event::find()
                ->where(['artist_id' => $this->request->post()['Event']['artist_id']])
                ->andWhere(['venue_id' => $this->request->post()['Event']['venue_id']]);

            $userEvent = new UserEvent;

            if ($query->exists()) {
                $event = $query->one();

                $userEventQuery = UserEvent::find()
                    ->where(['event_id' => $event->event_id])
                    ->andWhere(['user_id' => Yii::$app->user->id]);

                if (!$userEventQuery->exists()) {
                    $event->creations += 1;
                    $event->save();
                    $userEvent->updateAttributes([
                        'event_id' => $event->event_id,
                        'user_id' => Yii::$app->user->id
                    ]);
                } else {
                    $userEvent = $userEventQuery->one();
                }
            } else {
                $event->load($this->request->post());

                if ($event->save()) {
                    $userEvent->updateAttributes([
                        'event_id' => $event->event_id,
                        'user_id' => Yii::$app->user->id
                    ]);
                }
            }

            if ($userEvent->save()) {
                Yii::$app->session->addFlash('success', 'Event successfully created');
                return $this->redirect('/event');
            }

            throw new BadRequestHttpException('Unable to create your event');
        }

        return $this->createResponse('create', compact('event'));
    }

}
