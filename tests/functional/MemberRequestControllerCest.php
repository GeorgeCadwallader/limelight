<?php

declare(strict_types = 1);

use app\models\Artist;
use app\models\MemberRequest;
use app\models\Venue;

/**
 * @category  Project
 * @package   {{package}}
 * @author    George Cadwallader <georgecadwallader77@gmail.com>
 * @copyright 2020 Limelight
 */
class MemberRequestControllerCest
{

    /**
     * Test create request for an artist
     * 
     * @param \FunctionalTester $I
     * 
     * @return void
     */
    public function testCreateRequestArtist(\FunctionalTester $I): void
    {
        $I->amLoggedInAsMember();
        $I->amOnRoute('/artist');

        $I->submitForm('#member-request-create', [
            'MemberRequest' => [
                'type' => MemberRequest::TYPE_ARTIST_REQUEST,
                'status' => MemberRequest::STATUS_ACTIVE,
                'request_name' => 'Snow Patrol'
            ]
        ]);

        $memberRequest = MemberRequest::find()
            ->where(['type' => MemberRequest::TYPE_ARTIST_REQUEST])
            ->andWhere(['request_name' => 'Snow Patrol']);

        $I->assertTrue($memberRequest->exists());
        $I->assertEquals(MemberRequest::TYPE_ARTIST_REQUEST, $memberRequest->one()->type);
        $I->assertEquals(1, $memberRequest->one()->request_count);
    }

    /**
     * Test create request for a venue
     * 
     * @param \FunctionalTester $I
     * 
     * @return void
     */
    public function testCreateRequestVenue(\FunctionalTester $I): void
    {
        $I->amLoggedInAsMember();
        $I->amOnRoute('/venue');

        $I->submitForm('#member-request-create', [
            'MemberRequest' => [
                'type' => MemberRequest::TYPE_VENUE_REQUEST,
                'status' => MemberRequest::STATUS_ACTIVE,
                'request_name' => 'Globe Theater'
            ]
        ]);

        $memberRequest = MemberRequest::find()
            ->where(['type' => MemberRequest::TYPE_VENUE_REQUEST])
            ->andWhere(['request_name' => 'Globe Theater']);

        $I->assertTrue($memberRequest->exists());
        $I->assertEquals(MemberRequest::TYPE_VENUE_REQUEST, $memberRequest->one()->type);
        $I->assertEquals(1, $memberRequest->one()->request_count);
    }

    /**
     * Test to create an existing artist request
     * 
     * @param \FunctionalTester $I
     * 
     * @return void
     */
    public function testCreateRequestArtistExisting(\FunctionalTester $I): void
    {
        $I->amLoggedInAsMember();
        $I->amOnRoute('/artist');

        $I->submitForm('#member-request-create', [
            'MemberRequest' => [
                'request_name' => 'Oasis'
            ]
        ]);

        $memberRequest = MemberRequest::find()
            ->where(['request_name' => 'Oasis'])
            ->andWhere(['type' => MemberRequest::TYPE_ARTIST_REQUEST]);

        $I->assertTrue($memberRequest->exists());
        $I->assertEquals(1, $memberRequest->count());
        $I->assertEquals(2, $memberRequest->one()->request_count);
    }

    /**
     * Test to create an existing venue request
     * 
     * @param \FunctionalTester $I
     * 
     * @return void
     */
    public function testCreateRequestVenueExisting(\FunctionalTester $I): void
    {
        $I->amLoggedInAsMember();
        $I->amOnRoute('/venue');

        $I->submitForm('#member-request-create', [
            'MemberRequest' => [
                'request_name' => 'Playhouse'
            ]
        ]);

        $memberRequest = MemberRequest::find()
            ->where(['request_name' => 'Playhouse'])
            ->andWhere(['type' => MemberRequest::TYPE_VENUE_REQUEST]);

        $I->assertTrue($memberRequest->exists());
        $I->assertEquals(1, $memberRequest->count());
        $I->assertEquals(2, $memberRequest->one()->request_count);
    }

    /**
     * Approve a request to create an artist in the Admin panel
     * 
     * @param \FunctionalTester $I
     * 
     * @return void
     */
    public function testApproveRequestArtist(\FunctionalTester $I): void
    {
        $memberRequest = MemberRequest::findOne(1);

        $I->amLoggedInAsAdmin();
        $I->amOnRoute(
            '/member-request/approve-request',
            [
                'member_request_id' => $memberRequest->member_request_id,
                'type' => MemberRequest::TYPE_ARTIST_REQUEST
            ]
        );

        $memberRequest->refresh();

        $artist = Artist::find()
            ->where(['name' => $memberRequest->request_name])
            ->andWhere(['status' => Artist::STATUS_ACTIVE]);

        $I->assertTrue($artist->exists());
        $I->assertEquals($memberRequest->request_name, $artist->one()->name);
        $I->assertEquals(MemberRequest::STATUS_APPROVED, $memberRequest->status);
    }

    /**
     * Approve a request to create an venue in the Admin panel
     * 
     * @param \FunctionalTester $I
     * 
     * @return void
     */
    public function testApproveRequestVenue(\FunctionalTester $I): void
    {
        $memberRequest = MemberRequest::findOne(1);

        $I->amLoggedInAsAdmin();
        $I->amOnRoute(
            '/member-request/approve-request',
            [
                'member_request_id' => $memberRequest->member_request_id,
                'type' => MemberRequest::TYPE_VENUE_REQUEST
            ]
        );

        $memberRequest->refresh();

        $venue = Venue::find()
            ->where(['name' => $memberRequest->request_name])
            ->andWhere(['status' => Venue::STATUS_ACTIVE]);

        $I->assertTrue($venue->exists());
        $I->assertEquals($memberRequest->request_name, $venue->one()->name);
        $I->assertEquals(MemberRequest::STATUS_APPROVED, $memberRequest->status);
    }

}
