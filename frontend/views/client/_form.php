<?php

use kartik\file\FileInput;
use kartik\icons\Icon;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model common\models\Client */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="client-form ">
    <?php $form = ActiveForm::begin(['options' => ['class' => 'form'], 'fieldConfig' => ['template' => "{input}\n{label}\n{hint}\n{error}"]]); ?>
    <div class="main-form-fields">

        <div class="row">
            <div class="col-md-6">

                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'phone')
                    ->widget(MaskedInput::class, [
                        'mask' => '+\9\98 99 999 99 99',
                    ])
                ?>

                <?= $form->field($model, 'car_number')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'car_model')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

            </div>
            <div class="col-md-6">


                <?php $previewConfig = $model->inputImageConfig('image', 'site/file-remove'); ?>
                <?= $form->field($model, 'image_file')
                    ->widget(FileInput::class, [
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
                            'browseLabel' => Icon::show('folder-open', ['class' => 'fa']) . ' ' . $model->selectText(),
                            'browseIcon' => '',
                            'fileActionSettings' => [
                                'removeIcon' => Icon::show('trash', ['class' => 'fa']),
                                'showZoom' => false,
                            ]
                        ]
                    ]) ?>
            </div>
        </div>
    </div>

    <?= $form->field($model, 'comment')->textarea(['rows' => 3, 'maxlength' => true]) ?>

    <div class="form-buttons">
        <?= Html::submitButton(Yii::t('app', 'Сақлаш'), ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
