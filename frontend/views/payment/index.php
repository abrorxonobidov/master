<?php

use common\models\PayType;
use yii\helpers\Html;
use frontend\widgets\GridView;
use yii\helpers\Url;

/**
 * @var $this yii\web\View
 * @var $searchModel common\models\search\PaymentSearch
 * @var $dataProvider yii\data\ActiveDataProvider
 */

$this->title = Yii::t('app', 'Тўловлар');
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
                    'headerOptions' => ['class' => 'col-sm-1'],
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
                    'headerOptions' => ['class' => 'col-sm-2'],
                    'contentOptions' => ['class' => 'text-bold'],
                ],
                [
                    'attribute' => 'price',
                    'headerOptions' => ['class' => 'col-sm-1'],
                    'contentOptions' => ['class' => 'text-bold text-right'],
                    'format' => 'decimal',
                ],
                'currency',
                [
                    'attribute' => 'pay_type_id',
                    'filter' => PayType::getList(),
                    'value' => 'payType.title',
                    'contentOptions' => ['class' => 'text-center'],
                    'headerOptions' => ['class' => 'col-sm-1']
                ],
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
                            return Html::a(yii\bootstrap\Html::icon('eye-open'), ['view', 'id' => $model->id, 'route' => Url::to()], ['class' => 'pjaxModalButton']);
                        }
                    ]
                ]
            ]
        ]); ?>
    </div>
</div>
