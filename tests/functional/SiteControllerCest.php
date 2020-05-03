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
     * Tests the sorting of different user roles to different
     * views in the index action
     *
     * @param \FunctionalTester $I
     *
     * @return void
     */
    public function testIndex(\FunctionalTester $I): void
    {
        $I->amOnRoute('/site/index');
        $I->seeResponseCodeIsSuccessful();
        $I->see('Get Started');

        $I->amLoggedInAsAdmin();
        $I->amOnRoute('/site/index');
        $I->seeResponseCodeIsSuccessful();
        $I->seeInCurrentUrl('/admin');

        $I->amLoggedInAsArtistOwner();
        $I->amOnRoute('/site/index');
        $I->seeResponseCodeIsSuccessful();
        $I->see(Yii::$app->user->identity->username);

        $I->amLoggedInAsVenueOwner();
        $I->amOnRoute('/site/index');
        $I->seeResponseCodeIsSuccessful();
        $I->see(Yii::$app->user->identity->username);

        $I->amLoggedInAsMember();
        $I->amOnRoute('/site/index');
        $I->seeResponseCodeIsSuccessful();
        $I->see(Yii::$app->user->identity->username);
    }

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
        $I->see('Logout');

        $csrf = $I->createAndSetCsrfCookie('CSRF');
        $I->sendAjaxPostRequest('/site/logout', [$csrf[0] => $csrf[1]]);

        $I->amOnRoute('/');
        $I->see('Log In');
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

        $I->see('Logout');

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

    /**
     * Tests that you can request and complete an email reset
     *
     * @param \FunctionalTester $I
     *
     * @return void
     */
    public function testChangeEmail(\FunctionalTester $I): void
    {
        $I->amLoggedInAs(12);

        $user = Yii::$app->user->identity;

        $I->assertEquals('georgeartistowner2@email.com', $user->email);
        $I->assertNull($user->password_reset_token);
        $I->assertNull($user->email_new);

        $I->amOnRoute('/site/change-email-request');
        $I->submitForm('#request-email-form', [
            'RequestEmailResetForm' => [
                'email_new' => 'emailchange@test.com'
            ]
        ]);

        $email = $I->grabLastSentEmail();
        $I->assertEquals('emailchange@test.com', array_key_first($email->getTo()));

        $I->amOnRoute('/site/change-email', ['token' => $user->password_reset_token]);

        $user->refresh();

        $I->assertEquals('emailchange@test.com', $user->email);
        $I->assertNull($user->password_reset_token);
        $I->assertNull($user->email_new);
    }

}
