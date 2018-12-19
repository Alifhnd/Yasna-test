<?php

return [
    'name' => 'Users',

    'status' => [
        'icon' => [
            'unknown'                     => "question-circle",
            'active'                      => "check",
            'pending'                     => "clock-o",
            'banned'                      => "ban",
            'bin'                         => "trash",
            'waiting_for_data_completion' => "hourglass-end",
            'under_examination'           => "hourglass-start",
        ],

        'color' => [
            'unknown'                     => "default",
            'active'                      => "success",
            'pending'                     => "orange",
            'banned'                      => "danger",
            'bin'                         => "danger",
            'waiting_for_data_completion' => "warning",
            'under_examination'           => "warning",
        ],

    ],
];
