<?php

namespace app\models\forms;

/**
 * Model class for requesting an email reset
 * 
 * @category Project
 * @author George Cadwallader <georgecadwallader77@gmail.com>
 * @copyright 2020
 */
class RequestEmailResetForm extends \yii\base\Model
{

    /**
     * @var string
     */
    public $email_new;

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            [['email_new'], 'required'],
            [['email_new'], 'email']
        ];
    }

}
