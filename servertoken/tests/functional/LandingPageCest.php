<?php

namespace servertoken\tests\functional;

use \servertoken\tests\FunctionalTester;
use common\fixtures\User as UserFixture;

/**
* Class LoginCest
*/
class LandingPageCest{
  public function _before(FunctionalTester $I)
  {
    $I->haveFixtures([
      'user' => [
        'class' => UserFixture::className(),
        'dataFile' => codecept_data_dir() . 'login_data.php'
      ]
    ]);
  }
  /**
  * @param FunctionalTester $I
  */
  public function loginUser(FunctionalTester $I){
    $I->amOnPage('/token');
    $I->seeResponseContainsJson(array('servertoken' => 'ok'));
  }
}
