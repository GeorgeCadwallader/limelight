<?php

declare(strict_types = 1);

namespace app\helpers;

use app\models\Venue;
use app\models\ReviewVenue;
use yii\helpers\ArrayHelper;

/**
 * Venue helper class
 */
class VenueHelper
{

    /**
     * Gets the image url for the venue
     * 
     * @param Venue $venue
     * @return string
     */
    public static function imageUrl(Venue $venue): string
    {
        if ($venue->profile_path !== null) {
            return '/images/venue/'.$venue->profile_path;
        }

        return '/images/logo.png';
    }

    /**
     * Gets the average score of the overall rating for the venue
     * 
     * @param Venue $venue
     * @return string
     */
    public static function averageOverallRating(Venue $venue): float
    {
        $ratingsQuery = ReviewVenue::find()
            ->where(['venue_id' => $venue->venue_id])
            ->andWhere(['status' => ReviewVenue::STATUS_ACTIVE]);

        if ($ratingsQuery->exists()) {
            $ratings = ArrayHelper::map($ratingsQuery->all(), 'review_venue_id', 'overall_rating');
    
            $average = array_sum($ratings)/count($ratings);
    
            return $average;
        }

        return 0;
    }

}