<?php

namespace common\models\search;

use common\models\IncomeProductLink;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Income;

/**
 * IncomeSearch represents the model behind the search form of `common\models\Income`.
 */
class IncomeSearch extends Income
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'creator_id', 'modifier_id'], 'integer'],
            [['date_time', 'comment', 'created_at', 'updated_at'], 'safe'],
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
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Income::find()
            ->alias('i')
            ->select([
                'i.id',
                'i.date_time',
                'i.excavator_id',
                'i.truck_id',
                'i.comment',
                'i.status',
                'sum' => 'SUM(ipl.price * ipl.amount)'
            ])
            ->leftJoin(['ipl' => IncomeProductLink::tableName()], 'ipl.income_id = i.id')
            ->groupBy(['i.id', 'i.date_time', 'i.excavator_id', 'i.truck_id', 'i.comment', 'i.status']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'i.id' => $this->id,
            'i.date_time' => $this->date_time,
            'i.status' => $this->status,
            'i.created_at' => $this->created_at,
            'i.updated_at' => $this->updated_at,
            'i.creator_id' => $this->creator_id,
            'i.modifier_id' => $this->modifier_id,
        ]);

        $query->andFilterWhere(['like', 'i.comment', $this->comment]);

        return $dataProvider;
    }
}
