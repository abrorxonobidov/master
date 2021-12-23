<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\WorkingTime */

$this->title =
    Yii::t('app', '{begin_time} => {end_time} ', [
        'begin_time' => $model->begin_time ? date('d.m.Y H:i:s', strtotime($model->begin_time)) : '-',
        'end_time' => $model->end_time ? date('d.m.Y H:i:s', strtotime($model->end_time)) : '-',
    ]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Иш вақтлари'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="working-time-view">
    <div class="card">
        <?php if(!Yii::$app->request->isAjax):?>
            <div class="card-body">
                <?= Html::a(Yii::t('app', 'Таҳрирлаш'), ['update', 'id' => $model->id,'route' => \yii\helpers\Url::to()], ['class' =>'btn btn-primary pjaxModalButton']) ?>
            </div>
        <?php endif;?>
        <div class="card-body table-responsive no-padding">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'begin_time',
                    'end_time',
                    'begin_comment:ntext',
                    'end_comment:ntext',
                    'status',
                ],
            ]) ?>
        </div>
    </div>
</div>
