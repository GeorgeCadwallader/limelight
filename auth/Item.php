<?php

namespace app\auth;

/**
 * Authentication role and permissions for the app
 *
 * @category  Project
 * @package   {{package}}
 * @author    George Cadwallader <georgecadwallader77@gmail.com>
 * @copyright 2020
 */
class Item extends \yii\rbac\Item
{

    /**
     * Main roles
     */
    const ROLE_ADMIN = 'Admin';
    const ROLE_MEMBER = 'Member';
    const ROLE_ARTIST_OWNER = 'Artist Owner';
    const ROLE_VENUE_OWNER = 'Venue Owner';

}
