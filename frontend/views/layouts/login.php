<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\GentelellaAsset;
GentelellaAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
  <meta charset="<?= Yii::$app->charset ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?= Html::csrfMetaTags() ?>
  <title><?= Html::encode($this->title) ?></title>
  <?php $this->head() ?>
</head>
<body>
  <?php $this->beginBody() ?>
  <div class="row">
    <div class="col-md-offset-4 col-md-4">
      <div class="x_panel">
        <div class="x_title">
          <h2><?= Html::encode($this->title) ?></h2>

          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <?= $content ?>
        </div>
      </div>
    </div>
  </div>
  <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
