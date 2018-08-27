<?php

/*
|----------------------------------------------------
| controller                                        |
|----------------------------------------------------
*/

    $container['LineWebhook'] = function ($container) {
        return new \App\Controllers\Line\Callback($container);
    };

/*
|----------------------------------------------------
| Middleware                                        |
|----------------------------------------------------
*/

    // $app->add(new \App\Middleware\SampleMiddleware($container));