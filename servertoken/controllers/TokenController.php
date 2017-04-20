<?php
namespace servertoken\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;

/**
* Site controller
*/
class TokenController extends Controller
{
  /**
  * @inheritdoc
  */
  public function actions(){
    return [
      'error' => [
        'class' => 'yii\web\ErrorAction',
      ],
    ];
  }

  /**
  * Displays homepage.
  *
  * @return string
  */
  public function actionIndex(){
    yii::$app->webquery->log();
    return ['servertoken'=>'ok'];
  }


}
