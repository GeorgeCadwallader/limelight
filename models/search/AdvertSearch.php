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
class AdvertSearch extends \app\models\Advert
{

    /**
     * The rules for the AdvertSearch model
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
                'pagination' => [
                    'pageSize' => 20,
                ]
            ]
        );

        if (!$this->load($params) || !$this->validate()) {
            return $dataProvider;
        }

        $dataProvider->query->andFilterWhere([
            'AND',
            ['=', 'type', $this->type],
            ['LIKE', 'message', $this->message],
            ['=', 'appearances', $this->appearances],
            ['=', 'advert_type', $this->advert_type],
            ['=', 'region_id', $this->region_id],
            ['=', 'genre_id', $this->genre_id],
            ['=', 'status', $this->status],
        ]);

        return $dataProvider;
    }

}
