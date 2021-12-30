<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Payment;

/**
 * PaymentSearch represents the model behind the search form of `common\models\Payment`.
 */
class PaymentSearch extends Payment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'client_id', 'pay_type_id', 'sale_id', 'price', 'status', 'creator_id', 'modifier_id'], 'integer'],
            [['date_time', 'comment', 'created_at', 'updated_at', 'date_from', 'date_to'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @param null $condition
     * @param int $pageSize
     * @return ActiveDataProvider
     */
    public function search($params, $condition = null, $pageSize = 20)
    {
        $query = Payment::find()
            ->andWhere($condition);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['date_time' => SORT_DESC]],
            'pagination' => ['pageSize' => $pageSize],
        ]);

        $this->load($params);

        if (!$this->validate()) return $dataProvider;

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'client_id' => $this->client_id,
            'pay_type_id' => $this->pay_type_id,
            'sale_id' => $this->sale_id,
            'price' => $this->price,
            'date_time' => $this->date_time,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'creator_id' => $this->creator_id,
            'modifier_id' => $this->modifier_id,
        ]);

        $query->andFilterWhere(['like', 'comment', $this->comment]);
        $query->andFilterWhere(['>=', "DATE_FORMAT(date_time, '%Y-%m-%d')", $this->date_from])
            ->andFilterWhere(['<=', "DATE_FORMAT(date_time, '%Y-%m-%d')", $this->date_to]);

        return $dataProvider;
    }

    public function searchForStat($params)
    {
        $query = Payment::find()
            ->select([
                '*',
                'type' => "CASE WHEN (sale_id IS NULL) THEN 'Тўлов' ELSE 'Ҳарид + Тўлов' END",
            ])
            ->where(['status' => Payment::STATUS_ACTIVE])
            ->andWhere(['>', 'price', 0]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['date_time' => SORT_ASC]],
            'pagination' => ['pageSize' => 1000],
        ]);

        $this->load($params);

        if (!$this->validate()) return $dataProvider;

        $query
            ->andFilterWhere([
                'client_id' => $this->client_id,
                'pay_type_id' => $this->pay_type_id
            ])
            ->andFilterWhere(['>=', "DATE_FORMAT(date_time, '%Y-%m-%d')", $this->date_from])
            ->andFilterWhere(['<=', "DATE_FORMAT(date_time, '%Y-%m-%d')", $this->date_to]);

        return $dataProvider;
    }
}
