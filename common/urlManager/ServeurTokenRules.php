<?php
/*
Handles custom urls base on the Fxa recommendations
*/
namespace common\urlManager;

use yii\web\UrlRuleInterface;
use yii\base\Object;

use app\models\Token;
use app\models\FxaError;

use Hawk;
use yii;

class ServeurTokenRules extends Object implements UrlRuleInterface
{


  /**
  * Way to create custom urls
  */
  public function createUrl($manager, $route, $params){

    if ($route === 'v1/index') {
      if (isset($params['manufacturer'], $params['model'])) {
        return $params['manufacturer'] . '/' . $params['model'];
      } elseif (isset($params['manufacturer'])) {
        return $params['manufacturer'];
      }
    }
    return false;  // this rule does not apply
  }
  /**
  * Here we put custom Paths
  */
  public function parseRequest($manager, $request){
    // Load param for specific app
    $token_params=include(\Yii::getAlias('@servertoken/config/params.php'));

    // **
    // **
    $version=yii::$app->params['fxaVersions'];//SyncVersion ProtocoleVersion ContentVersion
    $pathInfo = $request->getPathInfo();

    $verb = $request->getMethod();
    //\Yii::info('chemin demandé :'.$pathInfo);
    $endPointUrl=$token_params['endPointUrl'];


    //Create Auth Token special URL
    $pattern='#^'.$version['SyncVersion'].'/sync/'.$version['ProtocoleVersion'].'#';
    if (preg_match($pattern, $pathInfo, $matches)) {
      return  ['site/uri',[]];
    }
    //info/Collections
    if (preg_match('#^'.$endPointUrl.'/([\w]+)/info/collections#', $pathInfo, $matches)) {
      return  ['storage/info-collections',['id'=>$matches[1]]];
    }

    //Storage elements, id is not gathered from the Url, but from the assertion in the HawkID
    $listBso=implode('|',$token_params['bsoList']);
    //GET
    if (in_array($verb,['GET']) && preg_match('#^'.$endPointUrl.'/([\w]+)/storage/('.$listBso.')#', $pathInfo, $matches)) {
      return  ['storage/get-bso',['id'=>$matches[1],'bso'=>$matches[2]]];
    }
    //PUT
    if (in_array($verb,['PUT']) && preg_match('#^'.$endPointUrl.'/([\w]+)/storage/('.$listBso.')#', $pathInfo, $matches)) {
      return  ['storage/put-bso',['id'=>$matches[1],'bso'=>$matches[2]]];
    }
    //POST
    if (in_array($verb,['POST']) && preg_match('#^'.$endPointUrl.'/([\w]+)/storage/('.$listBso.')#', $pathInfo, $matches)) {
      return  ['storage/post-bso',['id'=>$matches[1],'bso'=>$matches[2]]];
    }

    if (in_array($verb,['DELETE']) && preg_match('#^'.$endPointUrl.'/([\w]+)/storage/('.$listBso.')#', $pathInfo, $matches)) {
      return  ['storage/delete',['id'=>$matches[1],'bso'=>$matches[2]]];
    }
    /*
    Deletes all records for the user.
    This is URL is provided for backwards- compatibility with the previous version of the syncstorage API;
    new clients should use DELETE https://<endpoint-url>.
    */
    if (in_array($verb,['DELETE']) && preg_match('#^'.$endPointUrl.'$#', $pathInfo, $matches)) {
      return  ['storage/delete-all',[]];
    }


    //\Yii::$app->request->headers['AUTHORIZATION']='Hawk id="e"';

    if (in_array($verb,['DELETE']) && preg_match('#^'.$endPointUrl.'/([\w]+)/storage#', $pathInfo, $matches)) {
      return ['storage/delete-all',['id'=>$matches[1]]];
    }

    //découpage par groupe on accepte 3 sous répertoires pour debug

    /*if (preg_match('#^([\w\.]+)(/([\w\.]+))?(/([\w\.]+))?$#', $pathInfo, $matches)) {
    return ['',[]];
    exit;
  }*/

  return false;  // any rules apply
}
}
