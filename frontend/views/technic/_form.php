<?php

use kartik\file\FileInput;
use kartik\icons\Icon;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Technic */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="technic-form ">
    <?php $form = ActiveForm::begin(['options' => ['class' => 'form'], 'fieldConfig' => ['template' => "{input}\n{label}\n{hint}\n{error}", 'options' => ['class' => 'form-group col-md-4']],]); ?>
    <div class="main-form-fields">

        <?= $form->field($model, 'type_id')->widget(\kartik\select2\Select2::className(), ['data' => $model::getTypeList()]) ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'model')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'number')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'driver_name')->textInput(['maxlength' => true]) ?>

        <?php $previewConfig = $model->inputImageConfig('image', 'site/file-remove'); ?>
        <?= $form->field($model, 'image_file', ['options' => ['class' => 'form-group col-md-12']])->widget(FileInput::class, [
            'options' => ['accept' => 'image/*'],
            'pluginOptions' => [
                'previewFileType' => 'image',
                'allowedFileExtensions' => ['jpg', 'gif', 'png', 'jpeg'],
                'initialPreview' => $previewConfig['path'],
                'initialPreviewAsData' => true,
                'initialPreviewConfig' => $previewConfig['config'],
                'showUpload' => false,
                'showRemove' => false,
                'browseClass' => 'btn btn-success',
                'browseLabel' => Icon::show('folder-open', ['class'=>'fa']) . ' ' . $model->selectText(),
                'browseIcon' => '',
                'fileActionSettings' => [
                    'removeIcon' => Icon::show('trash', ['class'=>'fa']),
                    'showZoom' => false,
                ]
            ]
        ]) ?>
        <div class="clearfix"></div>
        <?= $form->field($model, 'comment', ['options' => ['class' => 'form-group col-md-12']])->textInput(['maxlength' => true]) ?>

    </div>
    <div class="form-buttons">
        <?= Html::submitButton(Yii::t('app', 'Сақлаш'), ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
