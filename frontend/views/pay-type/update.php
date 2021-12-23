<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\PayType */

$this->title = $model->title. ' '.Yii::t('app', 'ни таҳрирлаш');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Тўлов турлари'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Таҳрирлаш');
?>
<div class="pay-type-update card">
    <div class="card-head card-head-sm style-primary">
        <header><?= $this->title ?></header>
    </div>
    <div class="card-body">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
