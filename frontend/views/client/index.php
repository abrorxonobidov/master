<?php

use yii\helpers\Html;
use frontend\widgets\GridView;
use yii\helpers\Url;

/**
 * @var $this yii\web\View
 * @var $searchModel common\models\search\ClientSearch
 * @var $dataProvider yii\data\ActiveDataProvider
 */

$this->title = Yii::t('app', 'Мижозлар');
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
                    'header' => 'Мижоз',
                    'attribute' => 'name',
                    'format' => 'raw',
                    'value' => 'personInfo'
                ],
                [
                    'attribute' => 'car_number',
                    'format' => 'raw',
                    'value' => 'carInfo'
                ],
                [
                    'attribute' => 'image',
                    'filter' => false,
                    'value' => function (common\models\Client $model) {
                        return $model->image ?
                            Html::a(Html::img($model::imageSourcePath() . $model->image, ['class' => 'img-responsive img-thumbnail']),
                                ['/uploads/' . $model->image], ['class' => 'pjaxModalButton']
                            ) : '';
                    },
                    'format' => 'raw',
                    'headerOptions' => ['class' => 'col-md-2']
                ],
                'comment',
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
