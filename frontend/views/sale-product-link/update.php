<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SaleProductLink */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Sale Product Link',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sale Product Links'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Таҳрирлаш');
?>
<div class="sale-product-link-update card">
    <div class="card-head card-head-sm style-primary">
        <header><?= $this->title ?></header>
    </div>
    <div class="card-body">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
