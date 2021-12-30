<?php

/**
 * @var yii\web\View $this
 * @var frontend\models\ClientStatSearch $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 */

$this->title = Yii::t('app', 'Мижоз бўйича');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ҳисоботлар'), 'url' => '#'];
$this->params['breadcrumbs'][] = $this->title;

$saleInit = $searchModel->getSaleInitialRemainder();
$paymentInit = $searchModel->getPaymentInitialRemainder();

echo frontend\widgets\Collapse::widget([
    'header' => 'Параметрлар',
    'content' => $this->render('_client_search', ['model' => $searchModel])
]);

echo frontend\widgets\StatGridView::widget([
    'panelHeading' => $this->title,
    'filterModel' => $searchModel,
    'dataProvider' => $dataProvider,
    'afterHeader' => [
        [
            'columns' => [
                [
                    'content' => 'Дастлабки қолдиқ',
                    'options' => ['class' => ['text-right text-bold'], 'colspan' => 4]
                ],
                [
                    'content' => Yii::$app->formatter->asDecimal($saleInit),
                    'options' => ['class' => ['text-bold text-right']]
                ],
                ['content' => 'сўм'],
                [
                    'content' => Yii::$app->formatter->asDecimal($paymentInit),
                    'options' => ['class' => ['text-bold text-right']]
                ],
                ['content' => 'сўм'],
                ['content' => null]
            ],
            'options' => ['class' => 'bg-success']
        ]
    ],
    'emptyText' => $searchModel->client_id
        ? Yii::t('app', 'Маълумот топилмади')
        : Yii::t('app', 'Мижозни танланг'),
    'columns' => [
        [
            'class' => 'kartik\grid\DataColumn',
            'attribute' => 'date_time',
            'group' => true,
            'groupEvenCssClass' => 'kv-group-odd',
            'groupOddCssClass' => 'kv-group-odd',
            'format' => 'raw',
            'value' => function ($data) {
                return date('d.m.Y', strtotime($data['date_time']));
            },
            'headerOptions' => [
                'class' => 'col-md-1'
            ],
            'pageSummary' => function () use ($searchModel) {
                $text = "";
                if ($searchModel->date_from)
                    $text .= date('d.m.Y', strtotime($searchModel->date_from)) . ' ' . Yii::t('app', 'дан');
                if ($searchModel->date_to)
                    $text .= date(' d.m.Y', strtotime($searchModel->date_to)) . ' ' . Yii::t('app', 'гача');
                return $text;
            },
        ],
        [
            'class' => 'kartik\grid\DataColumn',
            'label' => 'Соат',
            'value' => function ($data) {
                return date('H:i', strtotime($data['date_time']));
            },
            'headerOptions' => [
                'class' => 'col-md-1'
            ]
        ],
        'type',
        [
            'class' => 'kartik\grid\DataColumn',
            'attribute' => 'pay_type_id',
            'filter' => common\models\PayType::getList(),
            'value' => 'pay_type_title',
            'headerOptions' => ['class' => 'col-sm-2'],
            'pageSummary' => Yii::t('app', 'Жами'),
        ],
        [
            'class' => 'kartik\grid\DataColumn',
            'attribute' => 'price_sale',
            'headerOptions' => ['class' => 'col-sm-1'],
            'contentOptions' => ['class' => 'text-bold text-right'],
            'format' => 'decimal',
            'pageSummary' => function ($summary) use ($saleInit) {
                return Yii::$app->formatter->asDecimal(intval($summary) + intval($saleInit));
            },
            'pageSummaryOptions' => ['class' => 'text-bold text-right']
        ],
        [
            'class' => 'kartik\grid\DataColumn',
            'value' => function () {
                return 'сўм';
            },
            'headerOptions' => ['class' => 'currency-column'],
            'contentOptions' => ['class' => 'text-right'],
            'pageSummary' => 'сўм',
        ],
        [
            'class' => 'kartik\grid\DataColumn',
            'attribute' => 'price_payment',
            'headerOptions' => ['class' => 'col-sm-1'],
            'contentOptions' => ['class' => 'text-bold text-right'],
            'format' => 'decimal',
            'pageSummary' => function ($summary) use ($paymentInit) {
                return Yii::$app->formatter->asDecimal(intval($summary) + intval($paymentInit));
            },
            'pageSummaryOptions' => ['class' => 'text-bold text-right']
        ],
        [
            'class' => 'kartik\grid\DataColumn',
            'value' => function () {
                return 'сўм';
            },
            'headerOptions' => ['class' => 'currency-column'],
            'contentOptions' => ['class' => 'text-right'],
            'pageSummary' => 'сўм',
        ],
        [
            'class' => 'kartik\grid\DataColumn',
            'attribute' => 'comment',
            'value' => function ($model) {
                $a = trim($model['comment']);
                $s = null;
                $word = 0;
                for ($i = 0; $i < strlen($a); $i++)
                    $s .= ($a[$i] == ' ' && ++$word % 5 == 0) ? '<br>' : $a[$i];
                return $s;
            },
            'format' => 'html',
            'pageSummary' => function () use ($dataProvider, $paymentInit, $saleInit) {
                $a = (new yii\db\Query())
                    ->select('SUM(price_payment) - SUM(price_sale)')
                    ->from(['q' => $dataProvider->query])
                    ->column();
                $balance = Yii::$app->formatter->asDecimal(@$a[0] + $paymentInit - $saleInit);
                return "$balance сўм";
            },
            'headerOptions' => ['class' => 'col-md-2'],
            'contentOptions' => ['class' => 'col-md-2'],
            'pageSummaryOptions' => ['class' => 'text-bold text-right']
        ],
    ],
]);