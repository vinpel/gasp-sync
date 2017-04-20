<?php
namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;



/* @var $scenario \Codeception\Scenario */
/**
* @inheritdoc
*/
class HelpCest
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
  public function viewHelp(FunctionalTester $I){
    $I->amOnRoute('site/help');
    $I->see('Help', 'title');
  }

}
