<?php

declare(strict_types = 1);

namespace app\models\search;

use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\db\Expression;

/**
 * @category  Project
 * @package   {{package}}
 * @author    George Cadwallader <georgecadwallader77@gmail.com>
 * @copyright 2020
 */
class ReportSearch extends \app\models\ReviewReport
{

    /**
     * The rules for the ReportSearch model
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
                ],
                'sort' => [
                    'defaultOrder' => [
                        'created_at' => SORT_DESC,
                    ],
                ]
            ]
        );

        if (!$this->load($params) || !$this->validate()) {
            return $dataProvider;
        }

        $dataProvider->query->andFilterWhere([
            'AND',
            ['=', 'type', $this->type],
            ['=', 'context', $this->context],
            ['=', 'status', $this->status],
        ]);

        return $dataProvider;
    }

}