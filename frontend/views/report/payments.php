<?php

use common\models\PayType;
use yii\helpers\Html;
use kartik\grid\GridView;

/**
 * @var $this yii\web\View
 * @var $searchModel common\models\search\PaymentSearch
 * @var $dataProvider yii\data\ActiveDataProvider
 */

$this->title = Yii::t('app', 'Тўловлар бўйича ҳисобот');
$this->params['breadcrumbs'][] = $this->title;

echo frontend\widgets\Collapse::widget([
    'content' => $this->render('_payment_search', ['model' => $searchModel]),
    'header' => Yii::t('app', 'Қидирув')
]);

echo Html::beginTag('div', ['class' => 'card-body table-responsive no-padding']);

echo frontend\widgets\StatGridView::widget([
    'panelHeading' => ($dataProvider->totalCount > 0) ? Yii::t('app', 'Сўнгги тўлов қилинган вақт: ') . $dataProvider->models[0]->date_time : '',
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'class' => 'kartik\grid\DataColumn',
            'attribute' => 'date_time',
            'format' => ['date', 'php:d.m.Y'],
            'group' => true,
            'groupEvenCssClass' => 'kv-group-odd',
            'groupOddCssClass' => 'kv-group-odd',
            'headerOptions' => [
                'class' => 'col-md-1'
            ],
            'pageSummary' => function () use ($searchModel) {
                $text = "";
                if ($searchModel->date_from)
                    $text .= date('d.m.Y', strtotime($searchModel->date_from)) . ' ' . Yii::t('app', 'дан');
                if ($searchModel->date_to) {
                    if (!empty($text))
                        $text .= " ";
                    $text .= date('d.m.Y', strtotime($searchModel->date_to)) . ' ' . Yii::t('app', 'гача');
                }
                return $text;
            },
        ],
        [
            'label' => 'Соат',
            'value' => function (common\models\Payment $data) {
                return date('H:i', strtotime($data->date_time));
            },
            'headerOptions' => [
                'class' => 'col-md-1'
            ],
        ],
        [
            'class' => 'kartik\grid\DataColumn',
            'attribute' => 'client_id',
            'value' => 'client.name',
            'headerOptions' => ['class' => 'col-sm-3'],
            'contentOptions' => ['class' => 'text-bold'],
            'pageSummary' => Yii::t('app', 'Жами'),
        ],
        'type',
        [
            'class' => 'kartik\grid\DataColumn',
            'attribute' => 'pay_type_id',
            'filter' => PayType::getList(),
            'value' => 'payType.title',
            'headerOptions' => ['class' => 'col-sm-2'],
            'pageSummary' => @$searchModel->payType->title,
        ],
        [
            'class' => 'kartik\grid\DataColumn',
            'attribute' => 'price',
            'headerOptions' => ['class' => 'col-sm-2'],
            'format' => 'decimal',
            'pageSummary' => true,
            'contentOptions' => [
                'class' => 'text-right text-bold'
            ],
            'pageSummaryOptions' => [
                'class' => 'text-right'
            ]
        ],
        [
            'class' => 'kartik\grid\DataColumn',
            'attribute' => 'currency',
            'headerOptions' => ['class' => 'currency-column'],
            'contentOptions' => ['class' => 'text-right'],
            'pageSummary' => 'сўм',
        ],
        'comment'
    ]
]);

echo Html::endTag('div');