<?php

/**
 * @var $this yii\web\View
 * @var $model common\models\Sale
 * @var $modelsProductLink common\models\SaleProductLink[]
 * @var $payment common\models\Payment
 */

$this->title = Yii::t('app', 'Қўшиш');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Сотувлар'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sale-create card">
    <div class="card-head card-head-sm style-primary">
        <header><?= $this->title ?></header>
    </div>
    <div class="card-body">
        <?= $this->render('_form_new', [
            'model' => $model,
            'modelsProductLink' => $modelsProductLink,
            'payment' => $payment,
        ]) ?>
    </div>
</div>
