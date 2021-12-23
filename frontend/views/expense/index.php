<?php

use yii\helpers\Html;
use frontend\widgets\GridView;
use yii\helpers\Url;

/**
 * @var $this yii\web\View
 * @var $searchModel common\models\search\ExpenseSearch
 * @var $dataProvider yii\data\ActiveDataProvider
 */

$this->title = Yii::t('app', 'Ҳаражатлар');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="my-card card">
    <div class="card-head style-primary">
        <header><?= Html::a(Yii::t('app', 'Қўшиш'), ['create'], ['class' => 'btn btn-success pjaxModalButton']) ?></header>
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
                    'attribute' => 'expense_type_id',
                    'headerOptions' => ['class' => 'col-md-2'],
                    'contentOptions' => ['class' => 'text-bold'],
                    'value' => 'expenseType.title'
                ],
                [
                    'attribute' => 'price',
                    'format' => 'decimal',
                    'headerOptions' => ['class' => 'col-md-2'],
                    'contentOptions' => ['class' => 'text-right text-bold'],
                ],
                'currency',
                'comment',
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
                    'headerOptions' => ['class' => 'col-sm-1'],
                    'template' => '{view} {update}',
                    'buttons' => [
                        'update' => function ($url, $model, $key) {
                            return Html::a(yii\bootstrap\Html::icon('pencil'), ['update', 'id' => $model->id, 'route' => Url::to()], ['class' => 'pjaxModalButton']);
                        },
                        'view' => function ($url, $model, $key) {
                            return Html::a(\yii\bootstrap\Html::icon('eye-open'), ['view', 'id' => $model->id, 'route' => Url::to()], ['class' => 'pjaxModalButton']);
                        }
                    ]
                ]
            ]
        ]); ?>
    </div>
</div>
