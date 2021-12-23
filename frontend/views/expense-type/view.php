<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ExpenseType */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ҳаражат турлари'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="expense-type-view">
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
                    'title',
                    'order',
                    'comment',
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
