<?php
namespace frontend\tests;
use common\fixtures\User as UserFixture;
/**
* Inherited Methods
* @method void wantToTest($text)
* @method void wantTo($text)
* @method void execute($callable)
* @method void expectTo($prediction)
* @method void expect($prediction)
* @method void amGoingTo($argumentation)
* @method void am($role)
* @method void lookForwardTo($achieveValue)
* @method void comment($description)
* @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
*
* @SuppressWarnings(PHPMD)
*/
class FunctionalTester extends \Codeception\Actor
{
  use _generated\FunctionalTesterActions;

  /**
  * @inheritdoc
  */
  public function seeValidationError($message){
    $this->see($message, '.help-block');
  }
  /**
  * @inheritdoc
  */
  public function dontSeeValidationError($message){
    $this->dontSee($message, '.help-block');
  }
  /**
  * @inheritdoc
  */
  public function logMeIn(){
    $this->haveFixtures([
      'user' => [
        'class' => UserFixture::className(),
        'dataFile' => codecept_data_dir() . 'login_data.php'
      ]
    ]);
    $this->amOnRoute('site/login');
    $this->submitForm('#login-form',[
      'LoginForm[username]'=>'erau',
      'LoginForm[password]'=>'password_0'
    ]);
    $this->see('Logout (erau)', 'form button[type=submit]');
  }
}
