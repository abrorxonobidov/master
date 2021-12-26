<?php

use yii\bootstrap\Html;
use frontend\widgets\GridView;

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
            'columns' => [
                [
                    'header' => Yii::t('app', 'Мижоз'),
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
                    'value' => function (common\models\Client $model) {
                        return $model->image ?
                            Html::a(Html::img($model::imageSourcePath() . $model->image, ['class' => 'img-responsive img-thumbnail']),
                                ['/uploads/' . $model->image], ['class' => 'pjaxModalButton', 'data-title' => $model->name]
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
                        'update' => function ($url, $model) {
                            return Html::a(Html::icon('pencil'),
                                $url . '&route=/client/index',
                                ['class' => 'pjaxModalButton', 'data-title' => Yii::t('app', 'Таҳрирлаш') . ': ' . $model->name]
                            );
                        },
                        'view' => function ($url, $model) {
                            return Html::a(Html::icon('eye-open'),
                                $url,
                                ['class' => 'pjaxModalButton', 'data-title' => $model->name]
                            );
                        }
                    ]
                ]
            ],
        ]); ?>
    </div>
</div>
