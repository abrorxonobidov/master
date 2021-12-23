<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\SaleProductLink */

$this->title = Yii::t('app', 'Қўшиш');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sale Product Links'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sale-product-link-create card">
    <div class="card-head card-head-sm style-primary">
        <header><?= $this->title ?></header>
    </div>
    <div class="card-body">
        <?= $this->render('_form', [
        'model' => $model,
        ]) ?>
    </div>
</div>
