<?php


/**
 * @var $this yii\web\View
 * @var $model common\models\Product
 */

$this->title = Yii::t('app', 'Қўшиш');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Маҳсулотлар'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-create card">
    <div class="card-head card-head-sm style-primary">
        <header><?= $this->title ?></header>
    </div>
    <div class="card-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>
