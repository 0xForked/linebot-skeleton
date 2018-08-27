<?php

namespace App\Controller\Line;

use App\Controllers\Controller;

use LINE\LINEBot\SignatureValidator as SignatureValidator;

use App\Model\Event;
use App\Model\User;


class Callback extends Controller
{

    private $signature;
    private $events;
    private $user;

    public function index($request, $response)
    {

        $body = file_get_contents('php://input');
        $this->signature = isset($_SERVER['HTTP_X_LINE_SIGNATURE']) ? $_SERVER['HTTP_X_LINE_SIGNATURE'] : '';

        if($this->line['PASS_SIGNATURE'] === false)
        {
            // is LINE_SIGNATURE exists in request header?
            if(empty($this->signature))
            {
                return $response->withStatus(400, 'Signature not set');
            }
            // is this request comes from LINE?
            if(!SignatureValidator::validateSignature($body, $this->line['CHANNEL_SECRET'], $this->signature))
            {
                return $response->withStatus(400, 'Invalid signature');
            }
        }

        // log body and signature in cli
        file_put_contents('php://stderr', 'Body: '.$body);
        // log body and signature in monologger
        $this->logger->info($body);
        // log body and signature in databases
        Event::create(['signature'=>$this->signature, 'events'=> $body]);
        // set event from body
        $this->events = json_decode($body, true);

        if(is_array($this->events['events']))
        {
            foreach ($this->events['events'] as $event)
            {
                if(!isset($event['source']['userId'])) continue;

                $user = User::where('user_id', $this->botEventSourceUid($event))->first();

                if (!$user)
                {
                    $this->followCallback($event);
                } else {
                    if ($this->botEventSourceIsTypeMessage($event))
                    {
                        if(method_exists($this, $this->botEventMessageType($event).'Message')){
                            $this->{$this->botEventMessageType($event).'Message'}($event);
                        }
                    } else {
                        if(method_exists($this, $event['type'].'Callback')){
                          $this->{$event['type'].'Callback'}($event);
                        }
                    }
                }
            }
        }

    }

    private function followCallback($event)
    {
        //YOUR CODE
    }

    private function unfollowCallback($event)
    {
        //YOUR CODE
    }

    private function joinCallback($event)
    {
        //YOUR CODE
    }

    private function leaveCallback($event)
    {
        //YOUR CODE
    }

    private function textMessage($event)
    {
        //YOUR CODE
    }


}