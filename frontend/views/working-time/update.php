<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\WorkingTime */

$this->title = Yii::t('app', '{begin_time} => {end_time} ', [
    'begin_time' => $model->begin_time ? date('d.m.Y H:i:s', strtotime($model->begin_time)) : '-',
    'end_time' => $model->end_time ? date('d.m.Y H:i:s', strtotime($model->end_time)) : '-',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Иш вақтлари'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Таҳрирлаш');
?>
<div class="working-time-update card">
    <div class="card-head card-head-sm style-primary">
        <header><?= $this->title ?></header>
    </div>
    <div class="card-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
