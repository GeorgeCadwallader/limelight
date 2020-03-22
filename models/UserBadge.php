<?php

declare(strict_types = 1);

namespace app\models;

use app\behaviors\TimestampBehavior;

use yii\behaviors\BlameableBehavior;
use yii\db\ActiveQueryInterface;

/**
 * This is the model class for table "user_badge"
 * 
 * @property integer $user_badge_id
 * @property integer $user_id
 * @property integer $badge_id
 * @property Moment $created_by
 * @property Moment $updated_by
 * @property Moment $created_at
 * @property Moment $updated_at
 */
class UserBadge extends \yii\db\ActiveRecord
{

    const TYPE_AMATUER_ARTIST_REVIEWER = 1;
    const TYPE_AMATUER_VENUE_REVIEWER = 2;

    const COUNT_AMATUER_ARTIST_REVIEWER = 5;
    const COUNT_AMATUER_VENUE_REVIEWER = 5;

    /**
     * Badges array
     */
    public static $badges = [
        self::TYPE_AMATUER_ARTIST_REVIEWER => 'Amatuer Artist Reviewer',
        self::TYPE_AMATUER_VENUE_REVIEWER => 'Amatuer Venue Reviewer',
    ];

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%user_badge}}';
    }

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            ['user_id', 'exist', 'targetRelation' => 'User'],
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
     * Gets the user associated with this user_badge
     * 
     * @return ActiveQueryInterface
     */
    public function getUser(): ActiveQueryInterface
    {
        return $this->hasOne(User::class, ['user_id' => 'user_id']);
    }

}
