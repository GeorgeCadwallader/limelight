<?php

namespace app\controllers;

use app\models\Advert;

use PayPal\Rest\ApiContext;

use Yii;
use yii\base\Response;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;

class AdvertController extends \app\core\WebController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays the advert index page
     *
     * @return Response
     */
    public function actionIndex(): Response
    {
        return $this->createResponse('index');
    }

    /**
     * Action for creating an advert
     * 
     * @return Response
     */
    public function actionCreate(int $type): Response
    {
        if (!array_key_exists($type, Advert::$advertTypes)) {
            throw new BadRequestHttpException('Invalid advert type');
        }

        if (Yii::$app->user->identity->artist !== null) {
            $ownedId = Yii::$app->user->identity->artist->artist_id;
            $ownerType = Advert::TYPE_ARTIST;
        } else if (Yii::$app->user->identity->venue !== null) {
            $ownedId = Yii::$app->user->identity->venue->venue_id;
            $ownerType = Advert::TYPE_VENUE;
        }

        $advert = new Advert([
            'fk' => $ownedId,
            'type' => $ownerType,
            'advert_type' => $type,
            'status' => Advert::STATUS_INACTIVE
        ]);

        if ($this->request->isPost) {
            $advert->load($this->request->post());

            $apiContext = new ApiContext(
                new \PayPal\Auth\OAuthTokenCredential(
                    env('PAYPAL_CLIENT_ID'),
                    env('PAYPAL_SECRET')
                )
            );

            $payer = new \PayPal\Api\Payer();
            $payer->setPaymentMethod('paypal');

            $amount = new \PayPal\Api\Amount();
            $amount->setTotal(Advert::$advertTypeCost[$type]);
            $amount->setCurrency('GBP');

            $transaction = new \PayPal\Api\Transaction();
            $transaction->setAmount($amount);

            $redirectUrls = new \PayPal\Api\RedirectUrls();
            $redirectUrls->setReturnUrl('http://localhost:8888/advert')
                ->setCancelUrl('http://localhost:8888/advert');

            $payment = new \PayPal\Api\Payment();
            $payment->setIntent('sale')
                ->setPayer($payer)
                ->setTransactions([$transaction])
                ->setRedirectUrls($redirectUrls);

            if ($advert->save()) {
                Yii::$app->session->addFlash('success', 'Your advert has successfully been created');
            }

            try {
                $payment->create($apiContext);
                return $this->redirect($payment->getApprovalLink());
            } catch (\PayPal\Exception\PayPalConnectionException $ex) {
                // dump($ex->getData());
                throw new BadRequestHttpException('Something went wrong with the payment');
            }
        }

        return $this->createResponse('create', compact('advert'));
    }

}
