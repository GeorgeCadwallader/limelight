<?php

namespace app\models;

use Yii;

use app\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveQueryInterface;

/**
 * This is the model class for table "venue"
 * 
 * @property integer $venue_id
 * @property string $name
 * @property integer $managed_by
 * @property integer $status
 * @property Moment $created_at
 * @property Moment $updated_at
 * @property Moment $created_by
 * @property Moment $updated_by
 */
class Venue extends \yii\db\ActiveRecord
{

    public static function tableName(): string
    {
        return '{{%venue}}';
    }

    /**
     * Artist status definitions
     */
    const STATUS_UNVERIFIED = 1;
    const STATUS_DEACTIVATED = 2;
    const STATUS_ACTIVE = 10;

    /**
     * Artist status definations array
     */
    public static $statuses = [
        self::STATUS_UNVERIFIED => 'Unverified',
        self::STATUS_DEACTIVATED => 'Deactivated',
        self::STATUS_ACTIVE => 'Active',
    ];

    public function rules(): array
    {
        return [
            [['name'], 'string', 'max' => 255],
            [
                [
                    'status',
                    'managed_by',
                ],
                'integer',
            ],
            ['status', 'in', 'range' => array_keys(self::$statuses)],
        ];
    }

    public function behaviors(): array
    {
        return [
            ['class' => TimestampBehavior::class],
            ['class' => BlameableBehavior::class],
        ];
    }

}