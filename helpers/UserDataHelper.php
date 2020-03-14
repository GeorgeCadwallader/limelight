<?php

declare(strict_types = 1);

namespace app\helpers;

use app\models\UserData;

/**
 * UserData helper class
 */
class UserDataHelper
{

    /**
     * Gets the image url for the user
     * 
     * @param UserData $userData
     * @return string
     */
    public static function imageUrl(UserData $userData): string
    {
        if ($userData->profile_path !== null) {
            return '/images/user/'.$userData->profile_path;
        }

        return '/images/logo.png';
    }

}