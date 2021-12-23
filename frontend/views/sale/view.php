<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Sale */
/* @var $payment common\models\Payment */
/* @var $productLinkDataProvider \yii\data\ActiveDataFilter */
/* @var $productLinkSearchModel common\models\search\SaleProductLinkSearch */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Сотув'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php if (!Yii::$app->request->isAjax): ?>
    <div class="card-body">
        <?= Html::a(Yii::t('app', 'Таҳрирлаш'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </div>
<?php endif; ?>
<div class="card">
    <div class="card-head card-head-sm   style-primary-light">
        <header><?= Yii::t('app', 'Асосий маълумотлар') ?></header>
    </div>
    <div class="card-body table-responsive no-padding">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'date_time',
                ['attribute' => 'client_id', 'value' => @$model->client->name . ' (' . @$model->client->phone . ')',],
                ['label' => 'Тўлов тури', 'value' => @$model->payment->payType->title],
                ['label' => 'Тўлов', 'value' => @$model->payment->price],
                ['attribute' => 'status', 'format' => 'raw', 'value' => Html::tag('span', $model->statusName, ['class' => 'text-' . $model->statusColor])],
                'comment',
            ],
        ]) ?>
    </div>
</div>
<div class="card">
    <div class="card-head card-head-sm   style-accent-dark">
        <header><?= Yii::t('app', 'Маҳсулотлар') ?></header>
    </div>
    <div class="card-body table-responsive no-padding">
        <?= GridView::widget([
            'dataProvider' => $productLinkDataProvider,
            'filterModel' => false,
            'layout' => "{items}\n{summary}\n{pager}",
            'columns' => [
                [
                    'attribute' => 'product_id',
                    'value' => function (\common\models\SaleProductLink $data) {
                        return $data->product->title;
                    }
                ],
                'amount',
                'price',
                [
                    'attribute' => 'total_price',
                    'value' => function (\common\models\SaleProductLink $data) {
                        return $data->amount * $data->price;
                    }
                ],
            ],
        ]); ?>
    </div>
</div>
