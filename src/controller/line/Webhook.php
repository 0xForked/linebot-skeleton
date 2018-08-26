<?php

namespace App\Controller\Line;

use App\Controller\Controller;

use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\MessageBuilder\MultiMessageBuilder;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\MessageBuilder\StickerMessageBuilder;
use LINE\LINEBot\SignatureValidator as SignatureValidator;

class Webhook extends Controller
{

    protected $pass_signature = true;
    protected $channel_access_token = "M03b4mBXRTvNu/G04X65ToBdWPmzchPCJWZQLxZpK2rCaLzgVFXPbuECDCM6S+kPsHZzkeUr4JfbqsmIbOQMomK28nJuDpexQ9c6ficvzUKyZWeQapm9xWKX/hDfBY8ByE11D2BWYM07IJbUNHIciQdB04t89/1O/w1cDnyilFU=";
    protected $channel_secret = "4751d8701dd6a1ef6a5f81deab583ade";

    public function index($request, $response)
    {

        $httpClient = new CurlHTTPClient($this->channel_access_token);
        $bot = new LINEBot($httpClient, ['channelSecret' => $this->channel_secret]);
        $body = file_get_contents('php://input');
        $signature = isset($_SERVER['HTTP_X_LINE_SIGNATURE']) ? $_SERVER['HTTP_X_LINE_SIGNATURE'] : '';

        // log body and signature
        file_put_contents('php://stderr', 'Body: '.$body);

        if($this->pass_signature === false)
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


        $data = json_decode($body, true);

        if(is_array($data['events'])){
            foreach ($data['events'] as $event)
            {
                if ($event['type'] == 'message')
                {
                    if($event['message']['type'] == 'text')
                    {
                        // send same message as reply to user
                        $result = $bot->replyText($event['replyToken'], $event['message']['text']);

                        // or we can use replyMessage() instead to send reply message
                        // $textMessageBuilder = new TextMessageBuilder($event['message']['text']);
                        // $result = $bot->replyMessage($event['replyToken'], $textMessageBuilder);

                        return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                    }
                }
            }
        }

    }

}