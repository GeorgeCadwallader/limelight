<?php

declare(strict_types = 1);

namespace app\models\search;

use app\models\ReviewArtist;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

/**
 * @category  Project
 * @package   {{package}}
 * @author    George Cadwallader <georgecadwallader77@gmail.com>
 * @copyright 2020
 */
class ArtistFilterSearch extends \app\models\Artist
{

    /**
     * The rules for the Artist Search model
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
        $query = self::find()->joinWith(['reviews'])->where(['{{%artist}}.[[status]]' => self::STATUS_ACTIVE]);
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
                    'pageSize' => 10,
                ],
                'sort' => [
                    'attributes' => [
                        'name',
                        'created_at' => ['label' => 'Created'],
                        'overall_rating',
                    ],
                    'defaultOrder' => [
                        'overall_rating' => SORT_DESC,
                    ],  
                ]
            ]
        );

        if (!$this->load($params) || !$this->validate()) {
            return $dataProvider;
        }

        $dataProvider->query->andFilterWhere([
            'AND',
            ['LIKE', 'name', $this->name],
            ['=', 'status', $this->status]
        ]);

        return $dataProvider;
    }

}
