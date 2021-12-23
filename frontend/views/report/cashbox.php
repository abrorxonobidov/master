<?php

use yii\helpers\Html;

/**
 * @var $this yii\web\View
 * @var $data array
 * @var $model frontend\models\Cashbox
 * @var $dataProvider yii\data\ArrayDataProvider
 */

$this->title = Yii::t('app', 'Касса ҳисоботи');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ҳисоботлар'), 'url' => '#'];
$this->params['breadcrumbs'][] = $this->title;

echo Html::beginTag('div', ['class' => 'card-body table-responsive no-padding']);

echo frontend\widgets\Collapse::widget([
    'header' => 'Параметрлар',
    'content' => $this->render('_cashbox_search', ['model' => $model])
]);

$group = [];
foreach ($dataProvider->allModels as $i => $cashbox) {
    if (!isset($group[$cashbox['date_on']])) {
        $group[$cashbox['date_on']] = ['position' => $i, 'preTotal' => $cashbox['prevTotal'], 'newTotal' => $cashbox['newTotal'], 'prevGroup' => false];
        if (isset($dataProvider->allModels[$i - 1])) {
            $group[$cashbox['date_on']]['prevGroup'] = $dataProvider->allModels[$i - 1]['date_on'];
            echo Html::tag('tr', Html::tag('th', "Кун сўнгидаги қолдиқ:", ['colspan' => 2, 'class' => 'text-right']) . Html::tag('td', $group[$group[$cashbox['date_on']]['prevGroup']]['newTotal'] ? Yii::$app->formatter->asDecimal($group[$group[$cashbox['date_on']]['prevGroup']]['newTotal']) . ' сўм' : '', ['class' => 'text-bold']) . Html::tag('td', null));
            echo Html::endTag('tbody');
            echo Html::endTag('table');
            echo Html::endTag('div');
            echo Html::tag('hr');
        }
        echo Html::tag('div', Html::tag('h4', $cashbox['date_on'] . ' кун учун касса', ['text-bold']), ['class' => 'col-md-12 style-info']);
        echo Html::tag('div', "", ['class' => 'clearfix']);
        echo Html::beginTag('div', ['class' => 'table-responsive no-margin card']);
        echo Html::beginTag('table', ['class' => 'table table-bordered table-hover  no-margin']);
        echo Html::beginTag('thead', ['class' => 'table table-hover no-margin']);
        echo Html::tag('tr', Html::tag('th', null) . Html::tag('th', "Мижоз") . Html::tag('th', "Тушум") . Html::tag('th', "Ҳаражат"));
        echo Html::beginTag('tbody', ['class' => 'table table-hover no-margin']);
        echo Html::tag('tr', Html::tag('th', "Кун бошидаги қолдиқ:", ['colspan' => 2, 'class' => 'text-right']) . Html::tag('td', $cashbox['prevTotal'] ? Yii::$app->formatter->asDecimal($cashbox['prevTotal']) . ' сўм' : '', ['class' => 'text-bold']) . Html::tag('td', null));
    } else {
        $group[$cashbox['date_on']]['newTotal'] = $cashbox['newTotal'];
    }
    echo Html::tag('tr', Html::tag('td', $cashbox['type'] . ' (' . date('H:i:s', strtotime($cashbox['date_time'])) . ')') . Html::tag('td', $cashbox['name']) . Html::tag('td', $cashbox['balance'] ? Yii::$app->formatter->asDecimal($cashbox['balance']) . ' сўм' : '') . Html::tag('td', $cashbox['expense'] ? Yii::$app->formatter->asDecimal($cashbox['expense']) . ' сўм' : ''));
    if ($dataProvider->totalCount === ($i + 1)) {
        echo Html::tag('tr', Html::tag('th', "Кун сўнгидаги қолдиқ:", ['colspan' => 2, 'class' => 'text-right']) . Html::tag('td', $group[$cashbox['date_on']]['newTotal'] ? Yii::$app->formatter->asDecimal(($group[$cashbox['date_on']]['newTotal'])) . ' сўм' : '', ['class' => 'text-bold']) . Html::tag('td', null));
        echo Html::endTag('tbody');
        echo Html::endTag('table');
        echo Html::endTag('div');
        echo Html::tag('hr');
    }
}

if (!$dataProvider->totalCount)
    echo Html::tag('div', 'Маълумот топилмади', ['class' => 'alert alert-info text-center']);

echo Html::endTag('div');
