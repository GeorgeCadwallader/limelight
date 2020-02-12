<?php

declare(strict_types = 1);

namespace app\models\forms;

use app\auth\Item;

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
     * @var integer
     */
    public $account_type;

    public static $accountTypes = [
        1 => Item::ROLE_MEMBER,
        2 => Item::ROLE_ARTIST_OWNER,
        3 => Item::ROLE_VENUE_OWNER,
    ];

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            [['username', 'password', 'email', 'password_repeat', 'account_type'], 'required'],
            ['email', 'email'],
            ['password', 'string', 'min' => 8, 'max' => 255],
            ['account_type', 'integer'],
            [['first_name', 'last_name', 'email'], 'string', 'max' => 255],
            ['account_type', 'in', 'range' => array_keys(self::$accountTypes)],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'operator' => '==='],
        ];
    }

}
