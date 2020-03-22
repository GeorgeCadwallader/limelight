<?php

declare(strict_types = 1);

namespace app\helpers;

use app\auth\Item;
use app\models\Artist;
use app\models\ReviewArtist;
use app\models\User;
use app\models\UserBadge;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Badge helper class
 */
class BadgeHelper
{

    /**
     * Adds a badge for a user
     * 
     * @return void
     */
    public static function addBadge(User $user, int $type): void
    {
        $hasBadge = UserBadge::find()
            ->where(['user_id' => $user->user_id])
            ->andWhere(['type' => $type]);

        if ($hasBadge->exists()) {
            return;
        }

        $userBadge = new UserBadge([
            'user_id' => $user->user_id,
            'type' => $type,
        ]);

        $userBadge->save();
    }

}