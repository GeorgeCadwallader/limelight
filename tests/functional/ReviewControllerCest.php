<?php

declare(strict_types = 1);

use app\models\ReviewArtist;
use app\models\ReviewVenue;
use app\models\UserVote;

/**
 * @category  Project
 * @package   {{package}}
 * @author    George Cadwallader <georgecadwallader77@gmail.com>
 * @copyright 2020 Limelight
 */
class ReviewControllerCest
{

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

}
