<?php

declare(strict_types = 1);

namespace app\models\forms;

/**
 * Register Form model
 */
class RegisterForm extends \yii\base\Model
{

    /**
     * @var string
     */
    public $username;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $password;

    /**
     * @var string
     */
    public $password_repeat;

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            [['first_name', 'last_name', 'password', 'email', 'password_repeat'], 'required'],
            ['email', 'email'],
            ['password', 'string', 'min' => 8, 'max' => 255],
            [['first_name', 'last_name', 'email'], 'string', 'max' => 255],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'operator' => '==='],
        ];
    }

}
