<?php

declare(strict_types = 1);

namespace app\models\forms;

use app\models\User;
use app\validators\PasswordValidator;
use InvalidArgumentException;

/**
 * Password reset form
 */
class UserActivationForm extends \yii\base\Model
{

    /**
     * @var string
     */
    public $password;

    /**
     * @var string
     */
    public $password_repeat;

    /**
     * @var User
     */
    public $user;

    /**
     * Creates a form model given a token.
     *
     * @param string $token
     * @param array  $config name-value pairs that will be used to initialize
     *                       the object properties
     *
     * @throws \yii\base\InvalidArgumentException if token is empty or not valid
     */
    public function __construct($token, $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidArgumentException('Password reset token cannot be blank.');
        }

        $this->user = User::findOne([
            'password_reset_token' => $token,
            'status' => User::STATUS_UNVERIFIED,
        ]);

        if ($this->user === null) {
            throw new InvalidArgumentException('Your access token is invalid');
        }

        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['password', 'password_repeat'], 'required'],
            ['password', PasswordValidator::class]
        ];
    }

    /**
     * Activates a user setting there password to the values inputed
     *
     * @return boolean
     */
    public function activate(): bool
    {
        $this->user->setPassword($this->password);
        $this->user->password_reset_token = null;

        $this->user->status = User::STATUS_ACTIVE;

        return $this->user->save(false);
    }

}
