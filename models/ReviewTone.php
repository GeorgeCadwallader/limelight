<?php

declare(strict_types = 1);

namespace app\models;

use app\behaviors\TimestampBehavior;

use yii\behaviors\BlameableBehavior;
use yii\db\ActiveQueryInterface;

/**
 * This is the model class for table "review_tone"
 * 
 * @property integer $review_tone_id
 * @property integer $fk
 * @property integer $type
 * @property float $score
 * @property string $tone
 * @property Moment $created_by
 * @property Moment $updated_by
 * @property Moment $created_at
 * @property Moment $updated_at
 */
class ReviewTone extends \yii\db\ActiveRecord
{

    /**
     * Review type constants
     */
    const TYPE_ARTIST = 1;
    const TYPE_VENUE = 2;

    /**
     * Tone types
     */
    const TONE_TYPE_ANGER = 'anger';
    const TONE_TYPE_FEAR = 'fear';
    const TONE_TYPE_JOY = 'joy';
    const TONE_TYPE_SADNESS = 'sadness';
    const TONE_TYPE_ANALYTICAL = 'analytical';
    const TONE_TYPE_CONFIDENT = 'confident';
    const TONE_TYPE_TENTATIVE = 'tentative';

    /**
     * Array of review types
     */
    public static $types = [
        self::TYPE_ARTIST => 'Artist',
        self::TYPE_VENUE => 'Venue'
    ];

    /**
     * Array of tone types
     */
    public static $toneTypes = [
        1 => self::TONE_TYPE_ANGER,
        2 => self::TONE_TYPE_FEAR,
        3 => self::TONE_TYPE_JOY,
        4 => self::TONE_TYPE_SADNESS,
        5 => self::TONE_TYPE_ANALYTICAL,
        6 => self::TONE_TYPE_CONFIDENT,
        7 => self::TONE_TYPE_TENTATIVE
    ];

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%review_tone}}';
    }

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            [['score'], 'double'],
            [
                [
                    'fk',
                    'type'
                ],
                'integer'
            ],
            [['tone'], 'string', 'max' => 255],
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
            ['class' => BlameableBehavior::class],
        ];
    }

    /**
     * Get the user that has created this review tone
     *
     * @return ActiveQueryInterface
     */
    public function getCreator(): ActiveQueryInterface
    {
        return $this->hasOne(User::class, ['user_id' => 'created_by']);
    }

    /**
     * Get the artist review related to this entry
     */
    public function getArtistReview(): ActiveQueryInterface
    {
        return $this->hasOne(ReviewArtist::class, ['review_artist_id' => 'fk'])
            ->onCondition(['type' => self::TYPE_ARTIST]);
    }

    /**
     * Get the venue review related to this entry
     */
    public function getVenueReview(): ActiveQueryInterface
    {
        return $this->hasOne(ReviewVenue::class, ['review_venue_id' => 'fk'])
            ->onCondition(['type' => self::TYPE_VENUE]);
    }

}
