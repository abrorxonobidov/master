<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Фойдаланувчилар'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">
    <div class="card">
        <? if (!Yii::$app->request->isAjax && $model->id === Yii::$app->user->id) { ?>
            <div class="card-body">
                <?= Html::a(Yii::t('app', 'Таҳрирлаш'), ['update', 'id' => $model->id, 'route' => \yii\helpers\Url::to()], ['class' => 'btn btn-primary pjaxModalButton']) ?>
            </div>
        <? } ?>
        <div class="card-body table-responsive no-padding">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'username',
                    'full_name',
                    'email:email',
                    'statusName',
                    'created_at:datetime',
                    'updated_at:datetime',
                ],
            ]) ?>
        </div>
    </div>
</div>
