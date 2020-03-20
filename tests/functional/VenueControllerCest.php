<?php

declare(strict_types = 1);

use app\models\ReviewVenue;
use app\models\Venue;

/**
 * @category  Project
 * @package   {{package}}
 * @author    George Cadwallader <georgecadwallader77@gmail.com>
 * @copyright 2020 Limelight
 */
class VenueControllerCest
{

    /**
     * Tests creating a new venue page
     *
     * @param \FunctionalTester $I
     *
     * @return void
     */
    public function testCreateVenue(\FunctionalTester $I): void
    {
        $I->amLoggedInAsVenueOwner();
        $I->amOnRoute('/venue/create');
        $I->seeResponseCodeIsSuccessful();

        $I->submitForm('#create-venue', [
            'Venue' => [
                'name' => 'venueTest'
            ]
        ]);

        $venue = Venue::find()->where(['name' => 'venueTest'])->one();

        $I->assertEquals(Venue::STATUS_UNVERIFIED, $venue->status);
        $I->assertEquals(Yii::$app->user->id, $venue->managed_by);
    }

    /**
     * Tests reviewing an venue page
     *
     * @param \FunctionalTester $I
     *
     * @return void
     */
    public function testVenueReview(\FunctionalTester $I): void
    {
        $I->amLoggedInAs(7);

        $I->amOnRoute('/venue/view', ['venue_id' => 1]);
        $I->submitForm('#create-review', [
            'ReviewVenue' => [
                'content' => 'georgemember test venue review',
                'overall_rating' => '3.5'
            ]
        ]);

        $review = ReviewVenue::find()
                ->orderBy(['created_at' => SORT_DESC])
                ->one();

        $I->assertEquals('georgemember test venue review', $review->content);
        $I->assertEquals('3.5', $review->overall_rating);
    }

    /**
     * Tests editing a venue page
     * 
     * @param \FunctionalTester $I
     * 
     * @return void
     */
    public function testVenueEdit(\FunctionalTester $I): void
    {
        $I->amLoggedInAsAdmin();

        $venueData = Venue::findOne(1);
        $venueData = $venueData->data;

        $I->assertEquals('Venue page description', $venueData->description);
        $I->assertEquals(0, count($venueData->venue->genre));

        $I->amOnRoute('/venue/edit', ['venue_id' => 1]);
        $I->submitForm('#venue-edit-form', [
            'VenueData' => [
                'description' => 'venue-description-change'
            ],
            'Venue' => [
                'genre' => [
                    0 => '1',
                ]
            ]
        ]);

        $venueData->refresh();

        $I->assertEquals(1, count($venueData->venue->genre));
        $I->assertNotEquals('Venue page description', $venueData->description);
    }

}
