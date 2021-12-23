<?php

namespace common\models\search;

use common\models\Sale;
use common\models\SaleProductLink;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SaleSearch represents the model behind the search form of `common\models\Sale`.
 */
class SaleSearch extends Sale
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'client_id', 'comment', 'status', 'creator_id', 'modifier_id'], 'integer'],
            [['date_time', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Sale::find()
            ->alias('s')
            ->select([
                's.id',
                's.date_time',
                's.client_id',
                's.comment',
                's.status',
                'sum' => 'SUM(spl.price * spl.amount)'
            ])
            ->leftJoin(['spl' => SaleProductLink::tableName()], 'spl.sale_id = s.id')
            ->groupBy(['s.id', 's.date_time', 's.client_id', 's.comment', 's.status']);


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) return $dataProvider;

        $query->andFilterWhere([
            's.id' => $this->id,
            's.client_id' => $this->client_id,
            's.date_time' => $this->date_time,
            's.comment' => $this->comment,
            's.status' => $this->status,
            's.created_at' => $this->created_at,
            's.updated_at' => $this->updated_at,
            's.creator_id' => $this->creator_id,
            's.modifier_id' => $this->modifier_id,
        ]);

        return $dataProvider;
    }
}
