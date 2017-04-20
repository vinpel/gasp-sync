<?php
namespace common\urlManager;

use yii\web\UrlRuleInterface;
use yii\base\Object;
use yii;

use common\models\FxaError;
use common\urlManager\ServeurTokenRules;
use common\urlManager\AccountServerUrlRules;

/**
* This class include the 2 others rules, to have multiple Urlrules class files
*/

class AllRules extends Object implements UrlRuleInterface
{
  /**
  * @inheritdoc
  */
  public function createUrl($manager, $route, $params){
    return ServeurTokenRules::createUrl($manager, $route, $params);
    //return false;  // this rule does not apply
  }
  /**
  * Here we put custom Paths
  */
  public function parseRequest($manager, $request){
    //We log all request except "site" base
    yii::$app->webquery->log();
    $ret=ServeurTokenRules::parseRequest($manager,$request);
    if ($ret !==false){
      return $ret;
    }
    /*$ret=AccountServerUrlRules::parseRequest($manager,$request);
    if ($ret !==false){
      return $ret;
    }*/
    return false;  // any rules apply
  }
}
