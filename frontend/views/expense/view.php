<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Expense */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ҳаражатлар'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="expense-view">
    <div class="card">
        <?php if (!Yii::$app->request->isAjax): ?>
            <div class="card-body">
                <?= Html::a(Yii::t('app', 'Таҳрирлаш'), ['update', 'id' => $model->id, 'route' => \yii\helpers\Url::to()], ['class' => 'btn btn-primary pjaxModalButton']) ?>
            </div>
        <?php endif; ?>
        <div class="card-body table-responsive no-padding">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'expense_type_id',
                    'date_time',
                    'price',
                    'comment',
                    'statusTitle:raw'
                ],
            ]) ?>
        </div>
    </div>
</div>
