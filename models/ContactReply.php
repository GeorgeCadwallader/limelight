<?php

declare(strict_types = 1);

namespace app\models;

use app\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveQueryInterface;

/**
 * This is the model class for table "contact"
 * 
 * @property integer $contact_reply_id
 * @property integer $contact_id
 * @property string $message
 * @property Moment $created_at
 * @property Moment $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */
class ContactReply extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%contact_reply}}';
    }

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            [['message'], 'required'],
            [['message'], 'string', 'max' => 2400],
            ['contact_id', 'exist', 'targetRelation' => 'ContactMessage']
        ];
    }

    /**
     * @inheritDoc
     */
    public function behaviors(): array
    {
        return [
            ['class' => TimestampBehavior::class],
            ['class' => BlameableBehavior::class]
        ];
    }

    /**
     * Get the contact message related to this reply
     * 
     * @return ActiveQueryInterface
     */
    public function getContactMessage(): ActiveQueryInterface
    {
        return $this->hasOne(Contact::class, ['contact_id' => 'contact_id']);
    }

}
