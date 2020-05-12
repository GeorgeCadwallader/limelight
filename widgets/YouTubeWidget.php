<?php

namespace app\widgets;

use yii\base\InvalidConfigException;
use yii\helpers\Html;

/**
 * Widget for embedding a youtube video
 */
class YouTubeWidget extends \yii\base\Widget
{
    /**
     * youtube video id
     * 
     * @var string
     */
    public $embedCode;

    /**
     * parameters of embedded player
     * 
     * @var array
     */
    public $playerParameters;

    /**
     * url pattern for video content
     * 
     * @var string
     */
    public $embedPattern = 'https://www.youtube.com/embed/{video_id}';

    /**
     * options that will be passed to Html::tag()
     * 
     * @var array
     */
    public $iframeOptions;

    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->embedCode === null) {
            throw new InvalidConfigException('YouTubeWidget::embedCode must be set');
        }

        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $url = str_replace('{video_id}', $this->embedCode, $this->embedPattern);

        if (!empty($this->playerParameters)) {
            $url .= '?' . http_build_query($this->playerParameters);
        }

        $options = array_merge(['src' => $url], $this->iframeOptions);

        echo Html::tag('iframe', '', $options);
    }
}