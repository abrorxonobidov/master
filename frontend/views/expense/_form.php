<?php

use common\models\ExpenseType;
use kartik\datetime\DateTimePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

/**
 * @var $this yii\web\View
 * @var $model common\models\Expense
 * @var $form yii\widgets\ActiveForm
 */
$model->date_time = date('d.m.Y H:i', strtotime($model->date_time ?? 'now'));
?>

<div class="expense-form ">
    <?php $form = ActiveForm::begin(['options' => ['class' => 'form expense-form']]) ?>
    <div class="main-form-fields">

        <div class="row">

            <div class="col-md-6">
                <div class="panel panel-success card card-body">
                    <?= $form->field($model, 'expense_type_id')->widget(Select2::className(), ['data' => ExpenseType::getList(), 'options' => ['prompt' => ' ']]) ?>

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
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'date_time')
                    ->widget(DateTimePicker::class, [
                        'type' => DateTimePicker::TYPE_INPUT,
                        'language' => 'ru',
                        'pluginOptions' => [
                            'autoclose' => true,
                            'todayHighlight' => true,
                            'format' => 'dd.mm.yyyy hh:ii',
                            'convertFormat' => true
                        ]
                    ])
                ?>

                <?= $form->field($model, 'status')->widget(Select2::className(), ['data' => $model::statusList()]) ?>
            </div>

        </div>

        <?= $form->field($model, 'comment')->textarea(['rows' => 6, 'maxlength' => true]) ?>

    </div>
    <div class="form-buttons">
        <?= Html::submitButton(Yii::t('app', 'Сақлаш'), ['class' => 'btn btn-success', 'id' => 'save-button']) ?>
        <?= Html::button(kartik\icons\Icon::show('save text-xxl', ['class' => 'fa']), ['class' => 'btn btn-default no-padding pull-right', 'title' => 'Қоралама сифатида сақлаш', 'id' => 'draft-button', 'onClick' => "$('#expense-status').val(2);$('.expense-form').submit();"]) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

