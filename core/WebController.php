<?php

declare(strict_types = 1);

namespace app\core;

use Yii;
use yii\bootstrap\ActiveForm;
use yii\filters\AccessControl;
use yii\web\Request;
use yii\web\Response;

/**
 * WebController
 */
class WebController extends \yii\web\Controller
{

    /**
     * Base behaviors for the app
     *
     * @return array
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
     * Validates a ajax form validation request
     *
     * @param array $models The models to validate
     *
     * @return array
     */
    protected function ajaxValidate(array $models): array
    {
        if (!is_array($models)) {
            $models = [$models];
        }

        $this->response->format = Response::FORMAT_JSON;
        return ActiveForm::validateMultiple($models);
    }

    /**
     * Get the yii request
     *
     * @return Request
     */
    protected function getRequest(): Request
    {
        return Yii::$app->getRequest();
    }

    /**
     * Gets the yii response
     *
     * @return Response
     */
    protected function getResponse(): Response
    {
        return Yii::$app->getResponse();
    }

    /**
     * Renders a view setting it in the response then returning the response
     *
     * @param string $view   The view name
     * @param array  $params The view params
     *
     * @return Response
     */
    protected function createResponse(string $view, array $params = []): Response
    {
        $this->getResponse()->data = $this->render($view, $params);
        return $this->getResponse();
    }

}
