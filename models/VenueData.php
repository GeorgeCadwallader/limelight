<?php

namespace app\models;

use app\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveQueryInterface;

/**
 * This is the model class for table "venue_data"
 * 
 * @property integer $venue_data_id
 * @property integer $venue_id
 * @property string $profile_path
 * @property string $description
 * @property Moment $created_at
 * @property Moment $updated_at
 * @property Moment $created_by
 * @property Moment $updated_by
 */
class VenueData extends \yii\db\ActiveRecord
{

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
            [['venue_id'], 'integer'],
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
     * Gets the venue related to this data
     * 
     * @return ActiveQueryInterface
     */
    public function getVenue(): ActiveQueryInterface
    {
        return $this->hasOne(Venue::class, ['venue_id' => 'venue_id']);
    }

}