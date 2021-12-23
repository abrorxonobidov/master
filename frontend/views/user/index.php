<?php

use yii\helpers\Html;
use frontend\widgets\GridView;

/**
 * @var $this yii\web\View
 * @var $searchModel common\models\search\UserSearch
 * @var $dataProvider yii\data\ActiveDataProvider
 */

$this->title = Yii::t('app', 'Фойдаланувчилар');
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
                    'attribute' => 'username',
                    'format' => 'raw',
                    'value' => function ($data) {
                        return Html::a($data->username, ['view', 'id' => $data->id], ['class' => 'pjaxModalButton']);
                    }
                ],
                'full_name',
                'email:text',
                [
                    'attribute' => 'status',
                    'value' => 'statusName'
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {update}',
                    'visibleButtons' => [
                        'update' => function ($model) {
                            return $model->id === Yii::$app->user->id;
                        }
                    ]
                ]
            ]
        ]); ?>
    </div>
</div>
