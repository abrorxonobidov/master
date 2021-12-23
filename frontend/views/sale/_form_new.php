<?php

use common\models\Client;
use common\models\PayType;
use common\models\Product;
use kartik\select2\Select2;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use yii\widgets\MaskedInput;

/**
 * @var $this yii\web\View
 * @var $model common\models\Sale
 * @var $modelsProductLink common\models\SaleProductLink[]
 * @var $payment common\models\Payment
 * @var $form yii\widgets\ActiveForm
 */


$js = '
jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    jQuery(".dynamicform_wrapper .panel-title-products").each(function(index) {
        jQuery(this).html((index + 1))
    });
});

jQuery(".dynamicform_wrapper").on("afterDelete", function(e) {
    jQuery(".dynamicform_wrapper .panel-title-products").each(function(index) {
        jQuery(this).html((index + 1))
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


$model->date_time = date('d.m.Y H:i', strtotime($model->date_time ?? 'now'));
$total_sum = 0;
?>

<div class="income-form ">
    <?php $form = ActiveForm::begin(['options' => ['class' => 'form', 'id' => 'dynamic-form'], 'fieldConfig' => ['template' => "{input}\n{label}\n{hint}\n{error}", 'options' => ['class' => 'form-group col-md-3']],]); ?>
    <td class="main-form-fields">

        <div class="row">
            <?= $form->field($model, 'date_time', ['options' => ['class' => 'form-group col-md-2']])
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
            <?= $form->field($model, 'client_id', ['options' => ['class' => 'form-group col-md-2']])->widget(Select2::class, ['data' => Client::getList('name'), 'options' => ['prompt' => ' ']]) ?>

            <?= $form->field($payment, 'price', ['options' => ['class' => 'form-group col-md-2']])
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
            <?= $form->field($payment, 'pay_type_id', ['options' => ['class' => 'form-group col-md-2']])->widget(Select2::class, ['data' => PayType::getList(), 'options' => []]) ?>
            <?= $form->field($model, 'status', ['options' => ['class' => 'form-group col-md-2']])->widget(Select2::class, ['data' => $model::statusList()]) ?>

        </div>


        <?php DynamicFormWidget::begin([
            'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
            'widgetBody' => '.container-items', // required: css class selector
            'widgetItem' => '.item', // required: css class
            'limit' => 20, // the maximum times, an element can be cloned (default 999)
            'min' => 1, // 0 or 1 (default 1)
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
        <p class="text-right">
            <button type="button" class="add-item btn btn-success btn-xs">
                <i class="fa fa-plus"></i>
            </button>
        </p>
        <table class="container-items table table-responsive table-no-border"><!-- widgetContainer -->
            <? foreach ($modelsProductLink as $index => $modelProductLink) {
                $total_sum += $modelProductLink->price *
                    ($modelProductLink->amount > 0 ? $modelProductLink->amount : 0)
                ?>
                <tr class="item"><!-- widgetBody -->
                    <td class="panel-title-products" style="vertical-align: middle">
                        <?= $index + 1 ?>
                    </td>
                    <td>
                        <? if (!$modelProductLink->isNewRecord) echo Html::activeHiddenInput($modelProductLink, "[{$index}]id"); ?>

                        <?= $form->field($modelProductLink, "[{$index}]product_id")
                            ->widget(Select2::class, [
                                'data' => Product::getListWithUnit('price'),
                                'options' => [
                                    'prompt' => ' ',
                                    'onChange' => 'changeSalePriceNext($(this))'
                                ]
                            ]);
                        ?>
                        <?= $form->field($modelProductLink, "[{$index}]price", ['enableClientValidation' => false])
                            ->widget(MaskedInput::class, [
                                'clientOptions' => [
                                    'alias' => 'decimal',
                                    'digits' => 0,
                                    'digitsOptional' => false,
                                    'groupSeparator' => 'ʼ',
                                    'autoGroup' => true,
                                    'removeMaskOnSubmit' => true,
                                    'suffix' => ' ' . Yii::t('app', 'сўм')
                                ],
                                'options' => [
                                    'oninput' => "calculateSaleTotalPrice($(this));",
                                    'class' => 'form-control'
                                ]
                            ])
                        ?>

                        <div class="col-md-3">
                            <?= $form->field($modelProductLink, "[{$index}]amount", [
                                'enableClientValidation' => false,
                                'template' => '{label} {input} {error} '
                                    . Html::tag('span', null, [
                                        'id' => "saleproductlink-$index-unit",
                                        'class' => 'input-group-addon'
                                    ]),
                                'options' => [
                                    'class' => 'form-group input-group'
                                ]
                            ])
                                ->widget(MaskedInput::class, [
                                    'clientOptions' => [
                                        'alias' => 'decimal',
                                        'digits' => 0,
                                        'digitsOptional' => false,
                                        'groupSeparator' => 'ʼ',
                                        'autoGroup' => true,
                                        'removeMaskOnSubmit' => true,
                                    ],
                                    'options' => [
                                        'oninput' => "calculateSaleTotalPrice($(this));"
                                    ]
                                ])
                            ?>
                        </div>

                        <?= $form->field($modelProductLink, "[{$index}]total_price")
                            ->widget(MaskedInput::class, [
                                'clientOptions' => [
                                    'alias' => 'decimal',
                                    'digits' => 0,
                                    'digitsOptional' => false,
                                    'groupSeparator' => 'ʼ',
                                    'autoGroup' => true,
                                    'removeMaskOnSubmit' => true,
                                    'suffix' => ' ' . Yii::t('app', 'сўм')
                                ],
                                'options' => [
                                    'readonly' => true,
                                    'class' => 'form-control dirty price-amount-multiply',
                                    'value' => $modelProductLink->price * ($modelProductLink->amount ? $modelProductLink->amount : 0)
                                ]
                            ])
                        ?>
                    </td>
                    <td>
                        <button type="button" class="pull-right remove-item btn btn-danger btn-xs">
                            <i class="fa fa-minus"></i>
                        </button>
                    </td>
                </tr><!-- end:row -->
            <? } ?>
        </table>

        <? DynamicFormWidget::end(); ?>

        <div class="row">
            <div class="col-md-offset-10 col-md-2 text-bold">
                <label for="">
                    <?= Yii::t('app', 'Жами') ?>:

                    <?= MaskedInput::widget([
                        'name' => 'sale-total-sum',
                        'clientOptions' => [
                            'alias' => 'decimal',
                            'digits' => 0,
                            'digitsOptional' => false,
                            'groupSeparator' => 'ʼ',
                            'autoGroup' => true,
                            'removeMaskOnSubmit' => true,
                            'suffix' => ' ' . Yii::t('app', 'сўм')
                        ],
                        'options' => [
                            'id' => 'sale-total-sum',
                            'class' => 'form-control',
                            'readonly' => true,
                        ],
                        'value' => $total_sum
                    ])
                    ?>
                </label>
            </div>
        </div>

        <?= $form->field($model, 'comment', ['options' => ['class' => 'form-group col-md-12']])->textarea(['rows' => 6, 'maxlength' => true]) ?>

        <div class="form-buttons">
            <?= Html::submitButton(Yii::t('app', 'Сақлаш'), ['class' => 'btn btn-success', 'id' => 'save-button']) ?>
            <?= Html::button(kartik\icons\Icon::show('save text-xxl', ['class' => 'fa']), ['class' => 'btn btn-default no-padding pull-right', 'title' => 'Қоралама сифатида сақлаш', 'id' => 'draft-button', 'onClick' => "$('#sale-status').val(2);$('#dynamic-form').submit();"]) ?>
        </div>
        <?php ActiveForm::end(); ?>
</div>
