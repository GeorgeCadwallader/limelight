<?php

namespace app\models\forms;

/**
 * Model class for requesting a password reset
 * 
 * @category Project
 * @author George Cadwallader <georgecadwallader77@gmail.com>
 * @copyright 2020
 */
class RequestPasswordResetForm extends \yii\base\Model
{

    /**
     * @var string
     */
    public $email;

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            [['email'], 'required'],
            ['email', 'email']
        ];
    }

}
