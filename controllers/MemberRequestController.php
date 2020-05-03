<?php

namespace app\controllers;

use app\auth\Item;
use app\models\Artist;
use app\models\ArtistData;
use app\models\MemberRequest;
use app\models\Venue;
use app\models\VenueData;
use Yii;
use yii\base\Response;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;

class MemberRequestController extends \app\core\WebController
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
                        'actions' => [
                            'create',
                        ],
                        'roles' => [Item::ROLE_MEMBER],
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
     * Creates a request to create an artist or venue page
     * 
     * @return Response
     */
    public function actionCreate(int $type): Response
    {
        $url = ($type === MemberRequest::TYPE_ARTIST_REQUEST) ? '/artist' : '/venue';

        $query = MemberRequest::find()
            ->where(['request_name' => $this->request->post()['MemberRequest']['request_name']])
            ->andWhere(['type' => $type]);

        if ($query->exists()) {
            $memberRequest = $query->one();
            $memberRequest->request_count += 1;

            if ($memberRequest->save()) {
                Yii::$app->session->addFlash('success', 'Your request has successfully been created');
                return $this->redirect($url);
            }
        }

        $memberRequest = new MemberRequest([
            'status' => MemberRequest::STATUS_ACTIVE,
            'type' => $type
        ]);

        $memberRequest->load($this->request->post());

        if ($memberRequest->save()) {
            Yii::$app->session->addFlash('success', 'Your request has successfully been created');
            return $this->redirect($url);
        }

        throw new BadRequestHttpException('There was a problem creating your request');
    }

    /**
     * Set a status of a member request
     * 
     * @param int $member_request_id
     * @param int $status
     * 
     * @return Response
     */
    public function actionSetStatus(int $member_request_id, int $status): Response
    {
        $memberRequest = MemberRequest::findOne($member_request_id);

        if ($memberRequest === null) {
            throw new BadRequestHttpException('Invalid Member Request');
        }

        $memberRequest->status = $status;

        if ($memberRequest->save()) {
            Yii::$app->session->addFlash('Member Request successfully updated');
            return $this->redirect('/admin/member-requests');
        }

        throw new BadRequestHttpException('Unable to update the status of the member request');
    }

    /**
     * Approves a request and creates the artist or venue page
     * 
     * @param int $member_request_id
     * 
     * @return Response
     */
    public function actionApproveRequest(int $member_request_id, int $type): Response
    {
        $memberRequest = MemberRequest::findOne($member_request_id);

        if ($memberRequest === null) {
            throw new BadRequestHttpException('Invalid Member Request');
        }

        if ($type === MemberRequest::TYPE_ARTIST_REQUEST) {
            if (self::createArtist($memberRequest)) {
                Yii::$app->session->addFlash('success', 'Request successfully approved and artist created');
                return $this->redirect('/admin/member-requests');
            }

            throw new BadRequestHttpException('Invalid request when creating artist');
        } else if ($type === MemberRequest::TYPE_VENUE_REQUEST) {
            if (self::createVenue($memberRequest)) {
                Yii::$app->session->addFlash('success', 'Request successfully approved and venue created');
                return $this->redirect('/admin/member-requests');
            }

            throw new BadRequestHttpException('Invalid request when creating venue');
        }

        throw new BadRequestHttpException('Invalid Request Type');
    }

    /**
     * Creates a artist page based off of a request
     * 
     * @param MemberRequest $memberRequest
     * 
     * @return bool
     */
    private function createArtist(MemberRequest $memberRequest): bool
    {
        $query = Artist::find()->where(['name' => $memberRequest->request_name]);

        if (!$query->exists()) {
            $memberRequest->status = MemberRequest::STATUS_APPROVED;

            $artist = new Artist(
                [
                    'name' => $memberRequest->request_name,
                    'status' => Artist::STATUS_ACTIVE
                ]
            );
            
            if ($memberRequest->save() && $artist->save()) {
                $artistData = new ArtistData;
                $artist->link('data', $artistData);

                return true;
            }
        }

        return false;
    }
    
    /**
     * Creates a venue page based off of a request
     * 
     * @param MemberRequest $memberRequest
     * 
     * @return bool
     */
    private function createVenue(MemberRequest $memberRequest): bool
    {
        $query = Venue::find()->where(['name' => $memberRequest->request_name]);

        if (!$query->exists()) {
            $memberRequest->status = MemberRequest::STATUS_APPROVED;

            $venue = new Venue(
                [
                    'name' => $memberRequest->request_name,
                    'status' => Venue::STATUS_ACTIVE
                ]
            );
            
            if ($memberRequest->save() && $venue->save()) {
                $venueData = new VenueData;
                $venue->link('data', $venueData);

                return true;
            }
        }

        return false;
    }

}
