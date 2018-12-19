<?php

return [
     'role_prefix_for_domain_admins' => env("ROLE_PREFIX_FOR_DOMAIN_ADMINS", "domain"),
     'permission_wildcards'          => ['', 'any', '*'],
     "chalk"                         => env('CHALK', debugMode()),
     'modules'                       => require(__DIR__ . '/modules.php'),
];
