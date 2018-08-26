<?php

/*
|----------------------------------------------------
| controller                                        |
|----------------------------------------------------
*/

    $container['LineWebhook'] = function ($container) {
        return new \App\Controller\Line\Webhook($container);
    };

/*
|----------------------------------------------------
| Middleware                                        |
|----------------------------------------------------
*/

    // $app->add(new \App\Middleware\SampleMiddleware($container));