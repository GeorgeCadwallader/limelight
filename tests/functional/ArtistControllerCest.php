<?php

declare(strict_types = 1);

use app\models\Artist;
use app\models\ReviewArtist;
use app\models\ReviewTone;

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

        $reviewContent = 'I did not enjoy my experience seeing this band at all. The vocals were awful and there was barely any energy.';

        $I->amOnRoute('/artist/view', ['artist_id' => 2]);
        $I->submitForm('#create-review', [
            'ReviewArtist' => [
                'content' => $reviewContent,
                'overall_rating' => '1.5',
                'energy' => '2',
                'vocals' => '3.5',
                'sound' => '0.5',
                'stage_presence' => '4.5',
                'song_aesthetic' => '5'
            ]
        ]);

        $review = ReviewArtist::find()
                ->orderBy(['created_at' => SORT_DESC])
                ->one();

        $I->assertNotNull($review);
        $I->assertEquals($reviewContent, $review->content);
        $I->assertEquals('1.5', $review->overall_rating);
        $I->assertEquals('2', $review->energy);
        $I->assertEquals('3.5', $review->vocals);
        $I->assertEquals('0.5', $review->sound);
        $I->assertEquals('4.5', $review->stage_presence);
        $I->assertEquals('5', $review->song_aesthetic);

        $reviewTone = ReviewTone::find()
            ->where(['fk' => $review->review_artist_id])
            ->andWhere(['type' => ReviewTone::TYPE_ARTIST]);

        $I->assertTrue($reviewTone->exists());
    }

    /**
     * Tests that a member can not leave more than one review on an
     * artist page
     *
     * @param \FunctionalTester $I
     *
     * @return void
     */
    public function testArtistReviewTwice(\FunctionalTester $I): void
    {
        $I->wantToTest('that you can not review the same artist twice');

        $I->amLoggedInAs(7);
        $I->amOnRoute('/artist/view', ['artist_id' => 2]);

        $I->cantSeeElement('#create-review');
    }

    /**
     * Tests that you can edit an artist page
     *
     * @param \FunctionalTester $I
     *
     * @return void
     */
    public function testArtistEdit(\FunctionalTester $I): void
    {
        $I->amLoggedInAsAdmin();

        $artist = Artist::findOne(2);
        $I->assertEquals('Tom Jones description', $artist->data->description);
        $I->assertEquals(0, count($artist->genre));

        $I->amOnRoute('/artist/edit', ['artist_id' => $artist->artist_id]);
        $I->submitForm('#artist-edit-form', [
            'ArtistData' => [
                'description' => 'Tom Jones description TEST',
            ],
            'Artist' => [
                'genre' => [
                    0 => '1',
                ]
            ]
        ]);

        $artist->refresh();

        $I->assertEquals(1, count($artist->genre));
        $I->assertEquals('Tom Jones description TEST', $artist->data->description);
    }

    /**
     * Tests the authentication for displaying the edit button
     *
     * @param \FunctionalTester $I
     *
     * @return void
     */
    public function testArtistEditButton(\FunctionalTester $I): void
    {
        //guest
        $I->amOnRoute('/artist/view', ['artist_id' => 2]);
        $I->cantSeeElement('.view-edit-button');

        //admin
        $I->amLoggedInAsAdmin();
        $I->amOnRoute('/artist/view', ['artist_id' => 2]);
        $I->canSeeElement('.view-edit-button');

        //manager
        $I->amLoggedInAs(12);
        $I->amOnRoute('/artist/view', ['artist_id' => 2]);
        $I->canSeeElement('.view-edit-button');

        //non-manager
        $I->amLoggedInAs(11);
        $I->amOnRoute('/artist/view', ['artist_id' => 2]);
        $I->cantSeeElement('.view-edit-button');
    }

}
