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
     * Form user types
     */
    const TYPE_MEMBER = 1;
    const TYPE_ARTIST_OWNER = 2;
    const TYPE_VENUE_OWNER = 3;

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
        self::TYPE_MEMBER => Item::ROLE_MEMBER,
        self::TYPE_ARTIST_OWNER => Item::ROLE_ARTIST_OWNER,
        self::TYPE_VENUE_OWNER => Item::ROLE_VENUE_OWNER,
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
