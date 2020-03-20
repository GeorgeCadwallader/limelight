<?php

declare(strict_types = 1);

use app\models\UserGenre;

/**
 * @category  Project
 * @package   {{package}}
 * @author    George Cadwallader <georgecadwallader77@gmail.com>
 * @copyright 2020 Limelight
 */
class ProfileControllerCest
{

    /**
     * Tests that you can logout successfully
     *
     * @param \FunctionalTester $I
     *
     * @return void
     */
    public function testIndex(\FunctionalTester $I): void
    {
        $I->amLoggedInAsMember();
        $I->amOnRoute('/profile');
        $I->seeResponseCodeIsSuccessful();

        $I->see('Hi '.Yii::$app->user->identity->username.'!');
    }

    /**
     * Tests that a user can update their profile
     * 
     * @param \FuncionalTester $I
     * 
     * @return void
     */
    public function testUpdateProfile(\FunctionalTester $I): void
    {
        $I->amLoggedInAs(7);
        $user = Yii::$app->user->identity;
        $userData = Yii::$app->user->identity->userData;

        $I->amOnRoute('/profile/edit', ['user_id' => 999]);
        $I->canSeeResponseCodeIsClientError();

        $I->amOnRoute('/profile/edit', ['user_id' => Yii::$app->user->id]);
        $I->seeResponseCodeIsSuccessful();

        $I->assertEquals('George', $userData->first_name);
        $I->assertEquals('1998-06-02', $userData->date_of_birth);
        $I->assertEquals('395', $userData->county_id);
        $I->assertEquals(3, count($userData->user->genre));

        $I->submitForm('#edit-form', [
            'UserData' => [
                'first_name' => 'GeorgeTEST',
                'last_name' => 'Cadwallader',
                'date_of_birth' => '1980-12-25',
                'telephone' => '012345678',
                'county_id' => '250',
            ],
            'User' => [
                'genre' => [
                    0 => '1',
                    1 => '2',
                ]
            ]
        ]);

        $userData->refresh();

        $I->assertEquals('GeorgeTEST', $userData->first_name);
        $I->assertEquals('1980-12-25', $userData->date_of_birth);
        $I->assertEquals('250', $userData->county_id);
    }

}
