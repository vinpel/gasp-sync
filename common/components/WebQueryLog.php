<?php
namespace common\components;


use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use common\models\LogRequest;
class WebQueryLog extends Component
{
  /**
  * @inheritdoc
  */
  public function welcome()
  {
    echo "Hello..Welcome to MyComponent";
  }
  /**
  * insert log info for the current request
  */
  public function log(){
    $headers=yii::$app->request->getHeaders()->toArray();
    foreach ($headers as $key=>$header){
      $res_header[$key]=$header[0];
    }
    $pinfo=yii::$app->request->getPathInfo();

    if (strlen($pinfo)>0 && strcmp(substr($pinfo,0,4),'site')!=0){
      $log=new LogRequest();
      $log->url=             yii::$app->request->getAbsoluteUrl();
      $log->headers_json=    json_encode($res_header);
      $log->method=          yii::$app->request->getMethod();
      $log->raw_body=        yii::$app->request->getRawBody();
      $log->body_params=     json_encode(yii::$app->request->getBodyParams());
      $log->response_code = "200";
      if (!$log->save()){
        print_r($log->errors);exit;
        throw new yii\web\BadRequestHttpException ("error for : sav LogRequest");
      }
    }
  }

}
