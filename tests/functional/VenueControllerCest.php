<?php

declare(strict_types = 1);

use app\models\ReviewTone;
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
        $I->amLoggedInAs(13);

        $reviewContent = 'I did not enjoy my experience being at this venue all. The price was awful and there was barely any space.';

        $I->amOnRoute('/venue/view', ['venue_id' => 2]);
        $I->submitForm('#create-review', [
            'ReviewVenue' => [
                'content' => $reviewContent,
                'overall_rating' => '3.5',
                'service' => '1.5',
                'location' => '3.5',
                'value' => '4',
                'cleanliness' => '2',
                'size' => '2.5'
            ]
        ]);

        $review = ReviewVenue::find()
                ->orderBy(['created_at' => SORT_DESC])
                ->one();

        $I->assertNotNull($review);
        $I->assertEquals($reviewContent, $review->content);
        $I->assertEquals('3.5', $review->overall_rating);
        $I->assertEquals('1.5', $review->service);
        $I->assertEquals('3.5', $review->location);
        $I->assertEquals('4', $review->value);
        $I->assertEquals('2', $review->cleanliness);
        $I->assertEquals('2.5', $review->size);

        $reviewTone = ReviewTone::find()
            ->where(['fk' => $review->review_venue_id])
            ->andWhere(['type' => ReviewTone::TYPE_VENUE]);

        $I->assertTrue($reviewTone->exists());
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

        $I->assertEquals('Wembley Arena description', $venueData->description);
        $I->assertEquals(0, count($venueData->venue->genre));

        $I->amOnRoute('/venue/edit', ['venue_id' => 1]);
        $I->submitForm('#venue-edit-form', [
            'VenueData' => [
                'description' => 'Wembley Arena description TEST'
            ],
            'Venue' => [
                'genre' => [
                    0 => '1',
                ]
            ]
        ]);

        $venueData->refresh();

        $I->assertEquals(1, count($venueData->venue->genre));
        $I->assertNotEquals('Wembley Arena description', $venueData->description);
    }

    /**
     * Tests the authentication for displaying the edit button
     *
     * @param \FunctionalTester $I
     *
     * @return void
     */
    public function testVenueEditButton(\FunctionalTester $I): void
    {
        //guest
        $I->amOnRoute('/venue/view', ['venue_id' => 1]);
        $I->cantSeeElement('.view-edit-button');

        //admin
        $I->amLoggedInAsAdmin();
        $I->amOnRoute('/venue/view', ['venue_id' => 1]);
        $I->canSeeElement('.view-edit-button');

        //manager
        $I->amLoggedInAs(10);
        $I->amOnRoute('/venue/view', ['venue_id' => 1]);
        $I->canSeeElement('.view-edit-button');

        //non-manager
        $I->amLoggedInAs(11);
        $I->amOnRoute('/venue/view', ['venue_id' => 1]);
        $I->cantSeeElement('.view-edit-button');
    }

}
