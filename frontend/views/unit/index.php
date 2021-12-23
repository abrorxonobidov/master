<?php

use yii\helpers\Html;
use frontend\widgets\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\UnitSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Ўлчов бирликлари');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="my-card card">
    <div class="card-head style-primary">
        <header><?= Html::a(Yii::t('app', 'Қўшиш'), ['create'], ['class' => 'btn btn-success pjaxModalButton']) ?></header>
    </div>
    <div class="card-body table-responsive no-padding">

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                [
                    'attribute' => 'title',
                    'format' => 'raw',
                    'value' => function ($data) {
                        return Html::a($data->title, ['update', 'id' => $data->id], ['class' => 'pjaxModalButton']);
                    }
                ],
                'comment'
            ]
        ]); ?>
    </div>
</div>
