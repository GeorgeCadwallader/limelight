<?php

declare(strict_types = 1);

namespace app\models;

use app\behaviors\TimestampBehavior;
use app\models\Artist;
use app\models\Venue;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveQueryInterface;

/**
 * This is the model class for table "owner_request"
 * 
 * @property integer $owner_request_id
 * @property integer $fk
 * @property integer $type
 * @property Moment $created_by
 * @property Moment $updated_by
 * @property Moment $created_at
 * @property Moment $updated_at
 */
class OwnerRequest extends \yii\db\ActiveRecord
{

    const TYPE_ARTIST = 1;
    const TYPE_VENUE = 2;

    /**
     * Type array
     */
    public static $types = [
        self::TYPE_ARTIST => 'Artist',
        self::TYPE_VENUE => 'Venue',
    ];

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%owner_request}}';
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
                    'type'
                ],
                'integer'
            ],
            ['type', 'in', 'range' => array_keys(self::$types)],
        ];
    }

    /**
     * @inheritDoc
     */
    public function behaviors(): array
    {
        return [
            ['class' => TimestampBehavior::class],
            ['class' => BlameableBehavior::class]
        ];
    }

    /**
     * @inheritDoc
     */
    public function attributeLabels(): array
    {
        return [
            'fk' => 'Page'
        ];
    }

    /**
     * Gets the artist relating to this request
     * 
     * @return ActiveQueryInterface
     */
    public function getArtist(): ActiveQueryInterface
    {
        return $this->hasOne(Artist::class, ['artist_id' => 'fk'])
            ->onCondition(['type' => self::TYPE_ARTIST]);
    }

    /**
     * Gets the venue relating to this request
     * 
     * @return ActiveQueryInterface
     */
    public function getVenue(): ActiveQueryInterface
    {
        return $this->hasOne(Venue::class, ['venue_id' => 'fk'])
            ->onCondition(['type' => self::TYPE_VENUE]);
    }

}