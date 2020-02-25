<?php

declare(strict_types = 1);

/**
 * @category  Project
 * @package   {{package}}
 * @author    George Cadwallader <georgecadwallader77@gmail.com>
 * @copyright 2020 Limelight
 */
class ProfileControllerCest
{

    /**
     * Tests that you can logout successfully
     *
     * @param \FunctionalTester $I
     *
     * @return void
     */
    public function testIndex(\FunctionalTester $I): void
    {
        $I->amLoggedInAsMember();
        $I->amOnRoute('/profile');
        $I->seeResponseCodeIsSuccessful();

        $I->see('Hi '.Yii::$app->user->identity->username.'!');
    }

}
