<?php
return [
    'adminEmail' => 'admin@example.com',

    'bsoList'  => ['keys','collections','clients','crypto','forms','history','meta','bookmarks','prefs','tabs','passwords','addons'],

    'endPointUrl'=>'syncServer',
      // Authorized issuer
    'assertionIssuer'=>['localhost','api.accounts.firefox.com','172.16.28.66'],
    'storagePath' =>[
      'wellKnowKey' => '@storage/well-known',
      'storageKey'=> '@storage/idp/',
      'storageToken' => '@storage/secretToken',
      ]

];
