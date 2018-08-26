<?php

/*
|----------------------------------------------------
| Routing sytem                                     |
|----------------------------------------------------
*/

    $app->get('/', function($request, $response){
        return $response->withJson([
            'status' => 'ok',
            'message' => 'aasumitro.id'
        ], 200);
    });

    $app->post('/v1/api/line-bot/webhook', 'LineWebhook:index');