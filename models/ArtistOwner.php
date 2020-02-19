<?php

namespace app\models;

use app\auth\Item;
use Yii;

use yii\db\ActiveQueryInterface;

/**
 * Artist Owner model for all of the Artist Owner specific methods
 * 
 * @category Project
 * @package {{package}}
 * @author George Cadwallader <georgecadwallader77@gmail.com>
 * @copyright 2020
 */
class ArtistOwner extends User
{

    public static function find(): ActiveQueryInterface
    {
        $member_ids = Yii::$app->authManager->getUserIdsByRole(Item::ROLE_ARTIST_OWNER);
        return parent::find()->andWhere(['IN', '{{%user}}.[[user_id]]', $member_ids]);
    }

}