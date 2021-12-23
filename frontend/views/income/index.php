<?php

use common\models\search\IncomeProductLinkSearch;
use yii\helpers\Html;
use frontend\widgets\GridView;
use yii\helpers\Url;

/**
 * @var $this yii\web\View
 * @var $searchModel common\models\search\IncomeSearch
 * @var $dataProvider yii\data\ActiveDataProvider
 */

$this->title = Yii::t('app', 'Маҳсулотлар кирими');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="my-card card">
    <div class="card-head style-primary">
        <header><?= Html::a(Yii::t('app', 'Қўшиш'), ['create'], ['class' => 'btn btn-success']) ?></header>
    </div>
    <div class="card-body table-responsive no-padding">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => null,
            'columns' => [
                [
                    'class' => 'kartik\grid\DataColumn',
                    'attribute' => 'date_time',
                    'format' => 'date',
                    'group' => true,
                    'groupEvenCssClass' => 'kv-group-odd',
                    'groupOddCssClass' => 'kv-group-odd',
                ],
                [
                    'value' => 'date_time',
                    'format' => ['date', 'php:H:i']
                ],
                [
                    'attribute' => 'sum',
                    'format' => 'decimal',
                    'headerOptions' => ['class' => 'col-md-2'],
                    'contentOptions' => ['class' => 'text-right text-bold'],
                ],
                'currency',
                [
                    'attribute' => 'excavator_id',
                    'format' => 'raw',
                    'value' => 'excavator.name',
                    /*'value' => function (common\models\Income $data) {
                        return Html::a($data->excavator->name . ' (' . $data->excavator->number . ')', ['/technic/view', 'id' => $data->excavator_id], ['class' => 'pjaxModalButton']);
                    },*/
                    'headerOptions' => ['class' => 'col-md-2']
                ],
                [
                    'attribute' => 'truck_id',
                    'format' => 'raw',
                    'value' => 'truck.name',
                    /*'value' => function (common\models\Income $data) {
                        return Html::a($data->truck->name . ' (' . $data->truck->number . ')', ['/technic/view', 'id' => $data->truck_id], ['class' => 'pjaxModalButton']);
                    },*/
                    'headerOptions' => ['class' => 'col-md-2']
                ],
                //'comment',
                [
                    'attribute' => 'status',
                    'headerOptions' => ['class' => 'col-sm-1'],
                    'contentOptions' => ['class' => 'text-center'],
                    'filter' => $searchModel::statusList(),
                    'format' => 'raw',
                    'value' => function ($data) {
                        return Html::tag('span', $data->getStatusNameIcon(), ['class' => 'text-' . $data->statusColor]);
                    }
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {update}',
                    'headerOptions' => ['class' => 'col-md-1'],
                    'buttons' => [
                        'view' => function ($url, $model, $key) {
                            return Html::a(\yii\bootstrap\Html::icon('eye-open'), ['view', 'id' => $model->id, 'route' => Url::to()], ['class' => 'pjaxModalButton']);
                        }
                    ]
                ],
                [
                    'class' => 'kartik\grid\ExpandRowColumn',
                    'value' => function ($model, $key, $index, $column) {
                        return GridView::ROW_COLLAPSED;
                    },
                    'detail' => function ($model) {
                        $searchModel = new IncomeProductLinkSearch();
                        $searchModel->income_id = $model->id;
                        $dataProvider = $searchModel->search([]);
                        return Yii::$app->controller->renderPartial('_income_products_grid', [
                            'model' => $model,
                            'dataProvider' => $dataProvider,
                        ]);
                    },
                    'detailOptions' => [
                        'style' => 'padding-left:100px;'
                    ],
                    'expandOneOnly' => true,
                    'enableRowClick' => false
                ]
            ]
        ]); ?>
    </div>
</div>
