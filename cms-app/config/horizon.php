<?php

$queueName = env('WORKER_QUEUE_NAME', 'cms-main');

return [
    'use'    => 'default',
    'prefix' => env('HORIZON_PREFIX', 'shared_horizon:'),
    'path' => env('HORIZON_PATH', 'horizon'),
    'middleware' => ['web'],
    'defaults' => [
        $queueName => [
            'connection'   => 'redis',
            'queue'        => [$queueName],
            'balance'      => 'auto',
            'autoScalingStrategy' => 'time',
            'minProcesses' => env('WORKER_MIN_PROCESSES', 1),
            'maxProcesses' => env('WORKER_MAX_PROCESSES', 1),
            'tries'        => env('WORKER_TRIES', 3),
            'timeout'      => env('WORKER_TIMEOUT', 3600),
            'maxTime'      => env('WORKER_MAX_TIME', 3600),
            'memory'       => env('WORKER_MEMORY', 256),
        ],
    ],

    'environments' => [
        'local' => [$queueName => []],
        'staging' => [$queueName => []],
        'production' => [$queueName => []],
    ],
];