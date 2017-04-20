<?php
$params = array_merge(
  require(__DIR__ . '/../../common/config/params.php'),
  require(__DIR__ . '/../../common/config/params-local.php'),
  require(__DIR__ . '/params.php'),
  require(__DIR__ . '/params-local.php')
);

return [
  'id' => 'app-servertoken',
  'basePath' => dirname(__DIR__),
  'controllerNamespace' => 'servertoken\controllers',
  'bootstrap' => ['log'],
  'language'=>'FR_fr',
  'timezone'=>'Europe/Paris',
  'modules' => [],
  'components' => [
    'request' => [
      'csrfParam' => '_csrf-servertoken',
    ],
    'user' => [
      'identityClass' => 'common\models\User',
      'enableAutoLogin' => true,
      'identityCookie' => ['name' => '_identity-servertoken', 'httpOnly' => true],
    ],
    'response' => [
      'format' => yii\web\Response::FORMAT_JSON,
      'charset' => 'UTF-8',
    ],

    'session' => [
      // this is the name of the session cookie used for login on the servertoken
      'name' => 'advanced-servertoken',
    ],

    'errorHandler' => [
      'errorAction' => 'site/error',
    ],
    /*
    'urlManager' => [
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
  ],
],
*/
],
'params' => $params,
];
