<?php

declare(strict_types = 1);

namespace app\models;

use app\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveQueryInterface;

/**
 * This is the model class for table "member_request"
 * 
 * @property integer $member_request_id
 * @property string $request_name
 * @property integer $type
 * @property integer $status
 * @property Moment $created_at
 * @property Moment $updated_at
 * @property Moment $created_by
 * @property Moment $updated_by
 */
class MemberRequest extends \yii\db\ActiveRecord
{

    /**
     * Request type constants
     */
    const TYPE_ARTIST_REQUEST = 1;
    const TYPE_VENUE_REQUEST = 2;

    /**
     * Member request array
     */
    public static $types = [
        self::TYPE_ARTIST_REQUEST => 'Artist Request',
        self::TYPE_VENUE_REQUEST => 'Venue Request'
    ];

    /**
     * Status type constants
     */
    const STATUS_ACTIVE = 1;
    const STATUS_DEACTIVATED = 2;
    const STATUS_APPROVED = 3;

    /**
     * Status array
     */
    public static $statuses = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_DEACTIVATED => 'Deactivated',
        self::STATUS_APPROVED => 'Approved'
    ];

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%member_request}}';
    }

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            [['request_name'], 'string', 'max' => 255],
            [
                [
                    'type',
                    'status',
                    'request_count'
                ],
                'integer'
            ],
            ['status', 'in', 'range' => array_keys(self::$statuses)],
            ['type', 'in', 'range' => array_keys(self::$types)],
            [['request_name'], 'required'],
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
        return ['request_name' => 'Name'];
    }

    /**
     * Get the user that has created this member request
     *
     * @return ActiveQueryInterface
     */
    public function getCreator(): ActiveQueryInterface
    {
        return $this->hasOne(User::class, ['user_id' => 'created_by']);
    }

}
