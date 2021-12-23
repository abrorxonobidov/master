<?php

use common\models\Unit;
use kartik\file\FileInput;
use kartik\icons\Icon;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

/**
 * @var $this yii\web\View
 * @var $model common\models\Product
 * @var $form yii\widgets\ActiveForm
 */
?>

<div class="product-form ">
    <?php $form = ActiveForm::begin(['options' => ['class' => 'form'],
        'fieldConfig' => [
            'template' => "{input}\n{label}\n{hint}\n{error}",
            //'options' => ['class' => 'form-group col-md-3']
        ]
    ]); ?>
    <div class="main-form-fields">
        <div class="row">

            <div class="col-md-6">


                <?= $form->field($model, 'unit_id')->widget(Select2::className(), ['data' => Unit::getList(), 'options' => ['prompt' => ' ']]) ?>

                <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'income_price', ['enableClientValidation' => false])
                    ->widget(MaskedInput::class, [
                        'clientOptions' => [
                            'alias' => 'decimal',
                            'digits' => 0,
                            'digitsOptional' => false,
                            'groupSeparator' => 'ʼ',
                            'autoGroup' => true,
                            'removeMaskOnSubmit' => true,
                            'suffix' => ' ' . Yii::t('app', 'сўм')
                        ]
                    ])
                ?>

                <?= $form->field($model, 'price', ['enableClientValidation' => false])
                    ->widget(MaskedInput::class, [
                        'clientOptions' => [
                            'alias' => 'decimal',
                            'digits' => 0,
                            'digitsOptional' => false,
                            'groupSeparator' => 'ʼ',
                            'autoGroup' => true,
                            'removeMaskOnSubmit' => true,
                            'suffix' => ' ' . Yii::t('app', 'сўм')
                        ]
                    ])
                ?>

            </div>
            <div class="col-md-6">

                <? $previewConfig = $model->inputImageConfig('image', 'site/file-remove'); ?>

                <?= $form->field($model, 'image_file', ['options' => ['class' => 'form-group col-md-12']])
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
        <?= $form->field($model, 'comment')->textarea(['rows' => 6, 'maxlength' => true]) ?>
    </div>
    <div class="form-buttons">
        <?= Html::submitButton(Yii::t('app', 'Сақлаш'), ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
