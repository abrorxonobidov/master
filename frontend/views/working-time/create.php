<?php


/**
 * @var $this yii\web\View
 * @var $model common\models\WorkingTime
 */

$this->title = Yii::t('app', 'Қўшиш');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Иш вақтлари'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="working-time-create card">
    <div class="card-head card-head-sm style-primary">
        <header><?= $this->title ?></header>
    </div>
    <div class="card-body">
        <?= $this->render('_form', [
            'model' => $model
        ]) ?>
    </div>
</div>
