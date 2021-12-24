<?php

use yii\bootstrap\Html;

/**
 * @var $this yii\web\View
 * @var $model common\models\Product
 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Маҳсулотлар'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card">
    <div class="card-body table-responsive no-padding">
        <div class="card-head style-primary">
            <header><?= $model->title ?></header>
        </div>
        <? if (!Yii::$app->request->isAjax) { ?>
            <div class="card-body">
                <?= Html::a(Html::icon('pencil') . ' ' . Yii::t('app', 'Таҳрирлаш'),
                    ['update', 'id' => $model->id, 'route' => yii\helpers\Url::to()],
                    ['class' => 'btn btn-primary']
                ) ?>
            </div>
        <? } ?>
        <?= yii\widgets\DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'title',
                'income_price',
                'price',
                'unit.title',
                'quantityWithUnit',
                'comment',
                [
                    'attribute' => 'image',
                    'value' => Html::a(Html::img($model::imageSourcePath() . $model->image, ['class' => 'col-md-4'])
                        . ' ' . Html::tag('p', $model->image),
                        ['/uploads/' . $model->image,],
                        ['class' => 'pjaxModalButton', 'target' => Yii::$app->request->isAjax ? '__blank' : '__self']),
                    'format' => 'raw'
                ]
            ]
        ]) ?>
    </div>
</div>
