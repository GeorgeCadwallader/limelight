<?php

declare(strict_types = 1);

use app\auth\Item;
use app\models\Artist;
use app\models\County;
use app\models\Genre;
use app\models\OwnerRequest;
use app\models\Region;
use app\models\User;
use app\models\Venue;

/**
 * @category  Project
 * @package   {{package}}
 * @author    George Cadwallader <georgecadwallader77@gmail.com>
 * @copyright 2020 Limelight
 */
class AdminControllerCest
{

    /**
     * Tests that only admins can access the index page
     *
     * @param \FunctionalTester $I
     *
     * @return void
     */
    public function testIndex(\FunctionalTester $I): void
    {
        $I->amLoggedInAsMember();
        $I->amOnRoute('/admin');
        $I->seeResponseCodeIs(403);

        $I->amLoggedInAsVenueOwner();
        $I->amOnRoute('/admin');
        $I->seeResponseCodeIs(403);

        $I->amLoggedInAsArtistOwner();
        $I->amOnRoute('/admin');
        $I->seeResponseCodeIs(403);

        $I->amLoggedInAsAdmin();
        $I->amOnRoute('/admin');
        $I->seeResponseCodeIsSuccessful();
    }

    /**
     * Test that you can add a region successfully
     * 
     * @param \FunctionalTester $I
     *
     * @return void
     */
    public function testAddRegion(\FunctionalTester $I): void
    {
        $I->amLoggedInAsAdmin();
        $I->amOnRoute('/admin/add-region');

        $I->submitForm('#region-form', [
            'Region' => [
                'name' => 'regionTEST'
            ]
        ]);

        $region = Region::find()->where(['name' => 'regionTEST'])->one();

        $I->assertNotNull($region);
    }

    /**
     * Test that you can edit a region
     * 
     * @param \FunctionalTester $I
     *
     * @return void
     */
    public function testEditRegion(\FunctionalTester $I): void
    {
        $I->amLoggedInAsAdmin();

        $region = Region::find()->where(['name' => 'Greater London'])->one();

        $I->amOnRoute('/admin/edit-region', ['region_id' => $region->region_id]);
        $I->submitForm('#region-form', [
            'Region' => [
                'name' => 'Greater London TEST'
            ]
        ]);

        $region->refresh();

        $I->assertEquals('Greater London TEST', $region->name);
    }

    /**
     * Test that you can add a county
     * 
     * @param \FunctionalTester $I
     *
     * @return void
     */
    public function testAddCounty(\FunctionalTester $I): void
    {
        $I->amLoggedInAsAdmin();

        $region = Region::find()->where(['name' => 'South East'])->one();

        $I->amOnRoute('/admin/add-county');
        $I->submitForm('#county-form', [
            'County' => [
                'name' => 'County TEST',
                'region_id' => $region->region_id
            ]
        ]);

        $county = County::find()->where(['name' => 'County TEST'])->one();

        $I->assertNotNull($county);
        $I->assertEquals($county->region_id, $region->region_id);
    }

    /**
     * Test that you can edit an existing county
     * 
     * @param \FunctionalTester $I
     *
     * @return void
     */
    public function testEditCounty(\FunctionalTester $I): void
    {
        $I->amLoggedInAsAdmin();

        $county = County::find()->where(['name' => 'North East Derbyshire'])->one();
        $region = Region::find()->where(['name' => 'Yorkshire'])->one();

        $I->amOnRoute('/admin/edit-county', ['county_id' => $county->county_id]);
        $I->submitForm('#county-form', [
            'County' => [
                'name' => 'North East Derbyshire TEST',
                'region_id' => $region->region_id
            ]
        ]);

        $county->refresh();

        $I->assertEquals('North East Derbyshire TEST', $county->name);
        $I->assertEquals($region->region_id, $county->region_id);
    }

    /**
     * Test that you can create an admin
     * 
     * @param \FunctionalTester $I
     *
     * @return void
     */
    public function testCreateAdmin(\FunctionalTester $I): void
    {
        $I->amLoggedInAsAdmin();
        $I->amOnRoute('/admin/admin-create');

        $I->submitForm('#admin-create-form', [
            'User' => [
                'username' => 'newAdminTest',
                'email' => 'newAdminTest@email.com',
                'password' => Yii::$app->security->generateRandomString(12),
                'password_reset_token' => Yii::$app->security->generateRandomString(),
                'auth_key' => Yii::$app->security->generateRandomString(),
                'roles' => [Item::ROLE_ADMIN],
            ]
        ]);

        $email = $I->grabLastSentEmail();
        $I->assertArrayHasKey('newAdminTest@email.com', $email->getTo());

        $user = User::find()->where(['username' => 'newAdminTest'])->one();

        $I->assertNotNull($user);
        $I->assertEquals('newAdminTest@email.com', $user->email);

        $I->assertArrayHasKey(Item::ROLE_ADMIN, Yii::$app->authManager->getRolesByUser($user->user_id));
    }

