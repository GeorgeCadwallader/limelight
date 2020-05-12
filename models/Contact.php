<?php

declare(strict_types = 1);

namespace app\models;

use app\behaviors\TimestampBehavior;

/**
 * This is the model class for table "contact"
 * 
 * @property integer $contact_id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $message
 * @property integer $status
 * @property Moment $created_at
 * @property Moment $updated_at
 */
class Contact extends \yii\db\ActiveRecord
{

    /**
     * Contact status definitions
     */
    const STATUS_UNREAD = 1;
    const STATUS_RESOLVED = 2;
    const STATUS_DEACTIVATED = 3;

    /**
     * Contact status array
     */
    public static $statuses = [
        self::STATUS_UNREAD => 'Unread',
        self::STATUS_RESOLVED => 'Resolved',
        self::STATUS_DEACTIVATED => 'Deactivated'
    ];

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%contact}}';
    }

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            [
                [
                    'first_name',
                    'last_name',
                    'email',
                ],
                'string',
                'max' => 255
            ],
            [
                [
                    'first_name',
                    'last_name',
                    'email',
                    'message'
                ],
                'required',
            ],
            [['message'], 'string', 'max' => 2400],
            ['status', 'in', 'range' => array_keys(self::$statuses)],
            [['status'], 'integer']
        ];
    }

    /**
     * @inheritDoc
     */
    public function behaviors(): array
    {
        return [
            ['class' => TimestampBehavior::class],
        ];
    }

    /**
     * Finds user by an email address
     *
     * @param string $email The email address of the user
     *
     * @return self
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }

}
