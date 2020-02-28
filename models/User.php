<?php

declare(strict_types = 1);

namespace app\models;

use Yii;

use app\behaviors\TimestampBehavior;
use yii\db\ActiveQueryInterface;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "user"
 * 
 * @property integer $id
 * @property string $username
 * @property string $title
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $contact_number
 * @property integer $status
 * @property Moment $created_at
 * @property Moment $updated_at
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%user}}';
    }

    /**
     * User status definitions
     */
    const STATUS_DEACTIVATED = 1;
    const STATUS_UNVERIFIED = 2;
    const STATUS_VERIFIED = 3;
    const STATUS_VERIFICATION_FAILED = 4;
    const STATUS_ACTIVE = 10;

    /**
     * User status array
     */
    public static $statuses = [
        self::STATUS_ACTIVE => 'Live',
        self::STATUS_DEACTIVATED => 'Dormant',
        self::STATUS_UNVERIFIED => 'Unverified',
        self::STATUS_VERIFIED => 'Verified',
        self::STATUS_VERIFICATION_FAILED => 'Verification Failed',
    ];

    /**
     * Array of user roles
     * 
     * @var array
     */
    private $_roles;

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            'required' => [
                [
                    'username',
                    'auth_key',
                    'password_hash',
                    'email',
                ],
                'required',
            ],
            [
                [
                    'password_hash',
                    'password_reset_token',
                    'email',
                ],
                'string',
                'max' => 255,
            ],
            [['status'], 'integer'],
            ['status', 'in', 'range' => array_keys(self::$statuses)],
            [['auth_key'], 'string', 'max' => 32],
            'uniqueEmail' => [
                'email',
                function (string $attribute) {
                    if (!$this->isNewRecord) {
                        return true;
                    }

                    $value = $this->{$attribute};
                    $count = (int)self::find()
                        ->where([$attribute => $value])
                        ->count();

                    if ($count > 0) {
                        $this->addError(
                            $attribute,
                            "{$attribute} \"{$value}\" has already been taken."
                        );
                    }
                }
            ],
            ['email', 'email'],
            [['password_reset_token', 'username'], 'unique'],
            ['roles', 'safe'],
        ];
    }

    public function behaviors(): array
    {
        return [
            ['class' => TimestampBehavior::class],
        ];
    }

    /**
     * Function run after a user is saved
     *
     * @param bool  $insert
     * @param array $changedAttributes
     *
     * @return void
     */
    public function afterSave($insert, $changedAttributes): void
    {
        if (is_array($this->_roles)) {
            $this->updateRoles();
        }

        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * Updates a users roles adding and remove when necessary
     *
     * @return void
     */
    protected function updateRoles(): void
    {
        $authManager = Yii::$app->authManager;
        $userRoles = $authManager->getRolesByUser($this->user_id);
        $userRoleNames = array_keys($userRoles);

        $toAdd = array_diff($this->_roles, $userRoleNames);
        $toRemove = array_diff($userRoleNames, $this->_roles);

        foreach ($toAdd as $role) {
            $authManager->assign($authManager->getRole($role), $this->user_id);
        }

        foreach ($toRemove as $role) {
            $authManager->revoke($userRoles[$role], $this->user_id);
        }
    }

    /**
     * Gets all of the users roles
     *
     * @return array
     */
    public function getRoles(): array
    {
        $roles = Yii::$app->authManager->getRolesByUser($this->user_id);
        return ArrayHelper::map($roles, 'name', 'name');
    }

    /**
     * Sets roles for a user
     *
     * @param array $roles
     *
     * @return void
     */
    public function setRoles($roles): void
    {
        $this->_roles = $roles;
    }

    /**
     * @inheritdoc
     */
    public function getId(): int
    {
        return $this->getPrimaryKey();
    }

    public static function findIdentity($id)
    {
        return static::findOne(['user_id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by an email address
     *
     * @param string $email The email address of the user
     *
     * @return self
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     *
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function generateAuthKey(): void
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    public static function isPasswordResetTokenValid($token): bool
    {
        if (empty($token)) {
            return false;
        }

        return self::getTokenExpiration($token, 'user.passwordResetTokenExpire') >= time();
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     *
     * @return void
     */
    public function setPassword($password): void
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }


    /**
     * Gets the timestamp of a users token expiration
     *
     * @param int $token
     * @param string $tokenType
     * @return integer
     */
    public static function getTokenExpiration($token, $tokenType): int
    {
        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params[$tokenType];

        return $timestamp + $expire;
    }

    /**
     * Generates new password reset token
     *
     * @return void
     */
    public function generatePasswordResetToken(): void
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString().'_'.time();
    }

    /**
     * Test to see if a activation token is valid
     *
     * @return boolean
     */
    public static function isActivateTokenValid($token): bool
    {
        if (empty($token)) {
            return false;
        }

        return self::getTokenExpiration($token, 'user.activationTokenExpire') >= time();
    }


    /**
     * Gets a user with a valid activation token
     *
     * @param string $token
     *
     * @return self|null
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        if (!static::isActivateTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_UNVERIFIED,
        ]);
    }

    public function getAuthKey(): string
    {
        return $this->auth_key;
    }

    /**
     * Validates a users auth key
     *
     * @param string $authKey
     *
     * @return boolean
     */
    public function validateAuthKey($authKey): bool
    {
        return $this->getAuthKey() === $authKey;
    }

    public function getArtist(): ActiveQueryInterface
    {
        return $this->hasOne(Artist::class, ['managed_by' => 'user_id']);
    }

    public function getVenue(): ActiveQueryInterface
    {
        return $this->hasOne(Venue::class, ['managed_by' => 'user_id']);
    }

    public function getUserData(): ActiveQueryInterface
    {
        return $this->hasOne(UserData::class, ['user_id' => 'user_id']);
    }

}
