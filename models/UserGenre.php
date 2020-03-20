<?php

declare(strict_types = 1);

namespace app\models;

use app\behaviors\TimestampBehavior;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveQueryInterface;

/**
 * This is the model class for table "user_genre"
 * 
 * @property integer $user_genre_id
 * @property integer $user_id
 * @property integer $genre_id
 * @property Moment $created_by
 * @property Moment $updated_by
 * @property Moment $created_at
 * @property Moment $updated_at
 */
class UserGenre extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%user_genre}}';
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
     * Gets the genre linked to this item
     * 
     * @return ActiveQueryInterface
     */
    public function getGenre(): ActiveQueryInterface
    {
        return $this->hasOne(Genre::class, ['genre_id' => 'genre_id']);
    }

    /**
     * Gets the user linked to this item
     * 
     * @return ActiveQueryInterface
     */
    public function getUser(): ActiveQueryInterface
    {
        return $this->hasOne(User::class, ['user_id' => 'user_id']);
    }

}
