<?php

declare(strict_types = 1);

use app\models\User;

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
        $user = User::findOne(['email' => 'georgemember@email.com']);
        $I->assertFalse(User::isActivateTokenValid($user->password_reset_token));

        $I->amOnRoute('/site/activate', ['token' => $user->password_reset_token]);

        $I->seeResponseCodeIsClientError();
    }

    /**
     * Tests that you can request a password reset
     *
     * @param \FunctionalTester $I
     *
     * @return void
     */
    public function testPasswordResetRequest(\FunctionalTester $I): void
    {
        $user = User::findByEmail('georgemember3@email.com');

        $I->amOnRoute('/site/request-password-reset');

        $I->submitForm('#request-password-reset', [
            'RequestPasswordResetForm' => [
                'email' => $user->email
            ]
        ]);

        $user->refresh();

        $email = $I->grabLastSentEmail();
        $I->assertArrayHasKey($user->email, $email->getTo());
        $I->assertNotNull($user->password_reset_token);

        $I->amOnRoute('/site/reset-password', ['token' => $user->password_reset_token]);
        $I->seeResponseCodeIsSuccessful();

        $I->submitForm('#reset-password-form', [
            'ResetPasswordForm' => [
                'password' => 'password1',
                'password_repeat' => 'password1'
            ]
        ]);

        $user->refresh();

        $I->assertNull($user->password_reset_token);
        $I->assertEquals($user->username, Yii::$app->user->identity->username);
    }

}
