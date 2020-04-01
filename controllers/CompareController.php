<?php

namespace app\controllers;

use app\models\Artist;
use app\models\Venue;

use yii\base\Response;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;

/**
 * Class for the compare actions
 */
class CompareController extends \app\core\WebController
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
                            'artist',
                            'venue'
                        ]
                    ]
                ],
            ]
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
     * Index action for the compare controller
     * 
     * @return Response
     */
    public function actionIndex(): Response
    {
        return $this->createResponse('index');
    }

    /**
     * Render the comparison page for artists
     * 
     * @param int $artist_id_one
     * @param int $artist_id_two
     * 
     * @return Response
     */
    public function actionArtist(int $artist_id_one = null, int $artist_id_two = null): Response
    {
        if ($artist_id_one === null && $artist_id_two === null) {
            return $this->createResponse('artist-compare-empty');
        }

        if ($artist_id_one === $artist_id_two) {
            throw new BadRequestHttpException('You can not compare the same artist');
        }

        if ($artist_id_one !== null && $artist_id_two === null) {
            $artistOne = Artist::findOne($artist_id_one);

            if ($artistOne === null) {
                throw new BadRequestHttpException('Invalid artist');
            }

            return $this->createResponse('artist-compare-one', compact('artistOne'));
        }

        if ($artist_id_two !== null && $artist_id_one === null) {
            $artistTwo = Artist::findOne($artist_id_two);

            if ($artistTwo === null) {
                throw new BadRequestHttpException('Invalid artist');
            }

            return $this->createResponse('artist-compare-two', compact('artistTwo'));
        }

        $artistOne = Artist::findOne($artist_id_one);
        $artistTwo = Artist::findOne($artist_id_two);

        if ($artistOne === null || $artistTwo === null) {
            throw new BadRequestHttpException('Invalid artist');
        }

        return $this->createResponse('artist-compare-both', compact('artistOne', 'artistTwo'));
    }

    /**
     * Render the comparison page for venues
     * 
     * @param int $venue_id_one
     * @param int $venue_id_two
     */
    public function actionVenue(int $venue_id_one = null, int $venue_id_two = null): Response
    {
        if ($venue_id_one === null && $venue_id_two === null) {
            return $this->createResponse('venue-compare-empty');
        }

        if ($venue_id_one === $venue_id_two) {
            throw new BadRequestHttpException('You can not compare the same venue');
        }

        if ($venue_id_one !== null && $venue_id_two === null) {
            $venueOne = Venue::findOne($venue_id_one);

            if ($venueOne === null) {
                throw new BadRequestHttpException('Invalid venue');
            }

            return $this->createResponse('venue-compare-one', compact('venueOne'));
        }

        if ($venue_id_two !== null && $venue_id_one === null) {
            $venueTwo = Venue::findOne($venue_id_two);

            if ($venueTwo === null) {
                throw new BadRequestHttpException('Invalid venue');
            }

            return $this->createResponse('venue-compare-two', compact('venueTwo'));
        }

        $venueOne = Venue::findOne($venue_id_one);
        $venueTwo = Venue::findOne($venue_id_two);

        if ($venueOne === null || $venueTwo === null) {
            throw new BadRequestHttpException('Invalid venue');
        }

        return $this->createResponse('venue-compare-both', compact('venueOne', 'venueTwo'));
    }

}