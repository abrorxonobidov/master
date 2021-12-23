<?php

use common\models\Product;
use common\models\Technic;
use kartik\datecontrol\DateControl;
use kartik\select2\Select2;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Income */
/* @var $modelsProductLink common\models\IncomeProductLink[] */
/* @var $form yii\widgets\ActiveForm */


$js = '
jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    jQuery(".dynamicform_wrapper .panel-title-products").each(function(index) {
        jQuery(this).html("' . Yii::t('app', 'Маҳсулот') . ': " + (index + 1))
    });
});

jQuery(".dynamicform_wrapper").on("afterDelete", function(e) {
    jQuery(".dynamicform_wrapper .panel-title-products").each(function(index) {
        jQuery(this).html("' . Yii::t('app', 'Маҳсулот') . ': " + (index + 1))
    });
});
';

$this->registerJs($js);
$this->registerJs(' 
        function initSelect2DropStyle (a, b, c) { 
            initS2Loading (a, b, c); 
        } 
        function initSelect2Loading (a, b) { 
            initS2Loading (a, b); 
        } 
    ',
    $this::POS_HEAD
);
?>

<div class="income-form ">
    <?php $form = ActiveForm::begin(['options' => ['class' => 'form', 'id' => 'dynamic-form'], 'fieldConfig' => ['template' => "{input}\n{label}\n{hint}\n{error}", 'options' => ['class' => 'form-group col-md-3']],]); ?>
    <div class="main-form-fields">

        <?= $form->field($model, 'date_time',['options' => ['class' => 'form-group col-md-3 date-control']])->widget(DateControl::className(), [
            'type' => DateControl::FORMAT_DATETIME,
            'options' => ['value' => $model->isNewRecord?date('Y-m-d H:i:s'):$model->date_time,],
            'pluginOptions' => ['autoclose' => true,],
            'widgetOptions' => ['class' => 'date-control']
        ]) ?>
        <?= $form->field($model, 'status')->widget(Select2::className(), ['data' => $model::statusList(),]) ?>
        <?= $form->field($model, 'excavator_id')->widget(Select2::className(), ['data' => Technic::getList('name', ['type_id' => Technic::TYPE_EXCAVATOR]), 'options' => ['prompt' => ' ']]) ?>
        <?= $form->field($model, 'truck_id')->widget(Select2::className(), ['data' => Technic::getList('name', ['type_id' => Technic::TYPE_TRUCK]), 'options' => ['prompt' => ' ']]) ?>
        <?= $form->field($model, 'comment', ['options' => ['class' => 'form-group col-md-12']])->textInput(['maxlength' => true]) ?>
        <div class="clearfix"></div>
        <div class="padding-v-md">
            <div class="line line-dashed"></div>
        </div>
        <?php DynamicFormWidget::begin([
            'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
            'widgetBody' => '.container-items', // required: css class selector
            'widgetItem' => '.item', // required: css class
            'limit' => 4, // the maximum times, an element can be cloned (default 999)
            'min' => 0, // 0 or 1 (default 1)
            'insertButton' => '.add-item', // css class
            'deleteButton' => '.remove-item', // css class
            'model' => $modelsProductLink[0],
            'formId' => 'dynamic-form',
            'formFields' => [
                'product_id',
                'amount',
                'price',
                'total_price',
            ],
        ]); ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-shopping-cart"></i> <?= Yii::t('app', 'Кирим маҳсулотлари') ?>
                <button type="button" class="pull-right add-item btn btn-success btn-xs"><i
                            class="fa fa-plus"></i> <?= Yii::t('app', 'Кирим маҳсулоти қўшиш') ?>
                </button>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body container-items"><!-- widgetContainer -->
                <?php foreach ($modelsProductLink

                as $index => $modelProductLink): ?>
                <div class="item panel panel-default"><!-- widgetBody -->
                    <div class="panel-heading">
                        <span class="panel-title-products"><?= Yii::t('app', 'Маҳсулот') . ':' . ($index + 1) ?></span>
                        <button type="button" class="pull-right remove-item btn btn-danger btn-xs"><i
                                    class="fa fa-minus"></i></button>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <?php
                        // necessary for update action.
                        if (!$modelProductLink->isNewRecord) {
                            echo Html::activeHiddenInput($modelProductLink, "[{$index}]id");
                        }
                        ?>
                        <?= $form->field($modelProductLink, "[{$index}]product_id")->widget(Select2::className(), ['data' => Product::getList('income_price'), 'options' => ['prompt' => ' ']]) ?>
                        <?= $form->field($modelProductLink, "[{$index}]amount")->textInput(['type' => 'number', 'onChange' => "calculateIncomeTotalPrice($(this));"]) ?>
                        <?= $form->field($modelProductLink, "[{$index}]price")->textInput(['type' => 'number', 'onChange' => "calculateIncomeTotalPrice($(this));"]) ?>
                        <?= $form->field($modelProductLink, "[{$index}]total_price")->textInput(['readonly' => true, 'class' => 'form-control dirty', 'value' => $modelProductLink->price * $modelProductLink->amount]) ?>
                    </div><!-- end:row -->

                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php DynamicFormWidget::end(); ?>
    <div class="form-buttons">
        <?= Html::submitButton(Yii::t('app', 'Сақлаш'), ['class' => 'btn btn-success', 'id' => 'save-button']) ?>
        <?= Html::button(\kartik\icons\Icon::show('save text-xxl', ['class' => 'fa']), ['class' => 'btn btn-default no-padding pull-right', 'title' => 'Қоралама сифатида сақлаш', 'id' => 'draft-button', 'onClick' => "$('#income-status').val(2);$('#dynamic-form').submit();"]) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
