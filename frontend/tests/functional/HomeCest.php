<?php

namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;
/**
* @inheritdoc
*/
class HomeCest
{
  /**
  * @inheritdoc
  */
  function _before(FunctionalTester $I){
    $I->logMeIn();
  }
  /**
  * @inheritdoc
  */
  public function checkOpen(FunctionalTester $I)
  {
    $I->amOnPage(\Yii::$app->homeUrl);
    $I->seeLink('Dashboard');
  }
}
