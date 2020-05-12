<?php

declare(strict_types = 1);

namespace app\components;

use app\models\Artist;
use app\models\ReviewArtist;
use app\models\ReviewTone;
use app\models\Venue;
use yii\httpclient\Client;

/**
 * @category Project
 * @package Limelight
 * @author George Cadwallader <georgecadwallader77@gmail.com
 * @copyright 2020
 */
class ToneAnalyzer extends \yii\base\BaseObject
{

    /**
     * Send a review content off to the tone analyzer
     */
    public static function sendReview($review, int $type): void
    {
        if ($type === ReviewTone::TYPE_ARTIST) {
            $review_id = $review->review_artist_id;
        } else {
            $review_id = $review->review_venue_id;
        }

        $review = strip_tags($review->content);
        $content = [
            'text' => $review
        ];

        $client = new Client(['transport' => 'yii\httpclient\CurlTransport']);

        $response = $client->createRequest()
            ->setMethod('POST')
            ->setUrl([
                env('IBM_API_URL').'/v3/tone?version=2017-09-21',
            ])
            ->setHeaders(['Content-Type' => 'application/json'])
            ->setContent(json_encode($content))
            ->setOptions([CURLOPT_USERPWD => 'apikey:'.env('IBM_API_KEY')])
            ->send();

        $response = json_decode($response->content);

        $query = ReviewTone::find()
            ->where(['fk' => $review_id])
            ->andWhere(['type' => $type]);

        if ($query->exists()) {
            foreach ($query->all() as $reviewItem) {
                $reviewItem->delete();
            }
        }

        if (empty($response->document_tone->tones)) {
            return;
        }

        foreach ($response->document_tone->tones as $tone) {
            $reviewTone = new ReviewTone([
                'fk' => $review_id,
                'type' => $type,
                'score' => round($tone->score, 2),
                'tone' => $tone->tone_id
            ]);

            $reviewTone->save();
        }
    }

    /**
     * Generates a report for an event by getting the tonality of Artist and Venue
     * reviews
     * 
     * @param Artist $artist
     * @param Venue $venue
     * 
     * @return array
     */
    public static function generateEventReport(Artist $artist, Venue $venue): array
    {
        $reviews = array_merge($artist->reviews, $venue->reviews);

        $tonalities = [];

        foreach ($reviews as $review) {
            $query = ReviewTone::find();

            if ($review instanceof \app\models\ReviewArtist) {
                $query
                    ->where(['fk' => $review->review_artist_id])
                    ->andWhere(['type' => ReviewTone::TYPE_ARTIST])
                    ->select('tone');
            } elseif ($review instanceof \app\models\ReviewVenue) {
                $query
                    ->where(['fk' => $review->review_venue_id])
                    ->andWhere(['type' => ReviewTone::TYPE_VENUE])
                    ->select('tone');
            }
            
            if ($query->exists()) {
                foreach ($query->all() as $item) {
                    $tonalities[] = $item->tone;
                }
            }
        }

        return array_count_values($tonalities);
    }

}