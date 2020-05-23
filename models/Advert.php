<?php

namespace app\models;

use app\behaviors\TimestampBehavior;

use yii\behaviors\BlameableBehavior;
use yii\db\ActiveQueryInterface;

/**
 * Model class for table "advert"
 * 
 * @property integer $advert_id
 * @property integer $fk
 * @property integer $type
 * @property string $message
 * @property integer $appearances
 * @property integer $advert_type
 * @property integer $status
 * @property Moment $created_at
 * @property Moment $updated_at
 * @property Moment $created_by
 * @property Moment $updated_by
 */
class Advert extends \yii\db\ActiveRecord
{

    /**
     * Type definitions
     */
    const TYPE_ARTIST = 1;
    const TYPE_VENUE = 2;

    /**
     * Type array
     */
    public static $types = [
        self::TYPE_ARTIST => 'Artist',
        self::TYPE_VENUE => 'Venue'
    ];

    /**
     * Advert types
     */
    const ADVERT_TYPE_GLOBAL = 1;
    const ADVERT_TYPE_LOCATION = 2;
    const ADVERT_TYPE_GENRE = 3;

    /**
     * Advert types array
     */
    public static $advertTypes = [
        self::ADVERT_TYPE_GLOBAL => 'Global',
        self::ADVERT_TYPE_LOCATION => 'Location',
        self::ADVERT_TYPE_GENRE => 'Genre'
    ];

    /**
     * Advert types price array
     */
    public static $advertTypeCost = [
        self::ADVERT_TYPE_GLOBAL => '5.00',
        self::ADVERT_TYPE_LOCATION => '2.50',
        self::ADVERT_TYPE_GENRE => '2.50'
    ];

    /**
     * Status definitions
     */
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;

    /**
     * Status type array
     */
    public static $statuses = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_INACTIVE => 'Inactive'
    ];

    /**
     * @inheritDoc
     */
    public static function tableName(): string
    {
        return '{{%advert}}';
    }

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            [
                [
                    'fk',
                    'type',
                    'appearances',
                    'advert_type',
                    'status'
                ],
                'integer'
            ],
            [['message'], 'string', 'max' => 1200],
            ['type', 'in', 'range' => array_keys(self::$types)],
            ['advert_type', 'in', 'range' => array_keys(self::$advertTypes)],
            ['status', 'in', 'range' => array_keys(self::$statuses)]
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
     * Get the artist related to this advert
     * 
     * @return ActiveQueryInterface
     */
    public function getArtist(): ActiveQueryInterface
    {
        return $this->hasOne(Artist::class, ['artist_id' => 'fk'])
            ->onCondition(['type' => self::TYPE_ARTIST]);
    }

    /**
     * Get the venue related to this advert
     * 
     * @return ActiveQueryInterface
     */
    public function getVenue(): ActiveQueryInterface
    {
        return $this->hasOne(Venue::class, ['venue_id' => 'fk'])
            ->onCondition(['type' => self::TYPE_VENUE]);
    }

}