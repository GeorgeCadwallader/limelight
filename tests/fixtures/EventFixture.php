<?php

declare(strict_types = 1);

namespace app\tests\fixtures;

/**
 * @category  Project
 * @package   {{package}}
 * @author    George Cadwallader <georgecadwallader77@gmail.com>
 * @copyright 2020
 */
class EventFixture extends \yii\test\ActiveFixture
{

    /**
     * The table for the fixture
     *
     * @var string
     */
    public $tableName = '{{%event}}';

    /**
     * The fixtures that this fixture depends on. This must be a list of the
     * dependent fixture class names
     *
     * @var array .
     */
    public $depends = [
        ArtistFixture::class,
        UserFixture::class,
        VenueFixture::class,
    ];

}
