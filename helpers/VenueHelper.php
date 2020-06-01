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
            return 'bg-off-white';
        }

        if ($venueOneRating == 0 && $venueTwoRating == 0) {
            return 'bg-off-white';
        }

        return 'bg-primary';
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
            return 'bg-off-white';
        }

        if ($venueOneRating == 0  && $venueTwoRating == 0) {
            return 'bg-off-white';
        }

        return 'bg-primary';
    }

    /**
     * Get the social buttons for an Venue
     * 
     * @param Venue $venue
     * 
     * @return string
     */
    public static function getShareButtons(Venue $venue): string
    {
        $appName = Yii::$app->name;
        $venueHashtag = str_replace(' ', '', $venue->name);
        $venueUrl = Yii::$app->urlManager->createAbsoluteUrl(
            [
                '/venue/view',
                'venue_id' => $venue->venue_id
            ]
        );

        $twitter = Html::button(
            Html::icon('twitter'),
            [
                'class' => 'btn btn-primary mr-2 mb-2',
                'data-sharer' => 'twitter',
                'data-title' => 'Check out '.$venue->name.' on '.$appName.'!',
                'data-url' => $venueUrl,
                'data-hashtags' => "{$venueHashtag}, {$appName}"
            ]
        );

        $facebook = Html::button(
            Html::icon('facebook'),
            [
                'class' => 'btn btn-primary mr-2 mb-2',
                'data-sharer' => 'facebook',
                'data-url' => $venueUrl,
                'data-hashtags' => "{$venueHashtag}, {$appName}"
            ]
        );

        $linkedIn = Html::button(
            Html::icon('linkedin'),
            [
                'class' => 'btn btn-primary mr-2 mb-2',
                'data-sharer' => 'linkedin',
                'data-url' => $venueUrl
            ]
        );

        $email = Html::button(
            Html::icon('envelope'),
            [
                'class' => 'btn btn-primary mr-2 mb-2',
                'data-sharer' => 'email',
                'data-url' => $venueUrl,
                'data-title' => 'Check out '.$venue->name.' on '.$appName.'!',
                'data-subject' => $venue->name.' on '.$appName
            ]
        );

        $whatsApp = Html::button(
            Html::icon('whatsapp'),
            [
                'class' => 'btn btn-primary mb-2',
                'data-sharer' => 'whatsapp',
                'data-title' => 'Check out '.$venue->name.' on '.$appName.'!',
                'data-url' => $venueUrl
            ]
        );

        return $twitter.$facebook.$linkedIn.$email.$whatsApp;
    }

    /**
     * Get the verify tick if venue page is owned
     * 
     * @param Venue $venue
     * 
     * @return string
     */
    public static function verifiedVenueOwner(Venue $venue): string
    {
        if ($venue->managed_by === null) {
            return '';
        }

        return Html::tag(
            'span',
            Html::icon('check').Html::tag('div', 'This venue is managed by a real owner!', ['class' => 'tooltip']),
            [
                'class' => 'verify-icon btn btn-primary btn-sm',
            ]
        );
    }

    /**
     * Check to see if user is venue owner with active venue
     */
    public static function isOwner(): bool
    {
        if (Yii::$app->user->isGuest) {
            return false;
        }

        $ownerQuery = Venue::find()
            ->where(['managed_by' => Yii::$app->user->id])
            ->andWhere(['status' => Venue::STATUS_ACTIVE]);

        if (Yii::$app->user->can(Item::ROLE_VENUE_OWNER) && $ownerQuery->exists()) {
            return true;
        }

        return false;
    }

}