<?php

declare(strict_types = 1);

namespace app\models;

use app\behaviors\TimestampBehavior;
use app\helpers\BadgeHelper;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveQueryInterface;

/**
 * This is the model class for table "review_artist"
 * 
 * @property integer $review_artist_id
 * @property integer $artist_id
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
class ReviewArtist extends \yii\db\ActiveRecord
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
    const REVIEW_ARTIST_OVERALL = 'overall_rating';
    const REVIEW_ARTIST_ENERGY = 'energy';
    const REVIEW_ARTIST_VOCALS = 'vocals';
    const REVIEW_ARTIST_SOUND = 'sound';
    const REVIEW_ARTIST_STAGE_PRESENCE = 'stage_presence';
    const REVIEW_ARTIST_SONG_AESTHETIC = 'song_aesthetic';

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%review_artist}}';
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
                    'energy',
                    'vocals',
                    'sound',
                    'stage_presence',
                    'song_aesthetic'
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
            ['artist_id', 'exist', 'targetRelation' => 'artist'],
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
            'overall_rating' => 'Your overall rating of the artist',
            'energy' => 'How energetic was the performance you saw?',
            'vocals' => 'How good did that artist sound?',
            'sound' => 'How did the rest of the performance sound?',
            'stage_presence' => 'How engaging was the artist with the crowd?',
            'song_aesthetic' => 'How did the performance look visually?'
        ];
    }

    /**
     * @inheritDoc
     */
    public function afterSave($insert, $changedAttributes): void
    {
        parent::afterSave($insert, $changedAttributes);

        if ($insert) {
            if (count($this->creator->artistReview) >= UserBadge::COUNT_AMATUER_ARTIST_REVIEWER) {
                $user = User::findOne($this->created_by);

                BadgeHelper::addBadge($user, UserBadge::TYPE_AMATUER_ARTIST_REVIEWER);
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
     * Get the artist that this review is connected to
     *
     * @return ActiveQueryInterface
     */
    public function getArtist(): ActiveQueryInterface
    {
        return $this->hasOne(Artist::class, ['artist_id' => 'artist_id']);
    }

    /**
     * Get the user votes for this review
     * 
     * @return ActiveQueryInterface
     */
    public function getUserVote(): ActiveQueryInterface
    {
        return $this->hasMany(UserVote::class, ['review_artist_id' => 'review_artist_id']);
    }

}
