<?php

namespace App\Controllers;

use App\Base\BotCore;
use App\Base\MainCore;

use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;

class Controller extends BotCore
{

    protected $mainCore;
    protected $container;
    protected $bot;

    public function __construct($container){
        $this->container = $container;
        $httpClient = new CurlHTTPClient($this->line["CHANNEL_ACCESS_TOKEN"]);
        $this->bot = new LINEBot($httpClient, ['channelSecret' => $this->line['CHANNEL_SECRET']]);
        $this->mainCore = new MainCore();
    }

    public function __get($property){
        if ($this->container{$property}){
            return $this->container->{$property};
        }
    }

}
