<?php

return [
    'route' => 'loadsman',

    'enabled' => env('APP_DEBUG', false),

    'middleware' => [],

    'exclude' => ['api-tester', '_debugbar'],
];
