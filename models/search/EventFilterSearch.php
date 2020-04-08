<?php

declare(strict_types = 1);

namespace app\models\search;

use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

/**
 * @category  Project
 * @package   {{package}}
 * @author    George Cadwallader <georgecadwallader77@gmail.com>
 * @copyright 2020
 */
class EventFilterSearch extends \app\models\Event
{

    /**
     * The rules for the Event Search model
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = parent::rules();
        return $rules;
    }

    /**
     * Generate the data provider adding all of the filter on the query params
     *
     * @param array $params The params the add all of the filters on
     *
     * @return ActiveDataProvider
     */
    public function search(array $params = []): ActiveDataProvider
    {
        $query = self::find();
        return $this->getDataProvider($query, $params);
    }

    /**
     * Get the data provider filtering and adding all of the default sorting and
     * rules.
     *
     * @param ActiveQuery $query
     * @param array       $params
     *
     * @return ActiveDataProvider
     */
    protected function getDataProvider(ActiveQuery $query, array $params = []): ActiveDataProvider
    {
        $dataProvider = new ActiveDataProvider(
            [
                'query' => $query,
                'sort' => [
                    'attributes' => [
                        'creations' => ['label' => 'Hot'],
                        'created_at' => ['label' => 'Latest'],
                    ],
                    'defaultOrder' => ['creations' => SORT_DESC],  
                ]
            ]
        );

        if (!$this->load($params) || !$this->validate()) {
            return $dataProvider;
        }

        return $dataProvider;
    }

}
