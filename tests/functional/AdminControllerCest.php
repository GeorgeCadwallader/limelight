<?php

declare(strict_types = 1);

use app\auth\Item;
use app\models\County;
use app\models\Region;
use app\models\User;

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

}
