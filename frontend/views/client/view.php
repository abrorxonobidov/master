<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Client */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Мижозлар'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-view">
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
                    'name',
                    'phone',
                    'car_number',
                    'car_model',
                    'address',
                    [
                        'attribute' => 'image',
                        'value' => Html::a(Html::img($model::imageSourcePath() . $model->image, ['class' => 'col-md-4']),
                            ['/uploads/' . $model->image,],
                            ['class' => 'pjaxModalButton', 'target' => Yii::$app->request->isAjax ? '__blank' : '__self']),
                        'format' => 'raw'
                    ],
                    'comment'
                ]
            ]) ?>
        </div>
    </div>
</div>
