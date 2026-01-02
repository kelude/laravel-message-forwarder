<?php

return [

    'domain' => null,

    'prefix' => env('MESSAGE_FORWARDER_PREFIX', 'message-forwarder'),

    'middleware' => null,

    'webhook' => [
        'secret' => env('MESSAGE_FORWARDER_WEBHOOK_SECRET'),
        'tolerance' => env('MESSAGE_FORWARDER_WEBHOOK_TOLERANCE', 300),
    ],

];
