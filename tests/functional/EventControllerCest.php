<?php

declare(strict_types = 1);

use app\models\Event;

/**
 * @category  Project
 * @package   {{package}}
 * @author    George Cadwallader <georgecadwallader77@gmail.com>
 * @copyright 2020 Limelight
 */
class EventControllerCest
{

    /**
     * Test the index action of the EventController
     * 
     * @param \FunctionalTester $I
     * 
     * @return void
     */
    public function testIndex(\FunctionalTester $I): void
    {
        $I->amOnRoute('/event');
        $I->seeResponseCodeIsSuccessful();

        $I->amLoggedInAsAdmin();
        $I->amOnRoute('/event');
        $I->seeResponseCodeIsSuccessful();

        $I->amLoggedInAsArtistOwner();
        $I->amOnRoute('/event');
        $I->seeResponseCodeIsSuccessful();

        $I->amLoggedInAsVenueOwner();
        $I->amOnRoute('/event');
        $I->seeResponseCodeIsSuccessful();

        $I->amLoggedInAsMember();
        $I->amOnRoute('/event');
        $I->seeResponseCodeIsSuccessful();
    }

    /**
     * Test creating a new event combination
     * 
     * @param \FunctionalTester $I
     * 
     * @return void
     */
    public function testCreateNew(\FunctionalTester $I): void
    {
        $I->amLoggedInAs(7);
        $I->amOnRoute('/event/create');

        $I->submitForm('#create-event', [
            'Event' => [
                'artist_id' => 3,
                'venue_id' => 4
            ]
        ]);

        $event = Event::find()
            ->where(['artist_id' => 3])
            ->andWhere(['venue_id' => 4]);

        $I->assertNotNull($event->one());
        $I->assertEquals(1, (int)$event->count());
        $I->assertEquals(1, $event->one()->creations);
        $I->assertCount(1, $event->one()->userEvents);
    }

    /**
     * Test creating an event with the same user
     * 
     * @param \FunctionalTester
     * 
     * @return void
     */
    public function testCreateExisting(\FunctionalTester $I): void
    {
        $I->wantToTest('creating a new event with same user');

        $I->amLoggedInAs(7);
        $I->amOnRoute('/event/create');

        $I->submitForm('#create-event', [
            'Event' => [
                'artist_id' => 3,
                'venue_id' => 3
            ]
        ]);

        $event = Event::find()
            ->where(['artist_id' => 3])
            ->andWhere(['venue_id' => 3]);

        $I->assertCount(1, $event->all());
        $I->assertEquals(1, $event->one()->creations);
        $I->assertCount(1, $event->one()->userEvents);
    }

    /**
     * Test creating an existing event with a different user
     * 
     * @param \FunctionalTester
     * 
     * @return void
     */
    public function testCreateExistingNewUser(\FunctionalTester $I): void
    {
        $I->wantToTest('creating an existing event with different user');

        $I->amLoggedInAs(13);
        $I->amOnRoute('/event/create');

        $I->submitForm('#create-event', [
            'Event' => [
                'artist_id' => 3,
                'venue_id' => 3
            ]
        ]);

        $event = Event::find()
            ->where(['artist_id' => 3])
            ->andWhere(['venue_id' => 3]);

        $I->assertCount(1, $event->all());
        $I->assertEquals(2, $event->one()->creations);
        $I->assertCount(2, $event->one()->userEvents);
    }

}
