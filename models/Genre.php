<?php

declare(strict_types = 1);

namespace app\models;

use app\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveQueryInterface;

/**
 * This is the model class for table "genre"
 * 
 * @property integer $genre_id
 * @property string $name
 * @property integer $parent_id
 * @property Moment $created_at
 * @property Moment $updated_at
 * @property Moment $created_by
 * @property Moment $updated_by
 */
class Genre extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%genre}}';
    }

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            [['name'], 'string', 'max' => 255],
            ['parent_id', 'exist', 'targetRelation' => 'parent'],
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
        return [
            'parent_id' => 'Parent genre'
        ];
    }

    /**
     * Gets the parent genre of this child genre
     *
     * @return ActiveQueryInterface
     */
    public function getParent(): ActiveQueryInterface
    {
        return $this->hasOne(self::class, ['genre_id' => 'parent_id']);
    }


}
