<?php

return [
     'name'   => 'Notifier',
     "asanak" => [
          "username" => env("ASANAK_SMS_USERNAME", null),
          "password" => env("ASANAK_SMS_PASSWORD", null),
          "source"   => env("ASANAK_SMS_SOURCE", null),
          "url"      => env("ASANAK_SMS_URL", null),
     ],
];
