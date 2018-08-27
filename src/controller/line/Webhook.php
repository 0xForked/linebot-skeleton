<?php

namespace App\Controller\Line;

use App\Controller\Controller;

use LINE\LINEBot\MessageBuilder\MultiMessageBuilder;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\MessageBuilder\StickerMessageBuilder;
use LINE\LINEBot\SignatureValidator as SignatureValidator;

class Webhook extends Controller
{

    private $signature;
    private $events;
    private $user;

    public function index($request, $response)
    {

        $body = file_get_contents('php://input');
        $this->signature = isset($_SERVER['HTTP_X_LINE_SIGNATURE']) ? $_SERVER['HTTP_X_LINE_SIGNATURE'] : '';

        // log body and signature in cli
        // file_put_contents('php://stderr', 'Body: '.$body);
        // log body and signature in monologger
        $this->logger->info($body);

        if($this->line['PASS_SIGNATURE'] === false)
        {
            // is LINE_SIGNATURE exists in request header?
            if(empty($signature)){
                return $response->withStatus(400, 'Signature not set');
            }

            // is this request comes from LINE?
            if(!SignatureValidator::validateSignature($body, $channel_secret, $signature)){
                return $response->withStatus(400, 'Invalid signature');
            }
        }


        $this->events = json_decode($body, true);

        if(is_array($this->events['events'])){
            foreach ($this->events['events'] as $event)
            {
                if ($event['type'] == 'message')
                {
                    if($event['message']['type'] == 'text')
                    {
                        // send same message as reply to user
                        $result = $this->bot->replyText($event['replyToken'], $event['message']['text']);

                        // or we can use replyMessage() instead to send reply message
                        // $textMessageBuilder = new TextMessageBuilder($event['message']['text']);
                        // $result = $bot->replyMessage($event['replyToken'], $textMessageBuilder);

                        return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                    }
                }
            }
        }

    }

    private function followCallback($event)
    {

    }

    private function textMessage($event)
    {

    }

    private function stickerMessage($event)
    {

    }

    public function sendQuestion($replyToken, $questionNum=1)
    {

    }

    private function checkAnswer($message, $replyToken)
    {

    }

}