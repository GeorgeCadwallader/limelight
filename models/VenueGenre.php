<?php

declare(strict_types = 1);

namespace app\models;

use app\behaviors\TimestampBehavior;

use yii\behaviors\BlameableBehavior;
use yii\db\ActiveQueryInterface;

/**
 * This is the model class for table "venue_genre"
 * 
 * @property integer $venue_genre_id
 * @property integer $venue_id
 * @property integer $genre_id
 * @property Moment $created_by
 * @property Moment $updated_by
 * @property Moment $created_at
 * @property Moment $updated_at
 */
class VenueGenre extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%venue_genre}}';
    }

    /**
     * @inheritDoc
     */
    public function behaviors(): array
    {
        return [
            ['class' => TimestampBehavior::class],
            ['class' => BlameableBehavior::class],
        ];
    }

    /**
     * Gets the genre linked to this venue
     * 
     * @return ActiveQueryInterface
     */
    public function getGenre(): ActiveQueryInterface
    {
        return $this->hasOne(Genre::class, ['genre_id' => 'genre_id']);
    }

    /**
     * Get the venue linked to this genre
     * 
     * @return ActiveQueryInterface
     */
    public function getVenue(): ActiveQueryInterface
    {
        return $this->hasOne(Venue::class, ['venue_id' => 'venue_id']);
    }

}
