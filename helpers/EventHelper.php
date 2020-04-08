<?php

declare(strict_types = 1);

namespace app\helpers;

use app\models\Event;

/**
 * Event helper class
 */
class EventHelper
{

    /**
     * Gets the image url for the event
     * 
     * @param Event $event
     * @return string
     */
    public static function imageUrl(Event $event): string
    {
        if ($event->artist->data->profile_path !== null) {
            return '/images/artist/'.$event->artist->data->profile_path;
        }

        if ($event->venue->data->profile_path !== null) {
            return '/images/venue/'.$event->venue->data->profile_path;
        }

        return '/images/logo.png';
    }

    /**
     * Creates the event name
     * 
     * @param Event $event
     * @return string
     */
    public static function eventName(Event $event): string
    {
        return $event->artist->name.' - '.$event->venue->name;
    }

}