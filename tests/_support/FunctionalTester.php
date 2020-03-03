<?php

declare(strict_types=1);

use app\auth\Item;
use app\models\User;

use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
*/
class FunctionalTester extends \Codeception\Actor
{
    use _generated\FunctionalTesterActions;

    /**
     * Gets a user from the database with a specified role
     *
     * @param string $role
     *
     * @return User
     */
    public function grabUserByRole(string $role): User
    {
        $ids = \Yii::$app->authManager->getUserIdsByRole($role);
        if (count($ids) === 0) {
            throw new \Exception('There is no users with the role of ' . $role);
        }

        return User::findOne($ids[0]);
    }

    /**
     * Logs the user in as an admin
     *
     * @return void
     */
    public function amLoggedInAsAdmin(): void
    {
        $this->amLoggedInAs($this->grabUserByRole(Item::ROLE_ADMIN));
    }

    /**
     * Logs the user in as an artist owner
     *
     * @return void
     */
    public function amLoggedInAsArtistOwner(): void
    {
        $this->amLoggedInAs($this->grabUserByRole(Item::ROLE_ARTIST_OWNER));
    }

    /**
     * Logs the user in as a venue owner
     *
     * @return void
     */
    public function amLoggedInAsVenueOwner(): void
    {
        $this->amLoggedInAs($this->grabUserByRole(Item::ROLE_VENUE_OWNER));
    }

    /**
     * Logs the user in as a member
     *
     * @return void
     */
    public function amLoggedInAsMember(): void
    {
        $this->amLoggedInAs($this->grabUserByRole(Item::ROLE_MEMBER));
    }

    /**
     * Sends a ajax request an a url with data.
     *
     * The data provided to this function is a json string this is decode and
     * passed to the `sendAjaxPostRequest` function with a csrf token appended.
     *
     * The last param is an array of data that will be set into the decode json
     * array
     *
     * @param string $url
     * @param string $json
     * @param array $dynamicData
     *
     * @return void
     */
    public function sendAjaxPostJsonRequest(string $url, string $json, array $dynamicData = []): void
    {
        $data = Json::decode($json);
        $csrf = $this->createAndSetCsrfCookie(Yii::$app->security->generateRandomString(4));

        $dynamicData[$csrf[0]] = $csrf[1];
        foreach ($dynamicData as $key => $value) {
            ArrayHelper::setValue($data, $key, $value);
        }

        $this->sendAjaxPostRequest($url, $data);
    }

    /**
     * Sets the mysql mode to remove strict group by.
     *
     * @return void
     */
    public function setMySqlMode(): void
    {
        $sql = 'SET sql_mode = \'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION\'';
        Yii::$app->db->createCommand($sql)->execute();
    }

}
