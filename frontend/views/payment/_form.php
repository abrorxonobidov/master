<?php

use common\models\Client;
use common\models\PayType;
use kartik\datetime\DateTimePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

/**
 * @var $this yii\web\View
 * @var $model common\models\Payment
 * @var $form yii\widgets\ActiveForm
 */
$model->date_time = date('d.m.Y H:i', strtotime($model->date_time ?? 'now'));

?>

<div class="payment-form ">
    <?php $form = ActiveForm::begin(['options' => ['class' => 'form payment-form']]); ?>
    <div class="main-form-fields">

        <div class="row">

            <div class="col-md-6">
                <div class="panel panel-success card card-body">

                    <?= $form->field($model, 'client_id')
                        ->widget(Select2::class, [
                            'data' => Client::getList('name'),
                            'options' => ['prompt' => ' ']
                        ]) ?>

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

                <?= $form->field($model, 'pay_type_id')->widget(Select2::class, ['data' => PayType::getList(), 'options' => ['prompt' => ' ']]) ?>

                <?= $form->field($model, 'status')->widget(Select2::class, ['data' => $model::statusList()]) ?>
            </div>
        </div>
        <?= $form->field($model, 'comment')->textarea(['rows' => 6, 'maxlength' => true]) ?>
    </div>

    <div class="form-buttons">
        <?= Html::submitButton(Yii::t('app', 'Сақлаш'), ['class' => 'btn btn-success', 'id' => 'save-button']) ?>
        <?= Html::button(kartik\icons\Icon::show('save text-xxl', ['class' => 'fa']), ['class' => 'btn btn-default no-padding pull-right', 'title' => 'Қоралама сифатида сақлаш', 'id' => 'draft-button', 'onClick' => "$('#payment-status').val(2);$('.payment-form').submit();"]) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
