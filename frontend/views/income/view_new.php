<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var $this yii\web\View
 * @var $model common\models\Income
 * @var $productLinkDataProvider yii\data\ActiveDataFilter
 * @var $productLinkSearchModel common\models\search\IncomeProductLinkSearch
 */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Маҳсулотлар кирими'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<? if (!Yii::$app->request->isAjax) {?>
    <div class="card-body">
        <?= Html::a(Yii::t('app', 'Таҳрирлаш'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </div>
    <div class="card">
        <div class="card-head card-head-sm style-primary-light">
            <header><?= Yii::t('app', 'Асосий маълумотлар') ?></header>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-2">
                    <?= $model->date_time ?>
                </div>
                <div class="col-md-2 text-bold">
                    <?= $model->statusTitle ?>
                </div>
                <div class="col-md-2 ">
                    <?=Yii::t('app', 'Экскаватор')?>:
                    <?= @$model->excavator->name ?? '-' ?>
                </div>
                <div class="col-md-2">
                    <?=Yii::t('app', 'Юк машинаси')?>:
                    <?= @$model->truck->name ?? '-' ?>
                </div>
                <div class="col-md-2">
                    <?=Yii::t('app', 'Жами')?>:
                    <span class="text-bold">
                        <?= Yii::$app->formatter->asDecimal($model->totalSum) ?>
                    </span>
                    <?= $model->currency ?>
                </div>
            </div>
        </div>
    </div>
<? } ?>
<div class="card">
    <div class="card-head card-head-sm   style-accent-dark">
        <header><?= Yii::t('app', 'Маҳсулотлар') ?></header>
    </div>
    <div class="card-body table-responsive no-padding">
        <?=$this->render('_income_products_grid', [
            'model' => $model,
            'dataProvider' => $productLinkDataProvider
        ])?>
    </div>
</div>
