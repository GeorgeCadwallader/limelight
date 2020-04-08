<?php

namespace app\models;

use app\behaviors\TimestampBehavior;

use yii\behaviors\BlameableBehavior;
use yii\db\ActiveQueryInterface;

/**
 * This is the model class for table "event"
 * 
 * @property integer $event_id
 * @property integer $artist_id
 * @property integer $venue_id
 * @property integer $creations
 * @property Moment $created_at
 * @property Moment $updated_at
 * @property Moment $created_by
 * @property Moment $updated_by
 */
class Event extends \yii\db\ActiveRecord
{
    
    /**
     * @inheritDoc
     */
    public static function tableName(): string
    {
        return '{{%event}}';
    }

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            [['creations'], 'integer'],
            ['artist_id', 'exist', 'targetRelation' => 'Artist'],
            ['venue_id', 'exist', 'targetRelation' => 'Venue'],
        ];
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
     * @inheritDoc
     */
    public function attributeLabels(): array
    {
        return [
            'artist_id' => 'Artist',
            'venue_id' => 'Venue'
        ];
    }

    /**
     * Get the artist related to this event
     * 
     * @return ActiveQueryInterface
     */
    public function getArtist(): ActiveQueryInterface
    {
        return $this->hasOne(Artist::class, ['artist_id' => 'artist_id']);
    }

    /**
     * Get the venue related to this event
     * 
     * @return ActiveQueryInterface
     */
    public function getVenue(): ActiveQueryInterface
    {
        return $this->hasOne(Venue::class, ['venue_id' => 'venue_id']);
    }

    /**
     * Get the user_events related to this event
     * 
     * @return ActiveQueryInterface
     */
    public function getUserEvents(): ActiveQueryInterface
    {
        return $this->hasMany(UserEvent::class, ['event_id' => 'event_id']);
    }

}