<?php

namespace App\Controller;

use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;

class Controller {

    protected $container;
    protected $bot;

    public function __construct($container){
        $this->container = $container;
        $httpClient = new CurlHTTPClient($this->line["CHANNEL_ACCESS_TOKEN"]);
        $this->bot = new LINEBot($httpClient, ['channelSecret' => $this->line['CHANNEL_SECRET']]);
    }

    public function __get($property){
        if ($this->container{$property}){
            return $this->container->{$property};
        }
    }

}