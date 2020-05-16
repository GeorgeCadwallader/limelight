<?php

declare(strict_types = 1);

use app\models\Artist;
use app\models\ReviewArtist;
use app\models\ReviewReport;
use app\models\ReviewTone;
use app\models\ReviewVenue;
use app\models\User;
use app\models\UserVote;
use app\models\Venue;

/**
 * @category  Project
 * @package   {{package}}
 * @author    George Cadwallader <georgecadwallader77@gmail.com>
 * @copyright 2020 Limelight
 */
class ReviewControllerCest
{

    /**
     * Tests that you can edit a review for an artist
     */
    public function testEditReviewArtist(\FunctionalTester $I): void
    {
        $user = User::findOne(7);
        $artist = Artist::findOne(3);

        $query = ReviewArtist::find()
            ->where(['created_by' => $user->user_id])
            ->andWhere(['artist_id' => $artist->artist_id]);
            
        $I->assertTrue($query->exists());
        $I->assertEquals(1, (int)$query->count());

        $review = $query->one();

        $I->assertEquals('Arctic Monkeys review', $review->content);
        $I->assertEquals(5, $review->overall_rating);

        $I->amLoggedInAs(7);

        $reviewContent = 'I did not enjoy my experience seeing this band at all. The vocals were awful and there was barely any energy.';

        $I->amOnRoute('/artist/view', ['artist_id' => $artist->artist_id]);
        $I->submitForm('#edit-review', [
            'ReviewArtistFilterSearch' => [
                'content' => $reviewContent,
                'overall_rating' => 2
            ]
        ]);

        $review->refresh();

        $I->assertEquals($reviewContent, $review->content);
        $I->assertEquals(2, $review->overall_rating);
        $I->assertEquals(1, (int)$query->count());

        $reviewTone = ReviewTone::find()
            ->where(['fk' => $review->review_artist_id])
            ->andWhere(['type' => ReviewTone::TYPE_ARTIST]);

        $I->assertTrue($reviewTone->exists());
    }

    /**
     * Tests that you can edit a review for an venue
     */
    public function testEditReviewVenue(\FunctionalTester $I): void
    {
        $user = User::findOne(7);
        $venue = Venue::findOne(1);

        $query = ReviewVenue::find()
            ->where(['created_by' => $user->user_id])
            ->andWhere(['venue_id' => $venue->venue_id]);
            
        $I->assertTrue($query->exists());
        $I->assertEquals(1, (int)$query->count());

        $review = $query->one();

        $I->assertEquals('Wembley Arena Review', $review->content);
        $I->assertEquals(4.5, $review->overall_rating);

        $I->amLoggedInAs(7);

        $reviewContent = 'I did not enjoy my experience being at this venue all. The price was awful and there was barely any space.';

        $I->amOnRoute('/venue/view', ['venue_id' => $venue->venue_id]);
        $I->submitForm('#edit-review', [
            'ReviewVenueFilterSearch' => [
                'content' => $reviewContent,
                'overall_rating' => 2
            ]
        ]);

        $review->refresh();

        $I->assertEquals($reviewContent, $review->content);
        $I->assertEquals(2, $review->overall_rating);
        $I->assertEquals(1, (int)$query->count());

        $reviewTone = ReviewTone::find()
            ->where(['fk' => $review->review_venue_id])
            ->andWhere(['type' => ReviewTone::TYPE_VENUE]);

        $I->assertTrue($reviewTone->exists());
    }

    /**
     * Tests that you can upvote a venue review successfully
     *
     * @param \FunctionalTester $I
     *
     * @return void
     */
    public function testActionUpvoteVenue(\FunctionalTester $I): void
    {
        $I->amLoggedInAs(7);

        $review = ReviewVenue::findOne(1);
        
        $userVote = UserVote::find()
            ->where(['review_venue_id' => $review->review_venue_id])
            ->andWhere(['created_by' => Yii::$app->user->id]);

        $I->assertEquals(0, $review->upvotes);
        $I->assertFalse($userVote->exists());

        $I->amOnRoute(
            '/review/upvote',
            [
                'review_id' => $review->review_venue_id,
                'isArtist' => false,
            ]
        );

        $review->refresh();

        $I->assertTrue($userVote->exists());
        $I->assertEquals(1, $review->upvotes);
        $I->assertEquals(1, (int)$userVote->count());
    }

