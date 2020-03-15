<?php

declare(strict_types = 1);

namespace app\models;

use app\behaviors\TimestampBehavior;

use yii\behaviors\BlameableBehavior;
use yii\db\ActiveQueryInterface;

/**
 * This is the model class for table "artist_genre"
 * 
 * @property integer $artist_genre_id
 * @property integer $artist_id
 * @property integer $genre_id
 * @property Moment $created_by
 * @property Moment $updated_by
 * @property Moment $created_at
 * @property Moment $updated_at
 */
class ArtistGenre extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%artist_genre}}';
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
     * Gets the genre linked to this artist
     * 
     * @return ActiveQueryInterface
     */
    public function getGenre(): ActiveQueryInterface
    {
        return $this->hasOne(Genre::class, ['genre_id' => 'genre_id']);
    }

    /**
     * Get the artist linked to this genre
     * 
     * @return ActiveQueryInterface
     */
    public function getArtist(): ActiveQueryInterface
    {
        return $this->hasOne(Artist::class, ['artist_id' => 'artist_id']);
    }

}
