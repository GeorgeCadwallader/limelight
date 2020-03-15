<?php

namespace app\models;

use app\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveQueryInterface;

/**
 * This is the model class for table "artist_data"
 * 
 * @property integer $artist_data_id
 * @property integer $artist_id
 * @property string $profile_path
 * @property string $description
 * @property Moment $created_at
 * @property Moment $updated_at
 * @property Moment $created_by
 * @property Moment $updated_by
 */
class ArtistData extends \yii\db\ActiveRecord
{

    /**
     * @inheritDoc
     */
    public static function tableName(): string
    {
        return '{{%artist_data}}';
    }

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            [['description'], 'string', 'max' => 255],
            [['artist_id'], 'integer'],
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
     * Gets the artist related to this data
     * 
     * @return ActiveQueryInterface
     */
    public function getArtist(): ActiveQueryInterface
    {
        return $this->hasOne(Artist::class, ['artist_id' => 'artist_id']);
    }

}