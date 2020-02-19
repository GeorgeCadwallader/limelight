<?php

declare(strict_types = 1);

namespace app\models;

use app\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveQueryInterface;

/**
 * This is the model class for table "user_data"
 * 
 * @property integer $user_data_id
 * @property integer $user_id
 * @property string $first_name
 * @property string $last_name
 * @property Moment $date_of_birth
 * @property string $telephone
 * @property integer $county_id
 * @property Moment $created_by
 * @property Moment $updated_by
 * @property Moment $created_at
 * @property Moment $updated_at
 */
class UserData extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%user_data}}';
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
                ],
                'string',
                'max' => 255,
            ],
            [['telephone'], 'string', 'max' => 15],
            ['user_id', 'exist', 'targetRelation' => 'User'],
            ['county_id', 'exist', 'targetRelation' => 'County']
        ];
    }

    public function behaviors(): array
    {
        return [
            ['class' => TimestampBehavior::class],
            ['class' => BlameableBehavior::class],
        ];
    }

    public function getUser(): ActiveQueryInterface
    {
        return $this->hasOne(User::class, ['user_id' => 'user_id']);
    }

    public function getCounty(): ActiveQueryInterface
    {
        return $this->hasOne(County::class, ['county_id' => 'county_id']);
    }

}
