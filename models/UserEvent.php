<?php

namespace app\models;

use app\behaviors\TimestampBehavior;

use yii\behaviors\BlameableBehavior;
use yii\db\ActiveQueryInterface;

/**
 * This is the model class for table "user_event"
 * 
 * @property integer $user_event_id
 * @property integer $event_id
 * @property integer $user_id
 * @property Moment $created_at
 * @property Moment $updated_at
 * @property Moment $created_by
 * @property Moment $updated_by
 */
class UserEvent extends \yii\db\ActiveRecord
{
    
    /**
     * @inheritDoc
     */
    public static function tableName(): string
    {
        return '{{%user_event}}';
    }

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            ['user_id', 'exist', 'targetRelation' => 'User'],
            ['event_id', 'exist', 'targetRelation' => 'Event'],
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
     * Get the event related to this user_event
     * 
     * @return ActiveQueryInterface
     */
    public function getEvent(): ActiveQueryInterface
    {
        return $this->hasOne(Event::class, ['event_id' => 'event_id']);
    }

    /**
     * Get the user related to this user_event
     * 
     * @return ActiveQueryInterface
     */
    public function getUser(): ActiveQueryInterface
    {
        return $this->hasOne(User::class, ['user_id' => 'user_id']);
    }

}