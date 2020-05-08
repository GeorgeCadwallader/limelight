<?php

declare(strict_types = 1);

namespace app\helpers;

use app\auth\Item;
use app\models\Artist;
use app\models\ReviewArtist;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * Artist helper class
 */
class ArtistHelper
{

    /**
     * Gets the image url for the artist
     * 
     * @param Artist $artist
     * @return string
     */
    public static function imageUrl(Artist $artist): string
    {
        if ($artist->data->profile_path !== null) {
            return '/images/artist/'.$artist->data->profile_path;
        }

        return '/images/logo.png';
    }

    /**
     * Gets the average score of the rating for the artist
     * 
     * @param Artist $artist
     * @param string $type
     * @return string
     */
    public static function averageRating(Artist $artist, string $type): float
    {
        $ratingsQuery = ReviewArtist::find()
            ->where(['artist_id' => $artist->artist_id])
            ->andWhere(['status' => ReviewArtist::STATUS_ACTIVE]);

        if ($ratingsQuery->exists()) {
            $ratings = ArrayHelper::map($ratingsQuery->all(), 'review_artist_id', $type);
    
            $average = array_sum($ratings)/count($ratings);
    
            return $average;
        }

        return 0;
    }

    /**
     * Checks to see if the current user can edit an artist page
     * 
     * @param Artist $artist
     * @return string
     */
    public static function canEdit(Artist $artist): bool
    {
        if (Yii::$app->user->isGuest) {
            return false;
        }

        if (Yii::$app->user->can(Item::ROLE_ADMIN) || $artist->managed_by === Yii::$app->user->id) {
            return true;
        }

        return false;
    }

    /**
     * Gets the status colour for an artist when comparing
     * 
     * @param Artist $artistOne
     * @param Artist $artistTwo
     * 
     * @return string
     */
    public static function getCompareColorArtistOne(Artist $artistOne, Artist $artistTwo, string $type): string
    {
        $artistOneRating = self::averageRating($artistOne, $type);
        $artistTwoRating = self::averageRating($artistTwo, $type);

        if ($artistOneRating > $artistTwoRating) {
            return 'bg-primary';
        }

        if ($artistOneRating < $artistTwoRating) {
            return 'bg-danger';
        }

        return 'bg-warning';
    }

    /**
     * Gets the status colour for an artist when comparing
     * 
     * @param Artist $artistOne
     * @param Artist $artistTwo
     * 
     * @return string
     */
    public static function getCompareColorArtistTwo(Artist $artistOne, Artist $artistTwo, string $type): string
    {
        $artistOneRating = self::averageRating($artistOne, $type);
        $artistTwoRating = self::averageRating($artistTwo, $type);

        if ($artistOneRating < $artistTwoRating) {
            return 'bg-primary';
        }

        if ($artistOneRating > $artistTwoRating) {
            return 'bg-danger';
        }

        return 'bg-warning';
    }

    /**
     * Get the social buttons for an Artist
     * 
     * @param Artist $artist
     * 
     * @return string
     */
    public static function getShareButtons(Artist $artist): string
    {
        $appName = Yii::$app->name;
        $artistHashtag = str_replace(' ', '', $artist->name);
        $artistUrl = Yii::$app->urlManager->createAbsoluteUrl(
            [
                '/artist/view',
                'artist_id' => $artist->artist_id
            ]
        );

        $twitter = Html::button(
            Html::icon('twitter'),
            [
                'class' => 'btn btn-primary mr-2 mb-2',
                'data-sharer' => 'twitter',
                'data-title' => 'Check out '.$artist->name.' on '.$appName.'!',
                'data-url' => $artistUrl,
                'data-hashtags' => "{$artistHashtag}, {$appName}"
            ]
        );

        $facebook = Html::button(
            Html::icon('facebook'),
            [
                'class' => 'btn btn-primary mr-2 mb-2',
                'data-sharer' => 'facebook',
                'data-url' => $artistUrl,
                'data-hashtags' => "{$artistHashtag}, {$appName}"
            ]
        );

        $linkedIn = Html::button(
            Html::icon('linkedin'),
            [
                'class' => 'btn btn-primary mr-2 mb-2',
                'data-sharer' => 'linkedin',
                'data-url' => $artistUrl
            ]
        );

        $email = Html::button(
            Html::icon('envelope'),
            [
                'class' => 'btn btn-primary mr-2 mb-2',
                'data-sharer' => 'email',
                'data-url' => $artistUrl,
                'data-title' => 'Check out '.$artist->name.' on '.$appName.'!',
                'data-subject' => $artist->name.' on '.$appName
            ]
        );

        $whatsApp = Html::button(
            Html::icon('whatsapp'),
            [
                'class' => 'btn btn-primary mb-2',
                'data-sharer' => 'whatsapp',
                'data-title' => 'Check out '.$artist->name.' on '.$appName.'!',
                'data-url' => $artistUrl
            ]
        );

        return $twitter.$facebook.$linkedIn.$email.$whatsApp;
    }

}