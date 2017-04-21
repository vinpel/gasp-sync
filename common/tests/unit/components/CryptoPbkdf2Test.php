<?php

namespace common\tests\unit\models;

use Yii;
use common\models\LoginForm;
use common\fixtures\User as UserFixture;
use \Codeception\Util\Debug;
/**
* Login form test
*/
class CryptoPbkdf2Test extends \Codeception\Test\Unit
{
  /**
  * @var \common\tests\UnitTester
  */
  protected $tester;

  /**
  * @inheritdoc
  */
  public function testPbkdf2Vector1(){
    //$algo ,  $password ,  $salt ,  $iterations ,  $length
    $result=\yii::$app->crypto->Pbkdf2("sha1","password","salt",1,0);

    $needed="0c60c80f961f0e71f3a9b524af6012062fe037a6";
    Debug::debug("\nResult: ".$result."\nNeeded: ".$needed);
    $this->assertTrue(strcmp($result,$needed)==0);
  }
  /**
  * @inheritdoc
  */
  public function testPbkdf2Vector2(){
    //$algo ,  $password ,  $salt ,  $iterations ,  $length
    $result=\yii::$app->crypto->Pbkdf2("sha1","password","salt",1,20);

    $needed="0c60c80f961f0e71f3a9";
    Debug::debug("\nResult: ".$result."\nNeeded: ".$needed);
    $this->assertTrue(strcmp($result,$needed)==0);
  }
  /**
  * @inheritdoc
  */
  public function testPbkdf2Vector3(){
    //$algo ,  $password ,  $salt ,  $iterations ,  $length
    $result=\yii::$app->crypto->Pbkdf2("sha1","password","salt",2,20);

    $needed="ea6c014dc72d6f8ccd1e";
    Debug::debug("\nResult: ".$result."\nNeeded: ".$needed);
    $this->assertTrue(strcmp($result,$needed)==0);
  }
  /**
  * @inheritdoc
  */
  public function testPbkdf2Vector4(){
    //$algo ,  $password ,  $salt ,  $iterations ,  $length
    $result=\yii::$app->crypto->Pbkdf2("sha1","password","salt",4096,20);

    $needed="4b007901b765489abead";
    Debug::debug("\nResult: ".$result."\nNeeded: ".$needed);
    $this->assertTrue(strcmp($result,$needed)==0);
  }
  /**
  * @inheritdoc
  */
  public function testPbkdf2Vector5(){
    //$algo ,  $password ,  $salt ,  $iterations ,  $length
    $result=\yii::$app->crypto->Pbkdf2(
      "sha1",
      "passwordPASSWORDpassword",
      "saltSALTsaltSALTsaltSALTsaltSALTsalt",
      4096,
      25
    );

    $needed="3d2eec4fe41c849b80c8d8366";
    Debug::debug("\nResult: ".$result."\nNeeded: ".$needed);
    $this->assertTrue(strcmp($result,$needed)==0);
  }
  /**
  * @inheritdoc
  */
  public function testPbkdf2Vector6(){
    //$algo ,  $password ,  $salt ,  $iterations ,  $length
    $result=\yii::$app->crypto->Pbkdf2(
      "sha1",
      "pass\0word",
      "sa\0lt",
      4096,
      16
    );

    $needed="56fa6aa75548099d";
    Debug::debug("\nResult: ".$result."\nNeeded: ".$needed);
    $this->assertTrue(strcmp($result,$needed)==0);
  }
}
