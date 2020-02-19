<?php

namespace app\models;

use app\auth\Item;
use Yii;

use yii\db\ActiveQueryInterface;

/**
 * Venue Owner model for all of the venue owner specific methods
 * 
 * @category Project
 * @package {{package}}
 * @author George Cadwallader <georgecadwallader77@gmail.com>
 * @copyright 2020
 */
class VenueOwner extends User
{

    public static function find(): ActiveQueryInterface
    {
        $member_ids = Yii::$app->authManager->getUserIdsByRole(Item::ROLE_VENUE_OWNER);
        return parent::find()->andWhere(['IN', '{{%user}}.[[user_id]]', $member_ids]);
    }

}