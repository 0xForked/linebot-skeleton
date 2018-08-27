<?php

/*
|----------------------------------------------------
| Routing sytem                                     |
|----------------------------------------------------
*/

    $app->get('/', function($request, $response){
        return $response->withJson([
            'status' => 'ok',
            'message' => 'welcome!'
        ], 200);
    });

    $app->post('/callback', 'LineWebhook:index');