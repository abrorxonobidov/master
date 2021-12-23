<?php

/* @var $this yii\web\View */
/* @var $model common\models\Client */

$this->title = $model->name . ' ' . Yii::t('app', 'ни таҳрирлаш');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Мижозлар'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Таҳрирлаш');
?>
<div class="client-update card">
    <div class="card-head card-head-sm style-primary">
        <header><?= $this->title ?></header>
    </div>
    <div class="card-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>
