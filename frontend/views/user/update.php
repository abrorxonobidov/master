<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->username. ' '.Yii::t('app', 'ни таҳрирлаш');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Фойдаланувчилар'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Таҳрирлаш');
?>
<div class="user-update card">
    <div class="card-head card-head-sm style-primary">
        <header><?= $this->title ?></header>
    </div>
    <div class="card-body">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
