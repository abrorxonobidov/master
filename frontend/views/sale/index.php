<?php

use yii\bootstrap\Html;
use frontend\widgets\GridView;

/**
 * @var $this yii\web\View
 * @var $searchModel common\models\search\SaleSearch
 * @var $dataProvider yii\data\ActiveDataProvider
 */

$this->title = Yii::t('app', 'Сотувлар');
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
                    'attribute' => 'client_id',
                    'value' => 'client.name',
                    'format' => 'raw',
                    'contentOptions' => ['class' => 'text-bold'],
                ],
                [
                    'attribute' => 'sum',
                    'format' => 'decimal',
                    'contentOptions' => ['class' => 'text-right text-bold'],
                ],
                'currency',
                [
                    'header' => 'Тўлов',
                    'format' => 'decimal',
                    'value' => 'payment.price',
                    'contentOptions' => ['class' => 'text-bold text-right'],
                ],
                'currency',
                [
                    'label' => 'Тўлов тури',
                    'value' => 'payment.payType.title',
                    'contentOptions' => ['class' => 'text-center'],
                ],
                /*[
                    'attribute' => 'comment',
                    'headerOptions' => ['class' => 'col-sm-2'],
                ],*/
                [
                    'attribute' => 'status',
                    'headerOptions' => ['class' => 'col-sm-1'],
                    'contentOptions' => ['class' => 'text-center'],
                    'filter' => $searchModel::statusList(),
                    'format' => 'raw',
                    'value' => 'statusTitle'
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {update}',
                    'buttons' => [
                        'view' => function ($url) {
                            return Html::a(Html::icon('eye-open'), $url, ['class' => 'pjaxModalButton']);
                        }
                    ]
                ],
                [
                    'class' => 'kartik\grid\ExpandRowColumn',
                    'value' => function () {
                        return GridView::ROW_COLLAPSED;
                    },
                    'detail' => function ($model) {
                        $searchModel = new common\models\search\SaleProductLinkSearch();
                        $searchModel->sale_id = $model->id;
                        $dataProvider = $searchModel->search([]);
                        $dataProvider->sort->sortParam = false;
                        return Yii::$app->controller->renderPartial('_sale_products_grid', [
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
            ],
        ]); ?>
    </div>
</div>
