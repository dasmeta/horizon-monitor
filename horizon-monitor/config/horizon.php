<?php

return [
    'path'   => env('HORIZON_PATH', 'horizon'),
    'use'    => 'default',
    'prefix' => env('HORIZON_PREFIX', 'shared_horizon:'),
    'middleware' => ['web'],
    'defaults'     => [],
    'environments' => [],
];