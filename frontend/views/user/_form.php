<?php

use kartik\password\PasswordInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $this yii\web\View
 * @var $model common\models\User
 * @var $form yii\widgets\ActiveForm
 */
?>

<? $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

<?= $model->isNewRecord || $model->id == Yii::$app->user->id ? $form->field($model, 'password')->widget(PasswordInput::class) : '' ?>

<?= $form->field($model, 'full_name')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'status')->widget(kartik\select2\Select2::class, ['data' => $model::statusList()]) ?>

<?= Html::submitButton(Yii::t('app', 'Сақлаш'), ['class' => 'btn btn-success']) ?>

<? ActiveForm::end(); ?>