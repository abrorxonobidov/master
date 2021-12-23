<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\IncomeProductLink */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="income-product-link-form ">
    <?php $form = ActiveForm::begin(['options' => ['class' => 'form'],'fieldConfig' => ['template' => "{input}\n{label}\n{hint}\n{error}", 'options' => ['class' => 'form-group col-md-12']],]); ?>
    <div class="main-form-fields">

        <?= $form->field($model, 'income_id')->textInput() ?>

        <?= $form->field($model, 'product_id')->textInput() ?>

        <?= $form->field($model, 'amount')->textInput() ?>

        <?= $form->field($model, 'price')->textInput() ?>

        <?= $form->field($model, 'status')->textInput() ?>


    </div>
    <div class="form-buttons">
        <?= Html::submitButton(Yii::t('app', 'Сақлаш'), ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
