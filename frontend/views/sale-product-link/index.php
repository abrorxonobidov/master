<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\SaleProductLinkSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Sale Product Links');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sale-product-link-index card">
    <div class="card-head card-head-sm style-primary">
        <header><?= Html::a(Yii::t('app', 'Қўшиш'), ['create'], ['class' => 'btn btn-success pjaxModalButton']) ?></header>
    </div>
    <div class="card-body table-responsive no-padding">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'layout' => "{items}\n{summary}\n{pager}",
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'sale_id',
                'product_id',
                'amount',
                'price',
                // 'status',
                // 'created_at',
                // 'updated_at',
                // 'creator_id',
                // 'modifier_id',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>
