<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Client;

/**
 * ClientSearch represents the model behind the search form of `common\models\Client`.
 */
class ClientSearch extends Client
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'order', 'status', 'creator_id', 'modifier_id'], 'integer'],
            [['name', 'phone', 'car_number', 'car_model', 'address', 'image', 'comment', 'created_at', 'updated_at'], 'safe'],
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
        $query = Client::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['name' => SORT_ASC, 'id' => SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate())  return $dataProvider;

        $query->andFilterWhere([
            'id' => $this->id,
            'order' => $this->order,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'creator_id' => $this->creator_id,
            'modifier_id' => $this->modifier_id,
        ]);
        $query
            ->andFilterWhere(
                [
                    'or',
                    [
                        'like', 'name', $this->name
                    ],
                    [
                        'like', 'phone', $this->name
                    ],
                    [
                        'like', 'address', $this->name
                    ]
                ]
            )
            ->andFilterWhere(
                [
                    'or',
                    [
                        'like', 'car_model', $this->car_number
                    ],
                    [
                        'like', 'car_number', $this->car_number
                    ],
                ]
            );
        $query
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
