<?php

use yii\helpers\Html;
use frontend\widgets\GridView;
use yii\helpers\Url;

/**
 * @var $this yii\web\View
 * @var $searchModel common\models\search\WorkingTimeSearch
 * @var $dataProvider yii\data\ActiveDataProvider
 */

$this->title = Yii::t('app', 'Иш вақтлари');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="my-card card">
    <div class="card-head style-primary">
        <header><?= Html::a(Yii::t('app', 'Қўшиш'), ['create'], ['class' => 'btn btn-success pjaxModalButton']) ?></header>
    </div>
    <div class="card-body table-responsive no-padding">

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [

                [
                    'attribute' => 'begin_time',
                    'format' => ['date', 'php:d.m.Y H:i']
                ],
                [
                    'attribute' => 'end_time',
                    'format' => ['date', 'php:d.m.Y H:i']
                ],
                'begin_comment:raw',
                'end_comment:raw',
                [
                    'attribute' => 'status',
                    'headerOptions' => ['class' => 'col-sm-1'],
                    'contentOptions' => ['class' => 'text-center'],
                    'filter' => $searchModel::statusList(),
                    'format' => 'raw',
                    'value' => function (common\models\WorkingTime $data) {
                        return Html::tag('span', $data->getStatusNameIcon(), ['class' => 'text-' . $data->statusColor]);
                    }
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
            ],
        ]); ?>
    </div>
</div>
