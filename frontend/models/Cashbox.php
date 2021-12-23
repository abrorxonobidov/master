<?php

namespace frontend\models;

use common\models\Expense;
use common\models\Payment;
use yii\base\Model;
use yii\data\ArrayDataProvider;
use yii\db\Expression;
use yii\db\Query;

/**
 * Cashbox is the model behind the contact form.
 * @property string $name
 * @property string $date_on
 * @property string $date_time
 * @property string $date_from
 * @property string $date_to
 * @property string $type
 * @property string $balance
 * @property string $expense
 * @property string $prevTotal
 * @property string $newTotal
 */
class Cashbox extends Model
{
    public $name;
    public $date_on;
    public $date_time;
    public $date_from;
    public $date_to;
    public $type;
    public $balance;
    public $expense;
    public $prevTotal;
    public $newTotal;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'date_on', 'date_time', 'type', 'date_from', 'date_to'], 'safe'],
            [['balance', 'expense', 'prevTotal', 'newTotal'], 'integer'],
        ];
    }

    public function formName()
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Номи',
            'type' => 'Тури',
            'date_time' => 'Вақт',
            'date_on' => 'Сана',
            'balance' => 'Тушум',
            'expense' => 'Ҳаражат',
            'prevTotal' => 'Кун бошидаги қолдиқ',
            'newTotal' => 'Кун якунидаги қолдиқ',
        ];
    }

    public function search($params)
    {
        $this->load($params);
        $paymentsQuery = Payment::find()
            ->alias('p')
            ->select(new Expression("
            IF(p.sale_id IS NULL,'Тўлов ','Савдо ') AS type,
            p.date_time,
            c.name, 
            p.price AS balance,0 AS expense"))
            ->innerJoin('client c', "c.id=p.client_id")
            ->where(['p.status' => Payment::STATUS_ACTIVE, 'p.pay_type_id' => 1])
            ->andWhere('p.price > 0')
            ->asArray();
        $expensesQuery = Expense::find()
            ->alias('e')
            ->select(new Expression("
            'Ҳаражат ' AS type,
            e.date_time,
            et.title AS name,
            0 AS balance,
            e.price AS expense"))
            ->innerJoin('expense_type et', "et.id=e.expense_type_id")
            ->where(['e.status' => Expense::STATUS_ACTIVE])
            ->asArray();

        $balance = $this->getBalance(clone $paymentsQuery, clone $expensesQuery);
        $query = new Query();
        $query->from(['t' =>
            $paymentsQuery
                ->andFilterWhere(['>=', 'p.date_time', $this->date_from ? "$this->date_from 00:00:00" : null])
                ->andFilterWhere(['<=', 'p.date_time', $this->date_to ? "$this->date_to 23:59:59" : null])
                ->union(
                    $expensesQuery
                        ->andFilterWhere(['>=', 'e.date_time', $this->date_from ? "$this->date_from 00:00:00" : null])
                        ->andFilterWhere(['<=', 'e.date_time', $this->date_to ? "$this->date_to 23:59:59" : null])
                ), 'b' => "(SELECT @prev_total_balance := :prevTotalBalance)"])
            ->select(new Expression('t.date_time,DATE_FORMAT(t.date_time,"%d.%m.%Y") AS date_on,t.type,t.balance,t.expense,t.name,
            @prev_total_balance AS prevTotal, 
            (@prev_total_balance := @prev_total_balance+COALESCE(balance,0)-COALESCE(expense,0)) AS newTotal'))
            ->params([':prevTotalBalance' => $balance])
            ->orderBy(new Expression("date_time"));
        return new ArrayDataProvider(
            [
                'allModels' => $query->all(),
                'sort' => false,
                'pagination' => ['pageSize' => 0],
            ]
        );

    }

    public function loadDefaultSearchParams(&$params)
    {
        if (empty($params)) {
            $this->date_from = date('Y-m-01');
            $this->date_to = date('Y-m-d');
        }
    }

    public function getBalance($paymentsQuery, $expensesQuery)
    {
        $cashBalanceQuery = new Query();
        $currentBalance['balance'] = null;
        if ($this->date_from)
            $currentBalance = $cashBalanceQuery->from(['b' =>
                $paymentsQuery
                    ->andWhere(['<', 'p.date_time', $this->date_from ? "$this->date_from 00:00:00" : null])
                    ->union(
                        $expensesQuery
                            ->andWhere(['<', 'e.date_time', $this->date_from ? "$this->date_from 00:00:00" : null])
                    )])->select(new Expression("SUM(COALESCE(balance,0))-SUM(COALESCE(expense,0)) AS balance"))
                ->one();

        return !isset($currentBalance['balance']) ? 0 : $currentBalance['balance'];
    }
}
