<?php

declare(strict_types = 1);

namespace app\models;

use app\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveQueryInterface;

/**
 * This is the model class for table "user_vote"
 * 
 * @property integer $user_vote_id
 * @property integer $review_artist_id
 * @property integer $review_venue_id
 * @property integer $type
 * @property Moment $created_by
 * @property Moment $updated_by
 * @property Moment $created_at
 * @property Moment $updated_at
 */
class UserVote extends \yii\db\ActiveRecord
{

    const TYPE_UPVOTE = 1;
    const TYPE_DOWNVOTE = 2;

    /**
     * User vote types
     */
    public static $types = [
        self::TYPE_UPVOTE => 'Upvote',
        self::TYPE_DOWNVOTE => 'Downvote'
    ];

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%user_vote}}';
    }

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            [
                [
                    'review_artist_id',
                    'review_venue_id',
                ],
                'integer'
            ],
            ['type', 'in', 'range' => array_keys(self::$types)],
            ['review_artist_id', 'exist', 'targetRelation' => 'reviewArtist'],
            ['review_venue_id', 'exist', 'targetRelation' => 'reviewVenue']
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
     * Gets the artist review relating to this vote
     */
    public function getReviewArtist(): ActiveQueryInterface
    {
        return $this->hasOne(ReviewArtist::class, ['review_artist_id' => 'review_artist_id']);
    }

    /**
     * Gets the venue review relating to this vote
     */
    public function getReviewVenue(): ActiveQueryInterface
    {
        return $this->hasOne(ReviewVenue::class, ['review_venue_id' => 'review_venue_id']);
    }

    /**
     * Get the user that has created this vote
     *
     * @return ActiveQueryInterface
     */
    public function getCreator(): ActiveQueryInterface
    {
        return $this->hasOne(User::class, ['user_id' => 'created_by']);
    }

}
