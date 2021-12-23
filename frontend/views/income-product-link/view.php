<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\IncomeProductLink */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Кирим товарлар'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="income-product-link-view">
    <div class="card">
        <div class="card-body">
            <?= Html::a(Yii::t('app', 'Таҳрирлаш'), ['update', 'id' => $model->id], ['class' =>
            'btn btn-primary']) ?>
            
        </div>
        <div class="card-body table-responsive no-padding">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                            'id',
                'income_id',
                'product_id',
                'amount',
                'price',
                'status',
                'created_at:datetime',
                'updated_at:datetime',
                'creator_id',
                'modifier_id',
                ],
            ]) ?>
        </div>
    </div>
</div>
