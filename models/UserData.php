<?php

declare(strict_types = 1);

namespace app\models;

use app\behaviors\TimestampBehavior;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveQueryInterface;
use yii\web\UploadedFile;

/**
 * This is the model class for table "user_data"
 * 
 * @property integer $user_data_id
 * @property integer $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string $bio
 * @property Moment $date_of_birth
 * @property string $telephone
 * @property integer $county_id
 * @property Moment $created_by
 * @property Moment $updated_by
 * @property Moment $created_at
 * @property Moment $updated_at
 */
class UserData extends \yii\db\ActiveRecord
{

    /**
     * @var UploadedFile
     */
    public $imageFile;

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%user_data}}';
    }

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            [
                [
                    'first_name',
                    'last_name',
                    'date_of_birth',
                ],
                'string',
                'max' => 255,
            ],
            [['bio'], 'string', 'max' => 2500],
            [['telephone'], 'string', 'max' => 15],
            [
                ['imageFile'],
                'file',
                'skipOnEmpty' => true,
                'tooBig' => true,
                'maxSize' => 1024 * 1024 * 2, //2mb
                'extensions' => 'png, jpg'
            ],
            ['user_id', 'exist', 'targetRelation' => 'User'],
            ['county_id', 'exist', 'targetRelation' => 'County']
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
            'county_id' => 'County',
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
                unlink(Yii::getAlias('@web').'images/user/'.$this->profile_path);
            }

            $path = $this->imageFile->baseName.'_'.Yii::$app->security->generateRandomString(5).'.'.$this->imageFile->extension;

            $this->profile_path = $path;
            $this->save();

            $this->imageFile->saveAs(
                'images/user/'.$path
            );
            return true;
        } else {
            return false;
        }
    }

    /**
     * Gets the user associated with this UserData
     * 
     * @return ActiveQueryInterface
     */
    public function getUser(): ActiveQueryInterface
    {
        return $this->hasOne(User::class, ['user_id' => 'user_id']);
    }

    /**
     * Gets the County associated with this UserData
     * 
     * @return ActiveQueryInterface
     */
    public function getCounty(): ActiveQueryInterface
    {
        return $this->hasOne(County::class, ['county_id' => 'county_id']);
    }

}
