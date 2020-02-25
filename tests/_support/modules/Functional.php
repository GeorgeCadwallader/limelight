<?php

namespace modules;

use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;

class Functional extends \Codeception\Module
{

    /**
     * Wraps json decode to provide better error message
     *
     * @param string $jsonString
     *
     * @return array
     */
    public function decodeJson(string $jsonString): array
    {
        try {
            return Json::decode($jsonString);
        } catch (\Exception $e) {
            $this->fail('Invalid json string provided to decode.' . PHP_EOL . PHP_EOL . $jsonString);
        }

        return [];
    }

    /**
     * Gets the response from the last made request
     *
     * @return mixed
     */
    public function grabResponse()
    {
        return $this->getModule('Yii2')->_getResponseContent();
    }

    /**
     * Sets an post request. This function handles all of the csrf tokens that
     * is needed for the post request
     *
     * @param string|array $route The url to set the request to
     * @param array $data The data to send
     *
     * @return mixed
     */
    public function sendYiiPostRequest($route, array $data = [], array $files = [])
    {
        $module = $this->getModule('Yii2');

        $csrf = $module->createAndSetCsrfCookie('CSRF');
        $data[$csrf[0]] = $csrf[1];

        return $module->_request('POST', Url::to($route), $data, $files);
    }

    /**
     * Asserts an arrays value is correct
     *
     * This uses the Yii2 array helper so you can use the key as "nested.array"
     *
     * @param mixed $expected
     * @param string|array $key
     * @param array $array
     *
     * @return void
     */
    public function assertArrayValue($expected, $key, array $array): void
    {
        $this->assertEquals($expected, ArrayHelper::getValue($array, $key, '__NOT_SET__'));
    }

}
