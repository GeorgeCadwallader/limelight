<?php

declare(strict_types = 1);

use app\models\User;
use app\tests\fixtures\UserFixture;

/**
 * @category  Project
 * @package   {{package}}
 * @author    George Cadwallader <georgecadwallader77@gmail.com>
 * @copyright 2020 Limelight
 */
class SiteControllerCest
{

    /**
     * Tests that you can logout successfully
     *
     * @param \FunctionalTester $I
     *
     * @return void
     */
    public function testLogout(\FunctionalTester $I): void
    {
        $I->amLoggedInAsAdmin();

        $I->amOnRoute('/');
        $I->see('Log out');

        $csrf = $I->createAndSetCsrfCookie('CSRF');
        $I->sendAjaxPostRequest('/site/logout', [$csrf[0] => $csrf[1]]);

        $I->amOnRoute('/');
        $I->see('Log in');
    }

    /**
     * Tests that a user can become activated
     *
     * @param \FunctionalTester $I
     *
     * @return void
     */
    public function testActivateUser(\FunctionalTester $I): void
    {
        $I->haveFixtures([UserFixture::class]);

        $user = User::findByEmail('georgemember2@email.com');
        $user->generatePasswordResetToken();
        $user->save();

        $I->assertTrue(User::isActivateTokenValid($user->password_reset_token));
        $I->amOnRoute('/site/activate', ['token' => $user->password_reset_token]);

        $I->see('Reset password');

        $I->submitForm('#reset-password-form', [
            'UserActivationForm[password]' => 'password',
            'UserActivationForm[password_repeat]' => 'password',
        ]);

        $I->see('Log out');

        $user->refresh();

        $I->assertEquals($user->status, User::STATUS_ACTIVE);
    }

    /**
     * Tests that the activation link expires
     *
     * @param \FunctionalTester $I
     *
     * @return void
     */
    public function testActivateExpiredLink(\FunctionalTester $I): void
    {
        $I->haveFixtures([UserFixture::class]);

        $user = User::findOne(['email' => 'georgemember@email.com']);
        $I->assertFalse(User::isActivateTokenValid($user->password_reset_token));

        $I->amOnRoute('/site/activate', ['token' => $user->password_reset_token]);

        $I->seeResponseCodeIsClientError();
    }

}
