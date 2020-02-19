<?php

declare(strict_types = 1);

namespace app\models;

use app\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveQueryInterface;

/**
 * This is the model class for table "county"
 * 
 * @property integer $county_id
 * @property integer $user_id
 * @property string $first_name
 * @property string $last_name
 * @property Moment $date_of_birth
 * @property string $telephone
 * @property integer $region_id
 * @property Moment $created_by
 * @property Moment $updated_by
 * @property Moment $created_at
 * @property Moment $updated_at
 */
class County extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%county}}';
    }

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            [['name'], 'string', 'max' => 255],
            ['region_id', 'exist', 'targetRelation' => 'Region'],
        ];
    }

    public function behaviors(): array
    {
        return [
            ['class' => TimestampBehavior::class],
            ['class' => BlameableBehavior::class],
        ];
    }

    public function getRegion(): ActiveQueryInterface
    {
        return $this->hasOne(Region::class, ['region_id' => 'region_id']);
    }

}
