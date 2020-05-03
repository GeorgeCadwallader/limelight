<?php

namespace app\models;

use app\behaviors\TimestampBehavior;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveQueryInterface;

/**
 * This is the model class for table "venue_data"
 * 
 * @property integer $venue_data_id
 * @property integer $venue_id
 * @property string $profile_path
 * @property string $description
 * @property integer $county_id
 * @property Moment $created_at
 * @property Moment $updated_at
 * @property Moment $created_by
 * @property Moment $updated_by
 */
class VenueData extends \yii\db\ActiveRecord
{

    /**
     * @var UploadedFile
     */
    public $imageFile;

    /**
     * @inheritDoc
     */
    public static function tableName(): string
    {
        return '{{%venue_data}}';
    }

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            [['description'], 'string', 'max' => 255],
            [['venue_id', 'county_id'], 'integer'],
            [
                ['imageFile'],
                'file',
                'skipOnEmpty' => true,
                'tooBig' => true,
                'maxSize' => 1024 * 1024 * 2, //2mb
                'extensions' => 'png, jpg'
            ],
            ['county_id', 'exist', 'targetRelation' => 'County'],
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
                unlink(Yii::getAlias('@web').'images/venue/'.$this->profile_path);
            }

            $path = $this->imageFile->baseName.'_'.Yii::$app->security->generateRandomString(5).'.'.$this->imageFile->extension;

            $this->profile_path = $path;
            $this->save();

            $this->imageFile->saveAs(
                'images/venue/'.$path
            );
            return true;
        } else {
            return false;
        }
    }

    /**
     * Gets the venue related to this data
     * 
     * @return ActiveQueryInterface
     */
    public function getVenue(): ActiveQueryInterface
    {
        return $this->hasOne(Venue::class, ['venue_id' => 'venue_id']);
    }

    /**
     * Gets the County associated with this VenueData
     * 
     * @return ActiveQueryInterface
     */
    public function getCounty(): ActiveQueryInterface
    {
        return $this->hasOne(County::class, ['county_id' => 'county_id']);
    }

}