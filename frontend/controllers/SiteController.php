<?php
namespace frontend\controllers;

use yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use common\models\LoginForm;

use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;

use servertoken\models\Token;
/**
* Site controller
*/
class SiteController extends Controller
{
  /**
  * @inheritdoc
  */
  public function behaviors(){
    return [
      'access' => [
        'class' => AccessControl::className(),
        'except' => [ 'signup'],
        'rules' => [
          [
            'actions'=>['error'],
            'allow' => true,
          ],
          [
            'actions'=>['login'],
            'allow' => true,
            'roles' => ['?'],
          ],
          [
            'actions' => [
              'view-logs','debug-browserid',

              'help','index','logout'
            ],
            'allow' => true,
            'roles' => ['@'],
          ]
        ],
      ],
      'verbs' => [
        'class' => VerbFilter::className(),
        'actions' => [
          'logout' => ['post'],
        ],
      ],
    ];
  }

  /**
  * @inheritdoc
  */
  public function actions(){
    return [
      'error' => [
        'class' => 'yii\web\ErrorAction',
      ],
      'captcha' => [
        'class' => 'yii\captcha\CaptchaAction',
        'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
      ],
    ];
  }

  /**
  * Displays homepage.
  *
  * @return mixed
  */
  public function actionIndex(){
    return $this->render('index',[
      'publicURI'=>Yii::$app->params['publicURI']
    ]);
  }
  /**
  * Logs in a user.
  *
  * @return mixed
  */
  public function actionLogin(){
    $this->layout='login';
    if (!Yii::$app->user->isGuest) {
      return $this->goHome();
    }
    $model = new LoginForm();
    if ($model->load(Yii::$app->request->post()) && $model->login()) {
      return $this->goBack();
    } else {
      return $this->render('login', [
        'model' => $model,
      ]);
    }
  }

  /**
  * Logs out the current user.
  *
  * @return mixed
  */
  public function actionLogout(){
    Yii::$app->user->logout();
    return $this->goHome();
  }

  /**
  * Displays help page.
  *
  * @return mixed
  */
  public function actionHelp()
  {
    return $this->render('help');
  }

  /**
  * Signs user up.
  *
  * @return mixed
  */
  public function actionSignup()
  {
    $this->layout='login';
    $model = new SignupForm();
    if ($model->load(Yii::$app->request->post())) {
      if ($user = $model->signup()) {
        if (Yii::$app->getUser()->login($user)) {
          return $this->goHome();
        }
      }
    }

    return $this->render('signup', [
      'model' => $model,
    ]);
  }

  /**
  * Requests password reset.
  *
  * @return mixed
  */
  public function actionRequestPasswordReset()
  {
    $model = new PasswordResetRequestForm();
    if ($model->load(Yii::$app->request->post()) && $model->validate()) {
      if ($model->sendEmail()) {
        Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

        return $this->goHome();
      } else {
        Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
      }
    }

    return $this->render('requestPasswordResetToken', [
      'model' => $model,
    ]);
  }

  /**
  * Resets password.
  *
  * @param string $token
  * @return mixed
  * @throws BadRequestHttpException
  */
  public function actionResetPassword($token)
  {
    try {
      $model = new ResetPasswordForm($token);
    } catch (InvalidParamException $e) {
      throw new BadRequestHttpException($e->getMessage());
    }

    if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
      Yii::$app->session->setFlash('success', 'New password saved.');

      return $this->goHome();
    }

    return $this->render('resetPassword', [
      'model' => $model,
    ]);
  }
  /**
  * Display the content of the "LogRequest" table
  */
  public function actionViewLogs(){
    return $this->render('view-logs');
  }
  /**
  * send a pre-configured user.js file based on the server config
  */
  public function actionUserjs(){
    $this->layout = false;
    $userjs= $this->render('userjs');
    \Yii::$app->response->sendContentAsFile($userjs,'user.js')->send();
  }
  /**
  * Display data for a BrowserID
  */
  public function actionDebugBrowserid(){
    $ret='';
    if (yii::$app->request->isPost){
      $brs=yii::$app->request->post('BrowserID');
      $BrowserID=str_replace(array( "\n", "\r",'...'), '', $brs);
      $ret= '<pre>';
      $ret.= $BrowserID."\n\n";
      $myToken=new Token();
      $tokenData=$myToken->extractTokenData($BrowserID);
      try{
        $res=$myToken->verifyAssertion(yii::$app->params['publicURI'],$tokenData['payload']);
        $ret.=print_r($res,true);
        //Fake assertion
        //      $assertion = $myToken->createAssertion($email,\Yii::$app->params['publicURI']);
      }
      catch (\Exception $e) {
        $ret.=print_r($e->getMessage(),true) ;
      }
      $ret.= '</pre>';
    }
    return $this->render('debug-browserid',['data'=>$ret]);
  }
}