    /**
     * Test that you can create an artist through the admin panel
     * 
     * @param \FunctionalTester $I
     *
     * @return void
     */
    public function testCreateArtistAdmin(\FunctionalTester $I): void
    {
        $I->amLoggedInAsAdmin();
        $I->amOnRoute('/admin/add-artist');

        $I->submitForm('#create-artist', [
            'Artist' => [
                'name' => 'adminArtistTest'
            ]
        ]);

        $artist = Artist::find()->where(['name' => 'adminArtistTest'])->one();

        $I->assertNotNull($artist);
        $I->assertNull($artist->managed_by);
        $I->assertEquals(Artist::STATUS_ACTIVE, $artist->status);
    }

    /**
     * Test that you can create an venue through the admin panel
     * 
     * @param \FunctionalTester $I
     *
     * @return void
     */
    public function testCreateVenueAdmin(\FunctionalTester $I): void
    {
        $I->amLoggedInAsAdmin();
        $I->amOnRoute('/admin/add-venue');

        $I->submitForm('#create-venue', [
            'Venue' => [
                'name' => 'adminVenueTest'
            ]
        ]);

        $venue = Venue::find()->where(['name' => 'adminVenueTest'])->one();

        $I->assertNotNull($venue);
        $I->assertNull($venue->managed_by);
        $I->assertEquals(Venue::STATUS_ACTIVE, $venue->status);
    }

    /**
     * Test that you can set the status of an artist through the admin panel
     * 
     * @param \FunctionalTester $I
     *
     * @return void
     */
    public function testSetArtistStatus(\FunctionalTester $I): void
    {
        $I->amLoggedInAsAdmin();

        $I->amOnRoute('/admin/set-artist-status', ['artist_id' => 999, 'status' => 10]);
        $I->seeResponseCodeIsClientError();
        
        $I->amOnRoute('/admin/set-artist-status', ['artist_id' => 1, 'status' => 999]);
        $I->seeResponseCodeIsClientError();

        $artist = Artist::findOne(1);
        $I->assertEquals(Artist::STATUS_UNVERIFIED, $artist->status);

        $I->amOnRoute('/admin/set-artist-status', ['artist_id' => 1, 'status' => 10]);

        $artist->refresh();
        $I->assertEquals(Artist::STATUS_ACTIVE, $artist->status);
    }

    /**
     * Test that you can approve an artist page
     * 
     * @param \FunctionalTester $I
     *
     * @return void
     */
    public function testApproveArtist(\FunctionalTester $I): void
    {
        $I->amLoggedInAsAdmin();

        $request = OwnerRequest::findOne(1);
        $I->assertEquals(OwnerRequest::TYPE_ARTIST, $request->type);

        $I->amOnRoute('/admin/request-approve', ['owner_request_id' => 1]);

        $artist = Artist::find()
            ->where(['artist_id' => $request->fk])
            ->one();
        
        $email = $I->grabLastSentEmail();

        $I->assertNotNull($artist);
        $I->assertEquals(Yii::$app->user->identity->email, array_key_first($email->getTo()));
        $I->assertEquals($request->created_by, $artist->managed_by);
    }

    /**
     * Test that you can add a genre with no parent
     * 
     * @param \FunctionalTester $I
     *
     * @return void
     */
    public function testAddGenreNoParent(\FunctionalTester $I): void
    {
        $I->amLoggedInAsAdmin();

        $I->amOnRoute('/admin/add-genre');
        $I->submitForm('#genre-form', [
            'Genre' => [
                'name' => 'GenreTEST',
            ]
        ]);

        $genre = Genre::find()->where(['name' => 'GenreTEST'])->one();

        $I->assertNotNull($genre);
        $I->assertNull($genre->parent_id);
    }

    /**
     * Test that you can add a genre with a parent
     * 
     * @param \FunctionalTester $I
     *
     * @return void
     */
    public function testAddGenreWithParent(\FunctionalTester $I): void
    {
        $I->amLoggedInAsAdmin();

        $I->amOnRoute('/admin/add-genre');
        $I->submitForm('#genre-form', [
            'Genre' => [
                'name' => 'GenreTEST2',
                'parent_id' => 1
            ]
        ]);

        $genre = Genre::find()->where(['name' => 'GenreTEST2'])->one();
        $parent = Genre::findOne(1);

        $I->assertNotNull($genre);
        $I->assertNotNull($genre->parent_id);
        $I->assertEquals($parent->genre_id, $genre->parent_id);
    }

    /**
     * Test that you can add edit a genre
     * 
     * @param \FunctionalTester $I
     *
     * @return void
     */
    public function testEditGenre(\FunctionalTester $I): void
    {
        $I->amLoggedInAsAdmin();

        $genre = Genre::findOne(1);
        $I->assertNotNull($genre);
        $I->assertEquals('Rock', $genre->name);

        $I->amOnRoute('/admin/edit-genre', ['genre_id' => $genre->genre_id]);
        $I->submitForm('#genre-form', [
            'Genre' => [
                'name' => 'RockTEST',
            ]
        ]);

        $genre->refresh();

        $I->assertNotNull($genre);
        $I->assertEquals('RockTEST', $genre->name);
    }

}
