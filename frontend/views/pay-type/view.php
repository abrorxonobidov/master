<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\PayType */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Тўлов турлари'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pay-type-view">
    <div class="card">
        <?php if(!Yii::$app->request->isAjax):?>
            <div class="card-body">
                <?= Html::a(Yii::t('app', 'Таҳрирлаш'), ['update', 'id' => $model->id,'route' => \yii\helpers\Url::to()], ['class' =>'btn btn-primary pjaxModalButton']) ?>
            </div>
        <?php endif;?>
        <div class="card-body table-responsive no-padding">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                            'id',
                'title',
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
