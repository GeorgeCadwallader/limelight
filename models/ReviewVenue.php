<?php

declare(strict_types = 1);

namespace app\models;

use app\behaviors\TimestampBehavior;
use app\helpers\BadgeHelper;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveQueryInterface;

/**
 * This is the model class for table "review_venue"
 * 
 * @property integer $review_venue_id
 * @property integer $venue_id
 * @property string $content
 * @property float $overall_rating
 * @property integer $upvotes
 * @property integer $downvotes
 * @property integer $status
 * @property Moment $created_by
 * @property Moment $updated_by
 * @property Moment $created_at
 * @property Moment $updated_at
 */
class ReviewVenue extends \yii\db\ActiveRecord
{

    const STATUS_ACTIVE = 10;
    const STATUS_QUARANTINED = 2;
    const STATUS_DEACTIVATED = 3;

    /**
     * Array of review statuses
     */
    public static $statuses = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_QUARANTINED => 'Quarantined',
        self::STATUS_DEACTIVATED => 'Deactivated',
    ];

    /**
     * Review criteria definitions
     */
    const REVIEW_VENUE_OVERALL = 'overall_rating';
    const REVIEW_VENUE_SERVICE = 'service';
    const REVIEW_VENUE_LOCATION = 'location';
    const REVIEW_VENUE_VALUE = 'value';
    const REVIEW_VENUE_CLEANLINESS = 'cleanliness';
    const REVIEW_VENUE_SIZE = 'size';

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%review_venue}}';
    }

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            [
                [
                    'overall_rating',
                    'service',
                    'location',
                    'value',
                    'cleanliness',
                    'size'
                ],
                'double',
                'max' => 5,
                'min' => 0
            ],
            [
                [
                    'upvotes',
                    'downvotes',
                    'status'
                ],
                'integer'
            ],
            [['content'], 'string', 'max' => 255],
            ['status', 'in', 'range' => array_keys(self::$statuses)],
            ['venue_id', 'exist', 'targetRelation' => 'venue'],
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
            'content' => 'Review content'
        ];
    }

    /**
     * @inheritDoc
     */
    public function attributeHints(): array
    {
        return [
            'overall_rating' => 'Your overall rating of the venue',
            'service' => 'How was the facilities of the venue?',
            'location' => 'How was it getting to the venue?',
            'value' => 'Was the venue expensive?',
            'cleanliness' => 'How clean was the venue?',
            'size' => 'How spacious is the venue?'
        ];
    }

    /**
     * @inheritDoc
     */
    public function afterSave($insert, $changedAttributes): void
    {
        parent::afterSave($insert, $changedAttributes);

        if ($insert) {
            if (count($this->creator->venueReview) >= UserBadge::COUNT_AMATUER_VENUE_REVIEWER) {
                $user = User::findOne($this->created_by);

                BadgeHelper::addBadge($user, UserBadge::TYPE_AMATUER_VENUE_REVIEWER);
            }
        }
    }

    /**
     * Get the user that has created this review
     *
     * @return ActiveQueryInterface
     */
    public function getCreator(): ActiveQueryInterface
    {
        return $this->hasOne(User::class, ['user_id' => 'created_by']);
    }

    /**
     * Get the venue that this review is connected to
     *
     * @return ActiveQueryInterface
     */
    public function getVenue(): ActiveQueryInterface
    {
        return $this->hasOne(Venue::class, ['venue_id' => 'venue_id']);
    }

}
