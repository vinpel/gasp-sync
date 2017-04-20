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
class SiteController extends Controller
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
  * log all web query before each action
  */
  public function beforeAction($action){
    yii::$app->webquery->log();
    return parent::beforeAction($action);
  }
  /**
  * Displays homepage.
  *
  * @return string
  */
  public function actionIndex(){

    return ['servertoken'=>'ok'];
  }
  /**
  * Resond to token/1.0/sync/1.5
  */
  public function actionUri(){
    print "@";
  }
  /**
  * send a pre-configured user.js file based on the server config
  */
  public function actionUserjs(){
    $this->layout = 'empty';
    $userjs= $this->render('userjs',[
      'publicURI'=>Yii::$app->params['publicURI']
    ]);
    \Yii::$app->response->sendContentAsFile($userjs,'user.js')->send();
  }
}
