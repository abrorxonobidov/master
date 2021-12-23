<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\IncomeProductLink */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Income Product Link',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Кирим товарлар'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Таҳрирлаш');
?>
<div class="income-product-link-update card">
    <div class="card-head card-head-sm style-primary">
        <header><?= $this->title ?></header>
    </div>
    <div class="card-body">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
