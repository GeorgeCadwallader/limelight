<?php

declare(strict_types = 1);

use app\models\Artist;

/**
 * @category  Project
 * @package   {{package}}
 * @author    George Cadwallader <georgecadwallader77@gmail.com>
 * @copyright 2020 Limelight
 */
class ArtistControllerCest
{

    /**
     * Tests creating a new artist page
     *
     * @param \FunctionalTester $I
     *
     * @return void
     */
    public function testCreateArtist(\FunctionalTester $I): void
    {
        $I->amLoggedInAsArtistOwner();
        $I->amOnRoute('/artist/create');
        $I->seeResponseCodeIsSuccessful();

        $I->submitForm('#create-artist', [
            'Artist' => [
                'name' => 'artistTest'
            ]
        ]);

        $artist = Artist::find()->where(['name' => 'artistTest'])->one();

        $I->assertEquals(Artist::STATUS_UNVERIFIED, $artist->status);
        $I->assertEquals(Yii::$app->user->id, $artist->managed_by);
    }

}
