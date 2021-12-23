<?php

use kartik\datetime\DateTimePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $this yii\web\View
 * @var $model common\models\WorkingTime
 * @var $form yii\widgets\ActiveForm
 */

$model->begin_time = date('d.m.Y H:i', strtotime($model->begin_time ?? 'now'));
$model->end_time = date('d.m.Y H:i', strtotime($model->end_time ?? 'now'));

?>

<div class="working-time-form ">
    <?php $form = ActiveForm::begin(['options' => ['class' => 'form'], 'fieldConfig' => ['template' => "{input}\n{label}\n{hint}\n{error}", 'options' => ['class' => 'form-group col-md-6']],]); ?>
    <div class="main-form-fields">

        <?= $form->field($model, 'begin_time')
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

        <?= $form->field($model, 'end_time')
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

        <div class="clearfix"></div>
        <?= $form->field($model, 'begin_comment', ['options' => ['class' => 'form-group col-md-6']])->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'end_comment', ['options' => ['class' => 'form-group col-md-6']])->textarea(['rows' => 6]) ?>

    </div>
    <div class="form-buttons">
        <?= Html::submitButton(Yii::t('app', 'Сақлаш'), ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
