<?php

use common\models\Client;
use common\models\PayType;
use kartik\datecontrol\DateControl;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $this yii\web\View
 * @var $model common\models\search\PaymentSearch
 * @var $form yii\widgets\ActiveForm
 */

$form = ActiveForm::begin([
    'options' => ['class' => 'form payment-form'],
    'method' => 'get',
    'action' => ['payments'],
    'fieldConfig' => [
        'template' => "{input}\n{label}\n{hint}\n{error}",
        'options' => ['class' => 'form-group col-md-2']
    ]
]);

echo $form->field($model, 'date_from', ['options' => ['class' => 'form-group col-md-3 date-control']])
    ->widget(DateControl::class, [
        'type' => DateControl::FORMAT_DATE,
        'widgetOptions' => [
            'type' => 3,
            'pluginOptions' => ['autoclose' => true,],
            'class' => 'date-control', 'options' => ['placeholder' => '...дан']
        ]
    ])->label(false);

echo $form->field($model, 'date_to', ['options' => ['class' => 'form-group col-md-3 date-control']])
    ->widget(DateControl::class, [
        'type' => DateControl::FORMAT_DATE,
        'pluginOptions' => ['autoclose' => true],
        'widgetOptions' => [
            'type' => 3,
            'pluginOptions' => ['autoclose' => true,],
            'class' => 'date-control', 'options' => ['placeholder' => '...гача']
        ]
    ])->label(false);

echo $form->field($model, 'client_id')
    ->widget(Select2::class, [
        'data' => Client::getList('name'),
        'options' => ['prompt' => 'Мижоз'],
        'pluginOptions' => ['allowClear' => true]])
    ->label(false);

echo $form->field($model, 'pay_type_id')
    ->widget(Select2::class, [
        'data' => PayType::getList(),
        'options' => ['prompt' => 'тўлов тури'],
        'pluginOptions' => ['allowClear' => true]
    ])->label(false);

echo Html::beginTag('div', ['class' => 'form-group col-md-2']);
echo Html::submitButton(Yii::t('app', 'ОК'), ['class' => 'btn btn-primary btn-group']);
echo '&nbsp;';
echo Html::a(kartik\icons\Icon::show('refresh', ['class' => 'fa']), ['payments'], ['class' => 'btn btn-default btn-group']);
echo Html::endTag('div');

ActiveForm::end();
