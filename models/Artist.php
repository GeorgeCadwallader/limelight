<?php

namespace app\models;

use Yii;

use app\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveQueryInterface;

/**
 * This is the model class for table "artist"
 * 
 * @property integer $artist_id
 * @property string $name
 * @property integer $managed_by
 * @property integer $status
 * @property Moment $created_at
 * @property Moment $updated_at
 * @property Moment $created_by
 * @property Moment $updated_by
 */
class Artist extends \yii\db\ActiveRecord
{

    public static function tableName(): string
    {
        return '{{%artist}}';
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

    /**
     * @inheritDoc
     */
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
     * 
     * @return bool
     */
    public function upload(): bool
    {
        if ($this->validate()) {
            if ($this->profile_path !== null) {
                unlink(Yii::getAlias('@web').'images/artist/'.$this->profile_path);
            }

            $path = $this->imageFile->baseName.'_'.Yii::$app->security->generateRandomString(5).'.'.$this->imageFile->extension;

            $this->profile_path = $path;
            $this->save();

            $this->imageFile->saveAs(
                'images/artist/'.$path
            );
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the reviews for the artist
     * 
     * @return ActiveQueryInterface
     */
    public function getReviews(): ActiveQueryInterface
    {
        return $this->hasMany(ReviewArtist::class, ['artist_id' => 'artist_id']);
    }

    /**
     * Get the data for the artist
     * 
     * @return ActiveQueryInterface
     */
    public function getData(): ActiveQueryInterface
    {
        return $this->hasOne(ArtistData::class, ['artist_id' => 'artist_id']);
    }

}