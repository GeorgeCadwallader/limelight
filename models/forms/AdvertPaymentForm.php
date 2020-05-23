<?php

declare(strict_types = 1);

namespace app\models\forms;

/**
 * AdvertPaymentForm model
 */
class AdvertPaymentForm extends \yii\base\Model
{

    /**
     * @var integer
     */
    public $number;

    /**
     * @var integer
     */
    public $expiryMonth;

    /**
     * @var integer
     */
    public $expiryYear;

    /**
     * @var integer
     */
    public $cvv;

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            [
                [
                    'number',
                    'expiryMonth',
                    'expiryYear',
                    'cvv'
                ],
                'required'
            ],
            [
                [
                    'number',
                    'expiryMonth',
                    'expiryYear',
                    'cvv'
                ],
                'integer'
            ]
        ];
    }

}
