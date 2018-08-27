<?php

namespace App\Base;

use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\MessageBuilder\ImageMessageBuilder;
use LINE\LINEBot\MessageBuilder\VideoMessageBuilder;
use LINE\LINEBot\MessageBuilder\AudioMessageBuilder;
use LINE\LINEBot\MessageBuilder\LocationMessageBuilder;
use LINE\LINEBot\MessageBuilder\StickerMessageBuilder;
use LINE\LINEBot\MessageBuilder\TemplateMessageBuilder;
use LINE\LINEBot\MessageBuilder\MultiMessageBuilder;
use LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ConfirmTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder;

class BotCore
{

    /*
    |----------------------------------------------------
    | Source
    |----------------------------------------------------
    */

        public function botEventReplyToken($event)
        {
            return $event['replyToken'];
        }

        public function botEventSourceType($event)
        {
            return $event['source']['type'];
        }

        public function botEventSourceUid($event)
        {
            return $event['source']['userId'];
        }

        public function botEventSourceRoomId($event)
        {
            return $event['source']['roomId'];
        }

        public function botEventSourceGroupId($event)
        {
            return $event['source']['groupId'];
        }

        public function botEventSourceIsGroup($event)
        {
            if($event['source']['type'] == "group")
            {
                return true;
            }
            return false;
        }

        public function botEventSourceIsRoom($event)
        {
            if($event['source']['type'] == "room")
            {
                return true;
            }
            return false;
        }

        public function botEventSourceIsTypeMessage($event)
        {
            if ($event['type'] == 'message')
            {
                return true;
            }
            return false;
        }

    /*
    |----------------------------------------------------
    | Message
    |----------------------------------------------------
    */

        public function botEventMessageType($event)
        {
            return $event['message']['type'];
        }

        public function botEventMessageId($event)
        {
            return $event['message']['id'];
        }

        public function botEventMessageText($event)
        {
            return $event['message']['text'];
        }

        public function botEventMessageFileName($event)
        {
            return $event['message']['fileName'];
        }

        public function botEventMessageFileSize($event)
        {
            return $event['message']['fileSize'];
        }

        public function botEventMessageTitle($event)
        {
            return $event['message']['title'];
        }

        public function botEventMessageAddress($event)
        {
            return $event['message']['address'];
        }

        public function botEventMessageLatitude($event)
        {
            return $event['message']['latitude'];
        }

        public function botEventMessageLogtitude($event)
        {
            return $event['message']['logtitude'];
        }

        public function botEventMessagePackageID($event)
        {
            return $event['message']['packageId'];
        }

        public function botEventMessageStickerID($event)
        {
            return $event['message']['stickerId'];
        }

        public function botEventPostbackData($event)
        {
            return $event['postback']['data'];
        }

    /*
    |----------------------------------------------------
    | Action
    |----------------------------------------------------
    */

        public function botGetProfile($event)
        {
            $uid = $this->botEventSourceUid($event);
            $response = $this->bot->getProfile($uid);
            if($response->isSucceeded())
            {
                $profile = $response->getJSONDecodedBody();
                return $profile;
            }
        }

        public function botEventLeaveRoom($event)
        {
            return $this->bot->leaveRoom($this->botEventSourceRoomId($event));
        }

        public function botEventLeaveGroup($event)
        {
            return $this->bot->leaveRoom($this->botEventSourceGroupId($event));
        }

        public function botReplyText($event, $message)
        {
            $response = $this->bot->replyText(
                $this->botEventReplyToken($event),
                $message
            );
            if($response->isSucceeded())
            {
                return true;
            }
        }

        public function botReplyMessage($event, $message)
        {
            $response = $this->bot->replyMessage(
                $this->botEventReplyToken($event),
                $message
            );
            if($response->isSucceeded())
            {
                return true;
            }
        }

        public function botSendText($event, $text)
        {
            $input = new TextMessageBuilder($text);
            $response = $this->bot->replyMessage(
                $this->botEventReplyToken($event),
                $input
            );
            if ($response->isSucceeded())
            {
                return true;
            }
        }

        public function botSendImage($event, $url, $preview_url)
        {
            $input = new ImageMessageBuilder(
                $url,
                $preview_url
            );
            $response = $this->bot->replyMessage(
                $this->botEventReplyToken($event),
                $input
            );
            if ($response->isSucceeded())
            {
                return true;
            }
        }

        public function botSendVideo($event, $url, $preview_url)
        {
            $input = new VideoMessageBuilder(
                $url,
                $preview_url
            );
            $response = $this->bot->replyMessage(
                $this->botEventReplyToken($event),
                $input
            );
            if ($response->isSucceeded())
            {
                return true;
            }
        }

        public function botSendAudio($event, $content, $duration)
        {
            $input = new AudioMessageBuilder($content, $duration);
            $response = $this->bot->replyMessage(
                $this->botEventReplyToken($event),
                $input
            );
            if ($response->isSucceeded())
            {
                return true;
            }
        }

        public function botSendLocation($event, $title, $address, $latitude, $longitude)
        {
            $input = new LocationMessageBuilder(
                $title,
                $address,
                $latitude,
                $longitude
            );
            $response = $this->bot->replyMessage(
                $this->botEventReplyToken($event),
                $input
            );
            if ($response->isSucceeded())
            {
                return true;
            }
        }

        public function botSendSticker($event, $packageId, $stickerId)
        {
            $input = new StickerMessageBuilder(
                $packageId,
                $stickerId
            );
            $response = $this->bot->replyMessage(
                $this->botEventReplyToken($event),
                $input
            );
            if ($response->isSucceeded())
            {
                return true;
            }
        }

    /*
    |----------------------------------------------------
    | Message Builder
    |----------------------------------------------------
    */

        public function botTemplateMessageBuilder($text, $template)
        {
            $input = new TemplateMessageBuilder($text, $template);
            return $input;
        }

        public function botMultiMessageBuilder($array)
        {
            $multi = new MultiMessageBuilder;
            foreach($array as $item)
            {
                $input = $multi->add($item);
            }
            return $input;
        }

        public function botTextMessageBuilder($text)
        {
            $input = new TextMessageBuilder($text);
            return $input;
        }

        public function botStickerMessageBuilder($packageId, $stickerId)
        {
            $input = new StickerMessageBuilder(
                $packageId,
                $stickerId
            );
            return $input;
        }

        public function botButtonTemplateBuilder($title, $text, $thumbnail, $actions)
        {
            foreach($actions as $action)
            {
                $options[] = new MessageTemplateActionBuilder(
                    $action['label'],
                    $action['text']
                );
            }
            $input = new ButtonTemplateBuilder(
                $title,
                $text,
                $thumbnail,
                $options
            );
            return $input;
        }

        public function botConfirmTemplateBuilder($text, $actions)
        {
            foreach($actions as $action)
            {
                $options[] = new MessageTemplateActionBuilder(
                    $action['label']
                    ,$action['text']
                );
            }
            $input = new ConfirmTemplateBuilder(
                $text,
                $options
            );
            return $input;
        }

        public function botCarouselTemplateBuilder($columns)
        {
            foreach($columns as $column)
            {
                foreach($column['actions'] as $action)
                {
                    $options[] = new MessageTemplateActionBuilder(
                        $action['label'],
                        $action['text']
                    );
                }
                $template[] = new CarouselColumnTemplateBuilder(
                    $column['title'],
                    $column['text'],
                    $column['thumbnail'],$options
                );
                $options = [];
            }
            $input = new CarouselTemplateBuilder($template);
            return $input;
        }

}
