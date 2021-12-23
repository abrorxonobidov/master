<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\PayType */

$this->title = Yii::t('app', 'Қўшиш');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Тўлов турлари'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pay-type-create card">
    <div class="card-head card-head-sm style-primary">
        <header><?= $this->title ?></header>
    </div>
    <div class="card-body">
        <?= $this->render('_form', [
        'model' => $model,
        ]) ?>
    </div>
</div>
