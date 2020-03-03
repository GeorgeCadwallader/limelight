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
     * Test that you can register on the site
     * 
     * @param \FunctionalTester $I
     *
     * @return void
     */
    public function testRegister(\FunctionalTester $I): void
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

}
