<?php

declare(strict_types = 1);

namespace app\models;

use app\behaviors\TimestampBehavior;

use yii\behaviors\BlameableBehavior;
use yii\db\ActiveQueryInterface;

/**
 * This is the model class for table "review_report"
 * 
 * @property integer $review_report_id
 * @property integer $fk
 * @property integer $type
 * @property integer $context
 * @property integer $status
 * @property Moment $created_by
 * @property Moment $updated_by
 * @property Moment $created_at
 * @property Moment $updated_at
 */
class ReviewReport extends \yii\db\ActiveRecord
{

    /**
     * Review Report type constants
     */
    const TYPE_ARTIST = 1;
    const TYPE_VENUE = 2;

    /**
     * Array of review report types
     */
    public static $types = [
        self::TYPE_ARTIST => 'Artist',
        self::TYPE_VENUE => 'Venue'
    ];

    /**
     * Context types for review report
     */
    const CONTEXT_OFFENSIVE = 1;
    const CONTEXT_UNRELATED = 2;
    const CONTEXT_OTHER = 3;

    /**
     * Array of context types
     */
    public static $contexts = [
        self::CONTEXT_OFFENSIVE => 'Offensive material',
        self::CONTEXT_UNRELATED => 'Unrelated content',
        self::CONTEXT_OTHER => 'Other'
    ];

    /**
     * Status type definitions
     */
    const STATUS_ACTIVE = 1;
    const STATUS_RESOLVED = 2;

    public static $statuses = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_RESOLVED => 'Resolved'
    ];

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%review_report}}';
    }

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            [['context'], 'required', 'message' => 'You must select a reason'],
            [
                [
                    'fk',
                    'type',
                    'context',
                    'status'
                ],
                'integer'
            ],
            ['type', 'in', 'range' => array_keys(self::$types)],
            ['status', 'in', 'range' => array_keys(self::$statuses)],
            ['context', 'in', 'range' => array_keys(self::$contexts)],
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
            'context' => 'Please select the reason why you are reporting this review'
        ];
    }

    /**
     * Get the user that has created this review report
     *
     * @return ActiveQueryInterface
     */
    public function getCreator(): ActiveQueryInterface
    {
        return $this->hasOne(User::class, ['user_id' => 'created_by']);
    }

    /**
     * Get the review_artist that is related to this report
     */
    public function getReviewArtist(): ActiveQueryInterface
    {
        return $this->hasOne(ReviewArtist::class, ['review_artist_id' => 'fk'])
            ->onCondition(['type' => self::TYPE_ARTIST]);
    }
    
    /**
     * Get the review_venue that is related to this report
     */
    public function getReviewVenue(): ActiveQueryInterface
    {
        return $this->hasOne(ReviewVenue::class, ['review_venue_id' => 'fk'])
            ->onCondition(['type' => self::TYPE_VENUE]);
    }

}
