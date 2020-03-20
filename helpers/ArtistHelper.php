<?php

declare(strict_types = 1);

namespace app\helpers;

use app\models\Artist;
use app\models\ReviewArtist;
use yii\helpers\ArrayHelper;

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
        if ($artist->profile_path !== null) {
            return '/images/artist/'.$artist->profile_path;
        }

        return '/images/logo.png';
    }

    /**
     * Gets the average score of the overall rating for the artist
     * 
     * @param Artist $artist
     * @return string
     */
    public static function averageOverallRating(Artist $artist): float
    {
        $ratingsQuery = ReviewArtist::find()
            ->where(['artist_id' => $artist->artist_id])
            ->andWhere(['status' => ReviewArtist::STATUS_ACTIVE]);

        if ($ratingsQuery->exists()) {
            $ratings = ArrayHelper::map($ratingsQuery->all(), 'review_artist_id', 'overall_rating');
    
            $average = array_sum($ratings)/count($ratings);
    
            return $average;
        }

        return 0;
    }

}