<?php

use kartik\datecontrol\DateControl;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $model frontend\models\Cashbox
 */

$form = ActiveForm::begin([
    'options' => ['class' => 'form payment-form'],
    'method' => 'get',
    'action' => ['cashbox'],
    'fieldConfig' => [
        'template' => "{input}\n{label}\n{hint}\n{error}",
        'options' => ['class' => 'form-group col-md-2']
    ]
]);

echo $form->field($model, 'date_from', ['options' => ['class' => 'form-group col-md-5 date-control']])
    ->widget(DateControl::class, [
        'type' => DateControl::FORMAT_DATE,
        'saveOptions' => ['name' => 'date_from'],
        'widgetOptions' => [
            'type' => 3,
            'class' => 'date-control', 'options' => ['placeholder' => '... дан', 'name' => 'date_from'],
            'pluginOptions' => ['autoclose' => true,],
        ]
    ])->label(false);

echo $form->field($model, 'date_to', ['options' => ['class' => 'form-group col-md-5 date-control']])
    ->widget(DateControl::class, [
        'type' => DateControl::FORMAT_DATE,
        'saveOptions' => ['name' => 'date_to'],
        'widgetOptions' => [
            'type' => 3,
            'class' => 'date-control', 'options' => ['placeholder' => '...гача', 'name' => 'date_to'],
            'pluginOptions' => ['autoclose' => true,],
        ]
    ])->label(false);

echo Html::beginTag('div', ['class' => 'form-group col-md-2']);
echo Html::submitButton(Yii::t('app', 'ОК'), ['class' => 'btn btn-primary btn-group']);
echo '&nbsp;';
echo Html::a(kartik\icons\Icon::show('refresh', ['class' => 'fa']), ['cashbox'], ['class' => 'btn btn-default btn-group']);
echo Html::endTag('div');

ActiveForm::end();