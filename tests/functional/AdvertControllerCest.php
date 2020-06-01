<?php

declare(strict_types = 1);

/**
 * @category  Project
 * @package   {{package}}
 * @author    George Cadwallader <georgecadwallader77@gmail.com>
 * @copyright 2020 Limelight
 */
class AdvertControllerCest
{

    /**
     * Tests the index action of the advert controller
     *
     * @param \FunctionalTester $I
     *
     * @return void
     */
    public function testIndex(\FunctionalTester $I): void
    {
        $I->amLoggedInAsMember();
        $I->amOnRoute('/advert');
        $I->seeResponseCodeIsSuccessful();

        $I->amLoggedInAsVenueOwner();
        $I->amOnRoute('/advert');
        $I->seeResponseCodeIsSuccessful();

        $I->amLoggedInAsArtistOwner();
        $I->amOnRoute('/advert');
        $I->seeResponseCodeIsSuccessful();

        $I->amLoggedInAsAdmin();
        $I->amOnRoute('/advert');
        $I->seeResponseCodeIsSuccessful();
    }

}
