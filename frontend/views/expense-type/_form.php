<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ExpenseType */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="expense-type-form ">
    <?php $form = ActiveForm::begin(['options' => ['class' => 'form'],'fieldConfig' => ['template' => "{input}\n{label}\n{hint}\n{error}", 'options' => ['class' => 'form-group col-md-12']],]); ?>
    <div class="main-form-fields">

        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'order')->hiddenInput(['value' => 500])->label(false) ?>

        <?= $form->field($model, 'comment')->textInput(['maxlength' => true]) ?>

    </div>
    <div class="form-buttons">
        <?= Html::submitButton(Yii::t('app', 'Сақлаш'), ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
