<?php

use kartik\grid\GridView;

/**
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

echo GridView::widget([
    'summary' => Yii::t('app', 'Намойиш этилмоқда <b>{begin, number}-{end, number}</b> та ёзув <b>{totalCount, number}</b> тадан.'),
    'panel' => [
        'type' => GridView::TYPE_PRIMARY,
        'heading' => $this->title
    ],
    'hover' => true,
    'striped' => false,
    'resizableColumns' => true,
    'showPageSummary' => true,
    'pageSummaryRowOptions' => ['class' => 'kv-page-summary success'],
    'toolbar' => [
        '{export}'
    ],
    'panelTemplate' => "{panelHeading} {panelBefore} {items}",
    'filterRowOptions' => [
        'class' => 'hidden'
    ],
    'toggleDataOptions' => [
        'maxCount' => 10000,
        'minCount' => 1000,
        'confirmMsg' => Yii::t('app', 'Ҳаммасини кўришни хохлайсизми?'),
        //Yii::t('kvgrid', 'There are {totalCount} records. Are you sure you want to display them all?',
        //    ['totalCount' => number_format($this->dataProvider->getTotalCount())]),
        'all' => [
            'icon' => 'resize-full',
            'label' => Yii::t('app', 'Барчаси'),
            'class' => 'btn btn-default',
            'title' => Yii::t('app', 'Барчасини кўрсатиш')
        ],
        'page' => [
            'icon' => 'resize-small',
            'label' => Yii::t('app', 'Саҳифа'),
            'class' => 'btn btn-default',
            'title' => Yii::t('app', 'Биринчи саҳифани кўрсатиш')
        ],
    ],
    'export' => [
        'label' => Yii::t('app', 'Юклаб олиш'),
        'header' => false,
        'fontAwesome' => true,
        'target' => kartik\export\ExportMenu::TARGET_BLANK,
        'format' => 'raw',
        'showConfirmAlert' => false,
    ],
    'exportConfig' => [
        'xls' => true,
    ],
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'layout' => "{items}\n{summary}\n{pager}",
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
                return Yii::$app->formatter->asDecimal($summary + $saleInit);
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
                return Yii::$app->formatter->asDecimal($summary + $paymentInit);
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
    'emptyText' => $searchModel->client_id
        ? Yii::t('app', 'Маълумот топилмади')
        : Yii::t('app', 'Мижозни танланг'),
    'emptyTextOptions' => ['class' => 'alert alert-success']
]);