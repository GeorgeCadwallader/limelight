<?php

declare(strict_types = 1);

namespace app\models\forms;

use yii\base\Model;
use yii\base\InvalidParamException;
use app\models\User;
use app\validators\PasswordValidator;

/**
 * Password reset form
 */
class ResetPasswordForm extends Model
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
    private $_user;

    /**
     * Creates a form model given a token.
     *
     * @param string $token
     * @param array  $config name-value pairs that will be used to initialize
     *                       the object properties
     *
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($token, $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidParamException('Password reset token cannot be blank.');
        }
        $this->_user = User::findByPasswordResetToken($token);
        if (!$this->_user) {
            throw new InvalidParamException('Your access token is invalid');
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
     * Resets password.
     *
     * @return bool if password was reset.
     */
    public function resetPassword(): bool
    {
        $user = $this->_user;
        $user->setPassword($this->password);
        $user->password_reset_token = null;

        return $user->save(false);
    }

}
