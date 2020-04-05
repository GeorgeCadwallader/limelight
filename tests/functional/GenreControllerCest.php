<?php

declare(strict_types = 1);

use app\models\Genre;

/**
 * @category  Project
 * @package   {{package}}
 * @author    George Cadwallader <georgecadwallader77@gmail.com>
 * @copyright 2020 Limelight
 */
class GenreControllerCest
{

    /**
     * Test the index action of the GenreController
     * 
     * @param \FunctionalTester $I
     * 
     * @return void
     */
    public function testIndex(\FunctionalTester $I): void
    {
        $I->amOnRoute('/genre');
        $I->seeResponseCodeIsSuccessful();

        $I->amLoggedInAsAdmin();
        $I->amOnRoute('/genre');
        $I->seeResponseCodeIsSuccessful();

        $I->amLoggedInAsArtistOwner();
        $I->amOnRoute('/genre');
        $I->seeResponseCodeIsSuccessful();

        $I->amLoggedInAsVenueOwner();
        $I->amOnRoute('/genre');
        $I->seeResponseCodeIsSuccessful();

        $I->amLoggedInAsMember();
        $I->amOnRoute('/genre');
        $I->seeResponseCodeIsSuccessful();
    }

    /**
     * Tests the view action of the GenreController
     * 
     * @param \FunctionalTester $I
     * 
     * @return void
     */
    public function testView(\FunctionalTester $I): void
    {
        $genre = Genre::findOne(1);

        $I->amOnRoute('/genre/view', ['genre_id' => $genre->genre_id]);
        $I->see($genre->name);

        $I->amOnRoute('/genre/view', ['genre_id' => 999]);
        $I->canSeeResponseCodeIsClientError();
    }

}
