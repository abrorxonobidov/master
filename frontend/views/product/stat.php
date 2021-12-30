<?php

/**
 * @var frontend\models\ProductStatSearch $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var yii\web\View $this
 */

$this->title = Yii::t('app', 'Маҳсулот айланмаси');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ҳисоботлар'), 'url' => '#'];
$this->params['breadcrumbs'][] = $this->title;


echo frontend\widgets\Collapse::widget([
    'header' => 'Параметрлар',
    'content' => $this->render('_product_search', ['model' => $searchModel])
]);

echo frontend\widgets\StatGridView::widget([
    'panelHeading'  => $this->title,
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'rowOptions' => function ($model) {
        return ['class' => $model['income_amount'] ? 'bg-success' : 'bg-info'];
    },
    'emptyText' => $searchModel->product_id
        ? Yii::t('app', 'Маълумот топилмади')
        : Yii::t('app', 'Маҳсулот танланг'),
    'columns' => [
        [
            'class' => 'kartik\grid\DataColumn',
            'attribute' => 'date_time',
            'headerOptions' => ['class' => 'col-sm-2'],
            'format' => 'raw',
            'group' => true,
            'groupEvenCssClass' => 'kv-group-odd',
            'groupOddCssClass' => 'kv-group-odd',
            'value' => function ($model) {
                return date('d.m.Y', strtotime($model['date_time']));
            },
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
            'headerOptions' => ['class' => 'col-sm-1'],
            'format' => 'raw',
            'value' => function ($model) {
                return date('H:i', strtotime($model['date_time']))
                    . yii\helpers\Html::tag('span', $model['type'], ['class' => 'pull-right']);
            }
        ],
        [
            'attribute' => 'product_name',
            'headerOptions' => ['class' => 'col-sm-2'],
            'contentOptions' => ['class' => 'text-bold'],
        ],

        // income
        [
            'class' => 'kartik\grid\DataColumn',
            'attribute' => 'income_amount',
            'headerOptions' => ['class' => 'col-sm-1'],
            'contentOptions' => ['class' => 'text-right'],
            'format' => 'decimal',
            'pageSummary' => boolval($searchModel->product_id),
            'pageSummaryOptions' => ['class' => 'text-right']
        ],
        [
            'class' => 'kartik\grid\DataColumn',
            'attribute' => 'income_unit_title',
            'label' => false,
            'headerOptions' => ['class' => 'currency-column'],
            'pageSummary' => @$searchModel->product->unit->title,
        ],
        [
            'class' => 'kartik\grid\DataColumn',
            'attribute' => 'income_price',
            'headerOptions' => ['class' => 'col-sm-1'],
            'contentOptions' => ['class' => ' text-right'],
            'format' => 'decimal',
        ],
        [
            'class' => 'kartik\grid\DataColumn',
            'value' => function ($model) {
                return $model['income_amount'] ? 'сўм' : null;
            },
            'headerOptions' => ['class' => 'currency-column'],
        ],
        [
            'class' => 'kartik\grid\DataColumn',
            'attribute' => 'income_total',
            'headerOptions' => ['class' => 'col-sm-1'],
            'contentOptions' => ['class' => 'text-bold text-right'],
            'format' => 'decimal',
            'pageSummary' => boolval($searchModel->product_id),
            'pageSummaryOptions' => ['class' => 'text-bold text-right']
        ],
        [
            'class' => 'kartik\grid\DataColumn',
            'value' => function ($model) {
                return $model['income_total'] ? 'сўм' : null;
            },
            'headerOptions' => ['class' => 'currency-column'],
            'contentOptions' => ['class' => 'text-right'],
            'pageSummary' => boolval($searchModel->product_id) ? 'сўм' : '',
        ],

        //sale
        [
            'class' => 'kartik\grid\DataColumn',
            'attribute' => 'sale_amount',
            'headerOptions' => ['class' => 'col-sm-1'],
            'contentOptions' => ['class' => 'text-right'],
            'format' => 'decimal',
            'pageSummary' => boolval($searchModel->product_id),
            'pageSummaryOptions' => ['class' => 'text-right']
        ],
        [
            'class' => 'kartik\grid\DataColumn',
            'attribute' => 'sale_unit_title',
            'label' => false,
            'headerOptions' => ['class' => 'currency-column'],
            'pageSummary' => @$searchModel->product->unit->title,
        ],
        [
            'class' => 'kartik\grid\DataColumn',
            'attribute' => 'sale_price',
            'headerOptions' => ['class' => 'col-sm-1'],
            'contentOptions' => ['class' => 'text-right'],
            'format' => 'decimal',
        ],
        [
            'class' => 'kartik\grid\DataColumn',
            'value' => function ($model) {
                return $model['sale_amount'] ? 'сўм' : null;
            },
            'headerOptions' => ['class' => 'currency-column'],
        ],
        [
            'class' => 'kartik\grid\DataColumn',
            'attribute' => 'sale_total',
            'headerOptions' => ['class' => 'col-sm-1'],
            'contentOptions' => ['class' => 'text-bold text-right'],
            'format' => 'decimal',
            'pageSummary' => boolval($searchModel->product_id),
            'pageSummaryOptions' => ['class' => 'text-bold text-right']
        ],
        [
            'class' => 'kartik\grid\DataColumn',
            'value' => function ($model) {
                return $model['sale_total'] ? 'сўм' : null;
            },
            'headerOptions' => ['class' => 'currency-column'],
            'contentOptions' => ['class' => 'text-right'],
            'pageSummary' => boolval($searchModel->product_id) ? 'сўм' : '',
        ],
        [
            'class' => 'kartik\grid\DataColumn',
            'attribute' => 'comment',
            'headerOptions' => ['class' => 'col-md-3'],
            'pageSummaryOptions' => ['class' => 'text-bold text-right'],
            'pageSummary' => function () use ($dataProvider, $searchModel) {
                if (!$searchModel->product_id) return null;
                $a = (new yii\db\Query())
                    ->select('SUM(income_amount) - SUM(sale_amount)')
                    ->from(['q' => $dataProvider->query])
                    ->column();
                $balance = Yii::$app->formatter->asDecimal(@$a[0]);
                $unit = @$searchModel->product->unit->title;
                return "Қолдиқ: $balance $unit";
            },
        ]
    ],
]);
