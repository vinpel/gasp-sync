<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use frontend\assets\CodemirrorAsset;
CodemirrorAsset::register($this);

use yii\web\View;
use frontend\assets\GentelellaAsset;
GentelellaAsset::register($this);

$this->title = 'Help';

?>
<div class="page-title">
  <div class="title_left">
    <h3><?=$this->title?></h3>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Setting up firefox Desktop</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <p>This is the About page. You may modify the following file to customize its content:</p>

        <code><?= __FILE__ ?></code>
