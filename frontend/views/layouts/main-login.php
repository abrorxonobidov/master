<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use abbosxon\materialadmin\assets\MaterialAsset;

\frontend\assets\AppAsset::register($this);
MaterialAsset::register($this);
?>
<?php $this->beginPage() ?>
<html lang="en">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="/img/favicon.png" type="image/x-icon">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="menubar-hoverable header-fixed ">
<?php $this->beginBody() ?>
<section class="section-account">
    <div class="card contain-sm ">
        <div class="card-body">
                <?= $content ?>
        </div>
    </div>
</section>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
