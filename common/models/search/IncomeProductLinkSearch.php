<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\IncomeProductLink;

/**
 * IncomeProductLinkSearch represents the model behind the search form of `common\models\IncomeProductLink`.
 */
class IncomeProductLinkSearch extends IncomeProductLink
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'income_id', 'product_id', 'amount', 'price', 'status', 'creator_id', 'modifier_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
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
        $query = IncomeProductLink::find()
            ->select([
                '*',
                'total_price' => '(price * amount)'
            ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) return $dataProvider;

        $query->andFilterWhere([
            'id' => $this->id,
            'income_id' => $this->income_id,
            'product_id' => $this->product_id,
            'amount' => $this->amount,
            'price' => $this->price,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'creator_id' => $this->creator_id,
            'modifier_id' => $this->modifier_id,
        ]);

        return $dataProvider;
    }
}
