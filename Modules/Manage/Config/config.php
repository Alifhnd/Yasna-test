<?php

return [
     'name' => 'Manage',

     'status' => [
          'color' => [
               'without'   => "default",
               'active'    => "success",
               'blocked'   => "danger",
               'deleted'   => "danger",
               'inactive'  => "danger",
               'unsaved'   => "danger",
               'published' => "success",
               'scheduled' => "info",
               'draft'     => "info",
               'pending'   => "warning",
               'private'   => "green",
               'unknown'   => "danger",
          ],
          'icon'  => [
               'without'   => "times",
               'active'    => "check",
               'blocked'   => "ban",
               'deleted'   => "times",
               'inactive'  => "times",
               'unsaved'   => "exclamation-triangle",
               'published' => "check",
               'scheduled' => "hourglass-half",
               'draft'     => "map-o",
               'pending'   => "legal",
               'private'   => "eye-slash",
               'unknown'   => "exclamation-triangle",
          ],

     ],

     'setting'                 => [
          'panel' => [
               'template' => 'info',
               'contact'  => 'purple',
               'socials'  => 'danger',
               'database' => 'success',
               'users'    => "primary",
               'security' => "pink",
               'upstream' => "inverse",
          ],
          'icon'  => [
               'template' => 'sitemap',
               'contact'  => 'comments-o',
               'socials'  => 'hashtag',
               'database' => 'database',
               'users'    => "users",
               'security' => "shield",
               'upstream' => "github-alt",
          ],
     ],
     'open_weather_map_api_id' => env('OPEN_WEATHER_MAP_API_ID', null),

     'support'       => include(__DIR__ . DIRECTORY_SEPARATOR . 'Support.php'),
     'notifications' => include(__DIR__ . DIRECTORY_SEPARATOR . 'notifications.php'),
];
