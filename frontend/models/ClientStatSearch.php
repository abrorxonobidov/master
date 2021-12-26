<?php

namespace frontend\models;

use common\models\Client;
use common\models\Payment;
use common\models\PayType;
use common\models\Sale;
use common\models\SaleProductLink;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Query;

/**
 * @property integer $client_id
 * @property integer $pay_type_id
 * @property string $date_from
 * @property string $date_to
 */
class ClientStatSearch extends Model
{
    public $id;
    public $client_id;
    public $type;
    public $client_name;
    public $date_from;
    public $date_to;
    public $pay_type_id;
    public $price_sale;
    public $price_payment;
    public $date_time;
    public $pay_type_title;
    public $comment;

    public function rules()
    {
        return [
            [['date_from', 'date_to', 'type', 'date_time', 'client_name', 'type', 'comment'], 'safe'],
            [['client_id', 'pay_type_id', 'price_sale', 'price_payment'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client_id' => 'Мижоз',
            'client_name' => 'Мижоз',
            'date_from' => 'дан',
            'date_to' => 'гача',
            'type' => 'Тури',
            'pay_type_id' => 'Тулов тури',
            'price_sale' => 'Харид нархи',
            'price_payment' => 'Тўлов нархи',
            'date_time' => 'Сана',
            'pay_type_title' => 'Тўлов тури',
            'currency' => 'Валюта',
            'comment' => 'Изоҳ',
        ];
    }

    public function search($params)
    {

        $salesQuery = Sale::find()
            ->alias('s')
            ->select([
                'p.id',
                'client_name' => 'c.name',
                'price_sale' => 'SUM(s_p_l.price * s_p_l.amount)',
                'price_payment' => "p.price",
                'type' => "CASE WHEN (p.id IS NULL OR p.price <= 0) THEN 'Ҳарид' ELSE 'Ҳарид + Тўлов' END",
                's.client_id',
                's.date_time',
                'p.pay_type_id',
                's.comment',
            ])
            ->leftJoin(['p' => Payment::tableName()], 'p.sale_id = s.id')
            ->innerJoin(['c' => Client::tableName()], 'c.id = s.client_id')
            ->leftJoin(['s_p_l' => SaleProductLink::tableName()], 's_p_l.sale_id = s.id')
            ->where([
                's.status' => Sale::STATUS_ACTIVE,
                'p.status' => Sale::STATUS_ACTIVE,

            ])
            ->groupBy([
                'client_name', 'price_payment', 'type',
                's.client_id', 's.date_time', 'p.pay_type_id', 'p.comment'
            ]);

        $paymentQuery = Payment::find()
            ->alias('p')
            ->select([
                'p.id',
                'client_name' => 'c.name',
                'price_sale' => "CASE WHEN (1=1) THEN 0 ELSE 0 END",
                'price_payment' => 'p.price',
                'type' => "CASE WHEN (sale_id IS NULL) THEN 'Тўлов' ELSE 'Ҳарид + Тўлов' END",
                'p.client_id',
                'p.date_time',
                'p.pay_type_id',
                'p.comment',
            ])
            ->innerJoin(['c' => Client::tableName()], 'c.id = p.client_id')
            ->where([
                'p.status' => Payment::STATUS_ACTIVE,
                'p.sale_id' => null,
            ]);

        $this->load($params);

        $paymentQuery
            ->andWhere(['p.client_id' => $this->client_id])
            ->andFilterWhere(['p.pay_type_id' => $this->pay_type_id])
            ->andFilterWhere(['>=', "DATE_FORMAT(p.date_time, '%Y-%m-%d')", $this->date_from])
            ->andFilterWhere(['<=', "DATE_FORMAT(p.date_time, '%Y-%m-%d')", $this->date_to]);

        $salesQuery
            ->andWhere(['s.client_id' => $this->client_id])
            ->andFilterWhere(['p.pay_type_id' => $this->pay_type_id])
            ->andFilterWhere(['>=', "DATE_FORMAT(s.date_time, '%Y-%m-%d')", $this->date_from])
            ->andFilterWhere(['<=', "DATE_FORMAT(s.date_time, '%Y-%m-%d')", $this->date_to]);

        $allQuery = (new Query())
            ->select([
                'h.id',
                'h.client_name',
                'h.price_sale',
                'h.price_payment',
                'h.type',
                'h.client_id',
                'h.date_time',
                'h.pay_type_id',
                'pay_type_title' => 'p_t.title',
                'h.comment',
            ])
            ->from(['h' => $paymentQuery->union($salesQuery)/*->asArray()*/])
            ->innerJoin(['p_t' => PayType::tableName()], 'p_t.id = h.pay_type_id')
            ->orderBy(['date_time' => SORT_ASC, 'id' => SORT_ASC]);;

        return
            new ActiveDataProvider([
                'query' => $allQuery,
                'pagination' => ['pageSize' => 0]
            ]);


    }

    public function loadDefaultSearchParams(&$params)
    {
        if (empty($params)) {
            $this->date_from = date('Y-m-01');
            $this->date_to = date('Y-m-d');
        }
    }

    public function getSaleInitialRemainder()
    {
        return
            SaleProductLink::find()
                ->alias('spl')
                ->select('SUM(spl.amount * spl.price)')
                ->innerJoin(['s' => Sale::tableName()], 's.id = spl.sale_id')
                ->where([
                    's.client_id' => $this->client_id,
                    's.status' => Sale::STATUS_ACTIVE
                ])
                ->andWhere(['<', 's.date_time', $this->date_from])
                ->column()[0] ?? 0;
    }

    public function getPaymentInitialRemainder()
    {
        return
            Payment::find()
                ->alias('p')
                ->select('SUM(p.price)')
                ->leftJoin(['s' => Sale::tableName()], 's.id = p.sale_id')
                ->where([
                    'p.client_id' => $this->client_id,
                    'p.status' => Sale::STATUS_ACTIVE
                ])
                ->andWhere('s.status IS NULL OR s.status = 1')
                ->andWhere(['<', 'p.date_time', $this->date_from])
                ->column()[0] ?? 0;
    }

}
