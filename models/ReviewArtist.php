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
            [['overall_rating'], 'double', 'max' => 5, 'min' => 0],
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

}
