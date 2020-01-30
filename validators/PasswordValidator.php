<?php

declare(strict_types = 1);

namespace app\validators;

/**
 * Validator for password entry
 */
class PasswordValidator extends \yii\validators\Validator
{

    /**
     * Minimum password length
     *
     * @var integer
     */
    public $minLength = 8;

    /**
     * Attribute in the model to validate the repeated password
     *
     * @var string
     */
    public $passwordRepeat = 'password_repeat';

    /**
     * Validates a password attribute
     *
     * @param mixed  $model
     * @param string $attribute
     *
     * @return void
     */
    public function validateAttribute($model, $attribute): void
    {
        $password = $model->{$attribute};

        if (strlen($password) < $this->minLength) {
            $this->addError($model, $attribute, '{attribute} must be at least {length} charters.', [
                'attribute' => $attribute,
                'length' => $this->minLength
            ]);
        }

        if ($password !== $model->{$this->passwordRepeat}) {
            $this->addError($model, $attribute, '{attribute} and {compare} are not the same.', [
                'attribute' => $attribute,
                'compare' => $this->passwordRepeat
            ]);
        }
    }

}
