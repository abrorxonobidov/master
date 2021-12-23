<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Technic */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Техникалар'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="technic-view">
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
                    ['attribute' => 'type_id', 'value' => $model->typeName],
                    'name',
                    'phone',
                    'model',
                    'number',
                    'driver_name',
                    [
                        'attribute' => 'image',
                        'value' => Html::a(Html::img($model::imageSourcePath() . $model->image, ['class' => 'col-md-4'])
                            . ' ' . Html::tag('p', $model->image),
                            ['/uploads/' . $model->image,],
                            ['class' => 'pjaxModalButton', 'target' => Yii::$app->request->isAjax ? '__blank' : '__self']),
                        'format' => 'raw'
                    ],
                    'comment',
                ],
            ]) ?>
        </div>
    </div>
</div>
