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
     * Gets the average score of the rating for the venue
     * 
     * @param Venue $venue
     * @return string
     */
    public static function averageRating(Venue $venue, string $type): float
    {
        $ratingsQuery = ReviewVenue::find()
            ->where(['venue_id' => $venue->venue_id])
            ->andWhere(['status' => ReviewVenue::STATUS_ACTIVE]);

        if ($ratingsQuery->exists()) {
            $ratings = ArrayHelper::map($ratingsQuery->all(), 'review_venue_id', $type);
    
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

    /**
     * Gets the status colour for an venue when comparing
     * 
     * @param Venue $venueOne
     * @param Venue $artistTwo
     * 
     * @return string
     */
    public static function getCompareColorVenueOne(Venue $venueOne, Venue $venueTwo, string $type): string
    {
        $venueOneRating = self::averageRating($venueOne, $type);
        $venueTwoRating = self::averageRating($venueTwo, $type);

        if ($venueOneRating > $venueTwoRating) {
            return 'bg-primary';
        }

        if ($venueOneRating < $venueTwoRating) {
            return 'bg-danger';
        }

        return 'bg-warning';
    }

    /**
     * Gets the status colour for an venue when comparing
     * 
     * @param Venue $venueOne
     * @param Venue $artistTwo
     * 
     * @return string
     */
    public static function getCompareColorVenueTwo(Venue $venueOne, Venue $venueTwo, string $type): string
    {
        $venueOneRating = self::averageRating($venueOne, $type);
        $venueTwoRating = self::averageRating($venueTwo, $type);

        if ($venueOneRating < $venueTwoRating) {
            return 'bg-primary';
        }

        if ($venueOneRating > $venueTwoRating) {
            return 'bg-danger';
        }

        return 'bg-warning';
    }

}