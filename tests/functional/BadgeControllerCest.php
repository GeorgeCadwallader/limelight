<?php

declare(strict_types = 1);

use app\models\Artist;
use app\models\UserBadge;

/**
 * @category  Project
 * @package   {{package}}
 * @author    George Cadwallader <georgecadwallader77@gmail.com>
 * @copyright 2020 Limelight
 */
class BadgeControllerCest
{

    /**
     * Test that a member can get the amatuer artist badge
     * 
     * @return void
     */
    public function testAmateurArtistBadge(\FunctionalTester $I): void
    {
        $I->wantToTest('that you can get the amatuer artist badge');

        $hasBadge = UserBadge::find()
            ->where(['user_id' => Yii::$app->user->id])
            ->andWhere(['type' => UserBadge::TYPE_AMATUER_ARTIST_REVIEWER])
            ->exists();

        $I->assertFalse($hasBadge);

        $I->amLoggedInAs(7);
        $I->amOnRoute('/artist/view', ['artist_id' => 6]);
        $I->submitForm('#create-review', [
            'ReviewArtist' => [
                'content' => 'James Blunt review',
                'overall_rating' => '2.5'
            ]
        ]);

        $hasBadgeNew = UserBadge::find()
            ->where(['user_id' => Yii::$app->user->id])
            ->andWhere(['type' => UserBadge::TYPE_AMATUER_ARTIST_REVIEWER])
            ->exists();

        $I->assertTrue($hasBadgeNew);
    }

    /**
     * Test that a member can get the amatuer venue badge
     * 
     * @return void
     */
    public function testAmateurVenueBadge(\FunctionalTester $I): void
    {
        $I->wantToTest('that you can get the amatuer venue badge');

        $hasBadge = UserBadge::find()
            ->where(['user_id' => Yii::$app->user->id])
            ->andWhere(['type' => UserBadge::TYPE_AMATUER_VENUE_REVIEWER])
            ->exists();

        $I->assertFalse($hasBadge);

        $I->amLoggedInAs(7);
        $I->amOnRoute('/venue/view', ['venue_id' => 5]);
        $I->submitForm('#create-review', [
            'ReviewVenue' => [
                'content' => 'Venue review',
                'overall_rating' => '2.5'
            ]
        ]);

        $hasBadgeNew = UserBadge::find()
            ->where(['user_id' => Yii::$app->user->id])
            ->andWhere(['type' => UserBadge::TYPE_AMATUER_VENUE_REVIEWER])
            ->exists();

        $I->assertTrue($hasBadgeNew);
    }

}
