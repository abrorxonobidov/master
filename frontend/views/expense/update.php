<?php

/**
 * @var $this yii\web\View
 * @var $model common\models\Expense
 */

$this->title = $model->expenseType->title . ' ' . $model->price . ' ' . Yii::t('app', 'ни таҳрирлаш');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ҳаражатлар'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Таҳрирлаш');
?>
<div class="expense-update card">
    <div class="card-head card-head-sm style-primary">
        <header><?= $this->title ?></header>
    </div>
    <div class="card-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>
