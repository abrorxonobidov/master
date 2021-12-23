<?php

use yii\helpers\Html;
use frontend\widgets\GridView;
use yii\helpers\Url;

/**
 * @var $this yii\web\View
 * @var $searchModel common\models\search\TechnicSearch
 * @var $dataProvider yii\data\ActiveDataProvider
 */

$this->title = Yii::t('app', 'Техникалар');
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
                    'attribute' => 'name',
                    'format' => 'raw',
                    'value' => function ($data) {
                        return Html::a($data->title, ['update', 'id' => $data->id, 'route' => Url::to()], ['class' => 'pjaxModalButton']);
                    },
                    'headerOptions' => [
                        'class' => 'col-md-2'
                    ],
                ],
                [
                    'attribute' => 'driver_name',
                    'value' => 'driverInfo',
                    'format' => 'raw',
                    'headerOptions' => [
                        'class' => 'col-md-2'
                    ],
                ],
                [
                    'attribute' => 'type_id',
                    'value' => 'typeName',
                    'headerOptions' => [
                        'class' => 'col-md-1'
                    ],
                ],
                [
                    'attribute' => 'image',
                    'filter' => false,
                    'value' => function (common\models\Technic $model) {
                        return $model->image ? Html::img($model::imageSourcePath() . $model->image, ['class' => 'img-responsive img-thumbnail']) : '';
                    },
                    'format' => 'raw',
                    'headerOptions' => [
                        'class' => 'col-md-2'
                    ]
                ],
                'comment',
                [
                    'attribute' => 'statusTitle',
                    'format' => 'raw',
                    'contentOptions' => [
                        'class' => 'text-center'
                    ],
                    'headerOptions' => [
                        'class' => 'col-md-1'
                    ]
                ]
            ]
        ]); ?>
    </div>
</div>
