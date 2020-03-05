<?php

declare(strict_types = 1);

use app\models\Artist;
use app\models\ReviewArtist;

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

    /**
     * Tests reviewing an artist page
     *
     * @param \FunctionalTester $I
     *
     * @return void
     */
    public function testArtistReview(\FunctionalTester $I): void
    {
        $I->amLoggedInAs(13);

        $I->amOnRoute('/artist/view', ['artist_id' => 2]);
        $I->submitForm('#create-review', [
            'ReviewArtist' => [
                'content' => 'georgemember3 test artist review',
                'overall_rating' => '1.5'
            ]
        ]);

        $review = ReviewArtist::find()
                ->orderBy(['created_at' => SORT_DESC])
                ->one();

        $I->assertEquals('georgemember3 test artist review', $review->content);
        $I->assertEquals('1.5', $review->overall_rating);
    }

}
