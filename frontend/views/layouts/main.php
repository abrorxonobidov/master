<?php

/**
 * @var $this yii\web\View
 * @var $content string
 */

use abbosxon\materialadmin\assets\MaterialAsset;
use frontend\assets\AppAsset;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\widgets\Pjax;

AppAsset::register($this);
MaterialAsset::register($this);
$this->beginPage();
$user = Yii::$app->user->identity;
?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>" class="h-100">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="shortcut icon" href="/img/favicon.png" type="image/x-icon">
        <? $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <? $this->head() ?>
    </head>
    <body class="d-flex flex-column h-100 menubar-pin">
    <? $this->beginBody(); ?>
    <?= frontend\widgets\ScrollToTop::widget(); ?>
    <header id="header">
        <div class="headerbar">
            <div class="headerbar-left">
                <ul class="header-nav header-nav-options">
                    <li class="header-nav-brand">
                        <div class="brand-holder">
                            <a href="/">
                                <span class="text-lg text-bold text-primary">
                                    Master
                                </span>
                            </a>
                        </div>
                    </li>
                    <li>
                        <a class="btn btn-icon-toggle menubar-toggle" onClick="toggleMenuBarStorage()">
                            <i class="fa fa-bars"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="section-header" style="position: absolute; left: 240px">
                <?= frontend\widgets\Breadcrumbs::widget([
                    'tag' => 'ol',
                    'options' => ['class' => 'breadcrumb header', 'style' => 'background-color: #ffffff;'],
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
            </div>

            <div class="headerbar-right">
                <ul class="header-nav header-nav-profile">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle ink-reaction" data-toggle="dropdown">
                            <span class="profile-info">
                                <?= $user->full_name ?? $user->username; ?>
                            </span>
                        </a>
                        <? echo frontend\widgets\AccountMenu::widget(); ?>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <div id="base">
        <div id="content">
            <section>
                <div class="section-body">
                    <?
                    Pjax::begin(['id' => 'AlertContainer']);
                    echo common\widgets\Alert::widget();
                    Pjax::end();

                    echo $content;

                    Modal::begin([
                        'id' => 'PjaxModal',
                        'size' => Modal::SIZE_LARGE,
                        'options' => ['tabindex' => ''],
                        'clientOptions' => ['backdrop' => 'static', 'keyboard' => true, 'validateonsubmit' => true]
                    ]);
                    echo Html::img('', ['class' => Modal::SIZE_LARGE, 'style' => 'padding-right: 35px;']);
                    Modal::end();
                    ?>
                </div>
            </section>
        </div>
        <div id="menubar" class="menubar-inverse animate">
            <div class="menubar-scroll-panel">
                <?= abbosxon\materialadmin\widgets\Menu::widget([
                    'options' => ['class' => 'gui-controls', 'id' => 'main-menu',],
                    'items' => frontend\widgets\UserMenu::getUserMenuItems(),
                ]) ?>
                <div class="menubar-foot-panel">
                    <small class="no-linebreak hidden-folded">
                        <span class="opacity-75">
                           2017-<?= date('Y') ?>
                        </span>
                        <strong>&copy; I Designed It</strong>
                    </small>
                </div>
            </div>
        </div>
    </div>
    <? $this->endBody() ?>
    </body>
    </html>
<? $this->endPage(); ?>