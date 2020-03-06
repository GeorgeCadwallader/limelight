<?php

declare(strict_types = 1);

use app\auth\Item;
use app\models\User;

/**
 * @category  Project
 * @package   {{package}}
 * @author    George Cadwallader <georgecadwallader77@gmail.com>
 * @copyright 2020 Limelight
 */
class RegisterControllerCest
{

    /**
     * Tests auth rights for register page
     *
     * @param \FunctionalTester $I
     *
     * @return void
     */
    public function testIndex(\FunctionalTester $I): void
    {
        $I->amLoggedInAsAdmin();
        $I->amOnRoute('/register');
        $I->canSeeResponseCodeIs(403);

        $I->amLoggedInAsArtistOwner();
        $I->amOnRoute('/register');
        $I->canSeeResponseCodeIs(403);

        $I->amLoggedInAsVenueOwner();
        $I->amOnRoute('/register');
        $I->canSeeResponseCodeIs(403);

        $I->amLoggedInAsMember();
        $I->amOnRoute('/register');
        $I->canSeeResponseCodeIs(403);

        Yii::$app->user->logout();
        $I->amOnRoute('/register');
        $I->seeResponseCodeIsSuccessful();
    }

    /**
     * Test that you can register on the site as a member
     * 
     * @param \FunctionalTester $I
     *
     * @return void
     */
    public function testRegisterMember(\FunctionalTester $I): void
    {
        $I->amOnRoute('/register');
        $I->submitForm('#register-form', [
            'User' => [
                'username' => 'memberTest',
                'email' => 'memberTest@email.com'
            ],
            'RegisterForm' => [
                'account_type' => '1',
            ]
        ]);

        $user = User::find()->where(['username' => 'memberTest'])->one();

        $I->assertEquals('memberTest@email.com', $user->email);
        $I->assertEquals(User::STATUS_UNVERIFIED, $user->status);
        $I->assertArrayHasKey(Item::ROLE_MEMBER, Yii::$app->authManager->getRolesByUser($user->user_id));
    }

    /**
     * Test that you can register on the site as an artist owner
     * 
     * @param \FunctionalTester $I
     *
     * @return void
     */
    public function testRegisterArtistOwner(\FunctionalTester $I): void
    {
        $I->amOnRoute('/register');
        $I->submitForm('#register-form', [
            'User' => [
                'username' => 'artistOwnerTest',
                'email' => 'artistOwnerTest@email.com'
            ],
            'RegisterForm' => [
                'account_type' => '2',
            ]
        ]);

        $user = User::find()->where(['username' => 'artistOwnerTest'])->one();

        $I->assertEquals('artistOwnerTest@email.com', $user->email);
        $I->assertEquals(User::STATUS_UNVERIFIED, $user->status);
        $I->assertArrayHasKey(Item::ROLE_ARTIST_OWNER, Yii::$app->authManager->getRolesByUser($user->user_id));
    }

    /**
     * Test that you can register on the site as an venue owner
     * 
     * @param \FunctionalTester $I
     *
     * @return void
     */
    public function testRegisterVenueOwner(\FunctionalTester $I): void
    {
        $I->amOnRoute('/register');
        $I->submitForm('#register-form', [
            'User' => [
                'username' => 'venueOwnerTest',
                'email' => 'venueOwnerTest@email.com'
            ],
            'RegisterForm' => [
                'account_type' => '3',
            ]
        ]);

        $user = User::find()->where(['username' => 'venueOwnerTest'])->one();

        $I->assertEquals('venueOwnerTest@email.com', $user->email);
        $I->assertEquals(User::STATUS_UNVERIFIED, $user->status);
        $I->assertArrayHasKey(Item::ROLE_VENUE_OWNER, Yii::$app->authManager->getRolesByUser($user->user_id));
    }

}
