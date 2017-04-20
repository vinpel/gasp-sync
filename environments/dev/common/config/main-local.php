<?php
return [
  'components' => [
    'db' => [
      'class' => 'yii\\db\\Connection',
      'dsn' => 'mysql:host=127.0.0.1;dbname=db',
      'username' => 'muser',
      'password' => 'mpwd',
      'charset' => 'utf8',
    ],
    'mailer' => [
      'class' => 'yii\swiftmailer\Mailer',
      'viewPath' => '@common/mail',
      // send all mails to a file by default. You have to set
      // 'useFileTransport' to false and configure a transport
      // for the mailer to send real emails.
      'useFileTransport' => true,
    ],
  ],
];
