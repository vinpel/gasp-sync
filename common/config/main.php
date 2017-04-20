<?php
return [
  'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
  'components' => [
    'webquery' => [
      'class' => 'common\components\WebQueryLog',
    ],
    'formatter' => [
      'dateFormat' => 'dd.MM.yyyy',
      'datetimeFormat'=>'MM/dd/yyyy HH:mm:ss',
      'decimalSeparator' => ',',
      'thousandSeparator' => ' ',
      'currencyCode' => 'EUR',
    ],
    'log' => [
      'traceLevel' => YII_DEBUG ? 3 : 0,
      'targets' => [
        [
          'class' => 'yii\log\DbTarget',
          'levels' => ['error', 'warning','info'],
        ],
        [
          'class' => 'yii\log\FileTarget',
          'levels' => ['error', 'warning'],
        ],
      ],
    ],
    'cache' => [
      'class' => 'yii\caching\FileCache',
    ],
    'urlManager' => [
      'enablePrettyUrl' => true,
      'showScriptName' => false,
      'rules' => [
        ['class' => 'common\urlManager\AllRules'],
      ],

    ],
  ],
];