    /**
     * Tests that you can downvote a venue review successfully
     *
     * @param \FunctionalTester $I
     *
     * @return void
     */
    public function testActionDownvoteVenue(\FunctionalTester $I): void
    {
        $I->amLoggedInAs(7);

        $review = ReviewVenue::findOne(1);
        
        $userVote = UserVote::find()
            ->where(['review_venue_id' => $review->review_venue_id])
            ->andWhere(['created_by' => Yii::$app->user->id]);

        $I->assertEquals(0, $review->upvotes);
        $I->assertEquals(0, $review->downvotes);

        $I->amOnRoute(
            '/review/downvote',
            [
                'review_id' => $review->review_venue_id,
                'isArtist' => false,
            ]
        );

        $review->refresh();

        $I->assertEquals(1, (int)$userVote->count());
        $I->assertEquals(1, $review->downvotes);
        $I->assertEquals(0, $review->upvotes);
    }

    /**
     * Tests that you can upvote an artist page successfully
     *
     * @param \FunctionalTester $I
     *
     * @return void
     */
    public function testActionUpvoteArtist(\FunctionalTester $I): void
    {
        $I->amLoggedInAsMember();

        $review = ReviewArtist::findOne(2);
        
        $userVote = UserVote::find()
            ->where(['review_artist_id' => $review->review_artist_id])
            ->andWhere(['created_by' => Yii::$app->user->id]);

        $I->assertEquals(0, $review->upvotes);
        $I->assertFalse($userVote->exists());

        $I->amOnRoute(
            '/review/upvote',
            [
                'review_id' => $review->review_artist_id,
                'isArtist' => true,
            ]
        );

        $review->refresh();

        $I->assertTrue($userVote->exists());
        $I->assertEquals(1, $review->upvotes);
        $I->assertEquals(1, (int)$userVote->count());
    }

    /**
     * Tests that you can downvote an artist page successfully
     *
     * @param \FunctionalTester $I
     *
     * @return void
     */
    public function testActionDownvoteArtist(\FunctionalTester $I): void
    {
        $I->amLoggedInAsMember();

        $review = ReviewArtist::findOne(2);
        
        $userVote = UserVote::find()
            ->where(['review_artist_id' => $review->review_artist_id])
            ->andWhere(['created_by' => Yii::$app->user->id]);

        $I->assertEquals(0, $review->upvotes);
        $I->assertEquals(0, $review->downvotes);

        $I->amOnRoute(
            '/review/downvote',
            [
                'review_id' => $review->review_artist_id,
                'isArtist' => true,
            ]
        );

        $review->refresh();

        $I->assertEquals(1, (int)$userVote->count());
        $I->assertEquals(1, $review->downvotes);
        $I->assertEquals(0, $review->upvotes);
    }

    /**
     * Tests that you can report an artist review
     *
     * @param \FunctionalTester $I
     *
     * @return void
     */
    public function testActionReportArtistReview(\FunctionalTester $I): void
    {
        $I->amLoggedInAsMember();
        
        $review = ReviewArtist::findOne(3);

        $I->amOnRoute('/artist/view', ['artist_id' => 3]);
        $I->submitForm("#review-report-artist-{$review->review_artist_id}", [
            'ReviewReport' => [
                'context' => '1'
            ]
        ]);

        $report = ReviewReport::find()
            ->orderBy(['created_at' => SORT_DESC])
            ->one();

        $I->assertNotNull($report);
        $I->assertEquals(ReviewReport::CONTEXT_OFFENSIVE, $report->context);
        $I->assertEquals(ReviewReport::STATUS_ACTIVE, $report->status);
        $I->assertEquals(ReviewReport::TYPE_ARTIST, $report->type);
        $I->assertEquals($review->review_artist_id, $report->fk);
    }

    /**
     * Tests that you can report a venue review
     *
     * @param \FunctionalTester $I
     *
     * @return void
     */
    public function testActionReportVenueReview(\FunctionalTester $I): void
    {
        $I->amLoggedInAsMember();
        
        $review = ReviewVenue::findOne(2);

        $I->amOnRoute('/venue/view', ['venue_id' => 1]);
        $I->submitForm("#review-report-venue-{$review->review_venue_id}", [
            'ReviewReport' => [
                'context' => '1'
            ]
        ]);

        $report = ReviewReport::find()
            ->orderBy(['created_at' => SORT_DESC])
            ->one();

        $I->assertNotNull($report);
        $I->assertEquals(ReviewReport::CONTEXT_OFFENSIVE, $report->context);
        $I->assertEquals(ReviewReport::STATUS_ACTIVE, $report->status);
        $I->assertEquals(ReviewReport::TYPE_VENUE, $report->type);
        $I->assertEquals($review->review_venue_id, $report->fk);
    }

}
