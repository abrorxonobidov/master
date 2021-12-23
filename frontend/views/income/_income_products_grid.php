<?php

use yii\helpers\Html;

/**
 * @var $dataProvider
 * @var $model common\models\Income
 */
echo frontend\widgets\GridView::widget([
    'dataProvider' => $dataProvider,
    'striped' => false,
    'filterModel' => false,
    'showPageSummary' => true,
    'summary' => false,
    'columns' => [
        'product.title',
        [
            'attribute' => 'amount',
            'format' => 'decimal',
            'headerOptions' => ['class' => 'col-md-2'],
            'contentOptions' => ['class' => 'text-right text-bold'],
            'enableSorting' => false
        ],
        [
            'value' => 'product.unit.title'
        ],
        [
            'attribute' => 'price',
            'format' => 'decimal',
            'headerOptions' => ['class' => 'col-md-2'],
            'contentOptions' => ['class' => 'text-right text-bold'],
            'enableSorting' => false
        ],
        'currency',
        [
            'class' => 'kartik\grid\DataColumn',
            'attribute' => 'total_price',
            'format' => 'decimal',
            'headerOptions' => ['class' => 'col-md-2'],
            'contentOptions' => ['class' => 'text-right text-bold'],
            'pageSummary' => function ($summary) {
                return Yii::t('app', 'Жами') . ': ' .
                    Yii::$app->formatter->asDecimal($summary);
            },
            'pageSummaryOptions' => [
                'class' => 'text-right',
            ]
        ],
        [
            'class' => 'kartik\grid\DataColumn',
            'attribute' => 'currency',
            'pageSummary' => Yii::t('app', 'сўм'),
        ]
    ]
]);

/*echo Html::tag('h4', Html::tag('small', Yii::t('app', 'Жами') . ': ') .
    Yii::$app->formatter->asDecimal($model->totalSum) . ' ' . $model->currency,
    ['class' => 'h4 text-right']
);*/

echo Html::tag('p', $model->comment, ['class' => 'collapse-comment']);