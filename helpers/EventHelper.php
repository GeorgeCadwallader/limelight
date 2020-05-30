<?php

declare(strict_types = 1);

namespace app\helpers;

use app\models\Event;
use app\models\ReviewArtist;
use app\models\ReviewVenue;
use app\models\Venue;
use app\models\Artist;

use yii\helpers\ArrayHelper;

/**
 * Event helper class
 */
class EventHelper
{

    /**
     * Gets the image url for the event
     * 
     * @param Event $event
     * @return string
     */
    public static function imageUrl(Event $event): string
    {
        if ($event->artist->data->profile_path !== null) {
            return '/images/artist/'.$event->artist->data->profile_path;
        }

        if ($event->venue->data->profile_path !== null) {
            return '/images/venue/'.$event->venue->data->profile_path;
        }

        return '/images/logo.png';
    }

    /**
     * Creates the event name
     * 
     * @param Event $event
     * @return string
     */
    public static function eventName(Event $event): string
    {
        return $event->artist->name.' - '.$event->venue->name;
    }

    /**
     * Generates overall rating of artist and venue overall rating
     * 
     * @param Artist $artist
     * @param Venue $venue
     * 
     * @return float
     */
    public static function combinedAverage(Artist $artist, Venue $venue): float
    {
        $ratings = [];

        $ratingsArtistQuery = ReviewArtist::find()
            ->where(['artist_id' => $artist->artist_id])
            ->andWhere(['status' => ReviewArtist::STATUS_ACTIVE]);

        if ($ratingsArtistQuery->exists()) {
            $ratings += ArrayHelper::map($ratingsArtistQuery->all(), 'review_artist_id', ReviewArtist::REVIEW_ARTIST_OVERALL);
        }

        $ratingsVenueQuery = ReviewVenue::find()
            ->where(['venue_id' => $venue->venue_id])
            ->andWhere(['status' => ReviewVenue::STATUS_ACTIVE]);

        if ($ratingsVenueQuery->exists()) {
            $ratings += ArrayHelper::map($ratingsVenueQuery->all(), 'review_venue_id', ReviewVenue::REVIEW_VENUE_OVERALL);
        }

        if (!empty($ratings)) {
            return array_sum($ratings)/count($ratings);
        }

        return 0;
    }

}