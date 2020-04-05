<?php

declare(strict_types = 1);

/**
 * @category  Project
 * @package   {{package}}
 * @author    George Cadwallader <georgecadwallader77@gmail.com>
 * @copyright 2020 Limelight
 */
class CompareControllerCest
{

    /**
     * Tests auth on compare page
     *
     * @param \FunctionalTester $I
     *
     * @return void
     */
    public function testCompareAuth(\FunctionalTester $I): void
    {
        $I->amLoggedInAsMember();
        $I->amOnRoute('/compare');
        $I->seeResponseCodeIsSuccessful();
        $I->amOnRoute('/compare/artist');
        $I->seeResponseCodeIsSuccessful();
        $I->amOnRoute('/compare/venue');
        $I->seeResponseCodeIsSuccessful();

        $I->amLoggedInAsVenueOwner();
        $I->amOnRoute('/compare');
        $I->seeResponseCodeIsSuccessful();
        $I->amOnRoute('/compare/artist');
        $I->seeResponseCodeIsSuccessful();
        $I->amOnRoute('/compare/venue');
        $I->seeResponseCodeIsSuccessful();

        $I->amLoggedInAsArtistOwner();
        $I->amOnRoute('/compare');
        $I->canSeeResponseCodeIsSuccessful();
        $I->amOnRoute('/compare/artist');
        $I->seeResponseCodeIsSuccessful();
        $I->amOnRoute('/compare/venue');
        $I->seeResponseCodeIsSuccessful();

        $I->amLoggedInAsAdmin();
        $I->amOnRoute('/compare');
        $I->seeResponseCodeIsSuccessful();
        $I->amOnRoute('/compare/artist');
        $I->seeResponseCodeIsSuccessful();
        $I->amOnRoute('/compare/venue');
        $I->seeResponseCodeIsSuccessful();
    }

    /**
     * Tests that you can not compare the same artist
     * 
     * @param FunctionalTester $I
     * @return void
     */
    public function testCompareSameArtist(\FunctionalTester $I): void
    {
        $I->wantToTest('that you can not compare the same artist');

        $I->amOnRoute('/compare/artist', ['artist_id_one' => 1, 'artist_id_two' => 1]);
        $I->canSeeResponseCodeIsClientError();
    }

    /**
     * Tests that you can not compare the same venue
     * 
     * @param FunctionalTester $I
     * @return void
     */
    public function testCompareSameVenue(\FunctionalTester $I): void
    {
        $I->wantToTest('that you can not compare the same venue');

        $I->amOnRoute('/compare/venue', ['venue_id_one' => 1, 'venue_id_two' => 1]);
        $I->canSeeResponseCodeIsClientError();
    }

}
