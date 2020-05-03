<?php

declare(strict_types = 1);

namespace app\helpers;

use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;

/**
 * Extension to HTML helper
 */
class Html extends \yii\helpers\Html
{

    /**
     * Renders a font awesome icon
     *
     * @param string $name
     * @param array  $options
     *
     * @return string
     */
    public static function icon(string $name, array $options = []):string
    {
        $options['aria-hidden'] = 'true';
        self::addCssClass($options, 'fa fa-'.$name);
        return self::tag('i', null, $options);
    }

    /**
     * Renders a bootstrap tab link for navigation
     *
     * @param string  $name    Text to be displayed to the input
     * @param boolean $default If to render the tab as active
     *
     * @return string
     */
    public static function tabLink(string $name, bool $default = false, string $title = ''): string
    {
        $options = [
            'class' => 'nav-link',
            'data-toggle' => 'tab',
            'role' => 'tab',
            'title' => $title
        ];

        if ($default) {
            self::addCssClass($options, 'active');
        }

        $link = self::a($name, '#'.Inflector::slug($name), $options);
        return self::tag('li', $link, ['class' => 'nav-item']);
    }

    /**
     * Render the start of a tab container
     *
     * @param string  $name    Name of the tab
     * @param boolean $default If to render the tab as active
     *
     * @return string
     */
    public static function beginTab(string $name, bool $default = false, array $options = []): string
    {
        $options['id'] = Inflector::slug($name);
        $options['role'] = 'tabpanel';

        self::addCssClass($options, 'tab-pane fade');

        if ($default) {
            self::addCssClass($options, 'show active');
        }

        return self::beginTag('div', $options);
    }

    /**
     * Override to the html link function to add adding a icon into the button
     *
     * @param string       $text    The link text
     * @param string|array $url     The url passed to `Url::to()`
     * @param array        $options Html attributes to add to the dom
     *
     * @return string
     */
    public static function a($text, $url = null, $options = []): string
    {
        $iconBefore = ArrayHelper::remove($options, 'iconBefore');
        $iconAfter = ArrayHelper::remove($options, 'iconAfter');

        if ($iconBefore) {
            $text = self::icon($iconBefore).$text;
        }

        if ($iconAfter) {
            $text .= self::icon($iconAfter);
        }

        return parent::a($text, $url, $options);
    }

}
