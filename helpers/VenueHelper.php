<?php

declare(strict_types = 1);

namespace app\helpers;

use app\auth\Item;
use app\models\Venue;
use app\models\ReviewVenue;

use Yii;
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
        if ($venue->data->profile_path !== null) {
            return '/images/venue/'.$venue->data->profile_path;
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

    /**
     * Checks to see if the current user can edit a venue page
     * 
     * @param Venue $venue
     * @return string
     */
    public static function canEdit(Venue $venue): bool
    {
        if (Yii::$app->user->isGuest) {
            return false;
        }

        if (Yii::$app->user->can(Item::ROLE_ADMIN) || $venue->managed_by === Yii::$app->user->id) {
            return true;
        }

        return false;
    }

}