<?php

namespace frontend\models;

use common\models\Income;
use common\models\IncomeProductLink;
use common\models\Product;
use common\models\Sale;
use common\models\SaleProductLink;
use common\models\Unit;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Query;

/**
 * @property integer $id
 * @property integer $product_id
 * @property string $date_from
 * @property string $date_to
 * @property string $date_time
 * @property integer $type
 * @property integer $income_amount
 * @property string $income_unit_title
 * @property integer $sale_amount
 * @property string $sale_unit_title
 * @property integer $price
 * @property integer $income_total
 * @property integer $sale_total
 * @property string $comment
 *
 * @property Product $product
 */
class ProductStatSearch extends Model
{

    public $id;
    public $product_id;
    public $product_name;
    public $date_from;
    public $date_to;

    public $date_time;
    public $type;
    public $income_amount;
    public $income_unit_title;
    public $sale_amount;
    public $sale_unit_title;
    public $price;
    public $income_total;
    public $sale_total;
    public $comment;

    const TYPE_INCOME = 2;
    const TYPE_SALE = 3;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date_from', 'date_to'], 'safe'],
            [['product_id', 'type'], 'integer'],
        ];
    }


    public function attributeLabels()
    {
        return [
            'product_id' => 'Маҳсулот',
            'date_from' => 'дан',
            'date_to' => 'гача',

            'date_time' => 'Сана',
            'product_name' => 'Маҳсулот',
            'type' => 'Тури',

            'income_price' => 'Кирим нархи',
            'income_amount' => 'Кирим миқдори',
            'income_unit_title' => 'Бирлиги',
            'income_total' => 'Жами кирим',

            'sale_amount' => 'Сотув миқдори',
            'sale_unit_title' => 'Бирлиги',
            'sale_price' => 'Сотув нархи',
            'sale_total' => 'Жами сотув',

            'comment' => 'Изоҳ',
        ];
    }

    public function search($params)
    {

        $income = IncomeProductLink::find()
            ->alias('il')
            ->select("
                i.date_time,
                CASE WHEN (true) THEN 'Кирим' ELSE 'Сотув' END as type,
                p.title                as product_name,
                il.amount              as income_amount,
                u.title                as income_unit_title,
                il.price               as income_price,
                (il.amount * il.price) as income_total,
                CAST(null as CHAR)     as sale_amount,
                CAST(null as CHAR)     as sale_unit_title,
                CAST(null as CHAR)     as sale_price,
                CAST(null as CHAR)     as sale_total,
                i.comment
                ")
            ->innerJoin(['i' => Income::tableName()], 'i.id = il.income_id')
            ->innerJoin(['p' => Product::tableName()], 'p.id = il.product_id')
            ->innerJoin(['u' => Unit::tableName()], 'u.id = p.unit_id')
            ->where(['il.status' => Sale::STATUS_ACTIVE]);


        $sale = SaleProductLink::find()
            ->alias('sl')
            ->select("
                s.date_time,
                CASE WHEN (false) THEN 'Кирим' ELSE 'Сотув' END as type,
                p.title                as product_name,
                CAST(null as CHAR)     as income_amount,
                CAST(null as CHAR)     as income_unit_title,
                CAST(null as CHAR)     as income_price,
                CAST(null as CHAR)     as income_total,
                sl.amount              as sale_amount,
                u.title                as sale_unit_title,
                sl.price               as sale_price,
                (sl.amount * sl.price) as sale_total,
                s.comment
                ")
            ->innerJoin(['s' => Sale::tableName()], 's.id = sl.sale_id')
            ->innerJoin(['p' => Product::tableName()], 'p.id = sl.product_id')
            ->innerJoin(['u' => Unit::tableName()], 'u.id = p.unit_id')
            ->where(['sl.status' => Sale::STATUS_ACTIVE]);

        $this->load($params);

        $income
            ->andWhere(['il.product_id' => $this->product_id])
            ->andFilterWhere(['>=', "DATE_FORMAT(i.date_time, '%Y-%m-%d')", $this->date_from])
            ->andFilterWhere(['<=', "DATE_FORMAT(i.date_time, '%Y-%m-%d')", $this->date_to]);

        $sale
            ->andWhere(['sl.product_id' => $this->product_id])
            ->andFilterWhere(['>=', "DATE_FORMAT(s.date_time, '%Y-%m-%d')", $this->date_from])
            ->andFilterWhere(['<=', "DATE_FORMAT(s.date_time, '%Y-%m-%d')", $this->date_to]);

        $allQuery = (new Query())
            ->from([$income->union($sale)])
            ->orderBy(['date_time' => SORT_ASC]);

        if ($this->type == self::TYPE_INCOME)
            $allQuery
                ->andWhere('income_amount > 0');

        if ($this->type == self::TYPE_SALE)
            $allQuery
                ->andWhere('sale_amount > 0');

        return
            new ActiveDataProvider([
                'query' => $allQuery,
                'pagination' => ['pageSize' => 0]
            ]);

    }

    public function loadDefaultSearchParams()
    {
        $this->date_from = date('Y-m-01');
        $this->date_to = date('Y-m-d');
    }

    public function getProduct()
    {
        return Product::findOne($this->product_id);
    }

}
