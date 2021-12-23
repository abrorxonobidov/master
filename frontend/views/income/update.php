<?php

/**
 * @var $this yii\web\View
 * @var $model common\models\Income
 * @var $modelsProductLink common\models\IncomeProductLink
 */

$this->title = Yii::t('app', 'Таҳрирлаш') . ' | ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Маҳсулотлар кирими'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Таҳрирлаш');
?>
<div class="income-update card">
    <div class="card-head card-head-sm style-primary">
        <header><?= $this->title ?></header>
    </div>
    <div class="card-body">
        <?= $this->render('_form_new', [
            'model' => $model,
            'modelsProductLink' => $modelsProductLink
        ]) ?>
    </div>
</div>
