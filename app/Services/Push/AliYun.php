<?php
namespace App\Services\Push;

require_once(dirname(__FILE__).'/aliyun_push_sdk/mns-autoloader.php');

use AliyunMNS\Client;
use AliyunMNS\Topic;
use AliyunMNS\Constants;
use AliyunMNS\Model\MailAttributes;
use AliyunMNS\Model\SmsAttributes;
use AliyunMNS\Model\BatchSmsAttributes;
use AliyunMNS\Model\MessageAttributes;
use AliyunMNS\Exception\MnsException;
use AliyunMNS\Requests\PublishMessageRequest;


class AliYun
{
    public static function sendCompanyAlarm($company,$address)
    {
        $value["name"]      = $company;
        $value["address"]   = $address;
//        $value["platform"]  = $platform;
        return static::send(config("push.companyAlarmTo"),config("push.companySign"),config("push.companyAlarmCode"),$value);
    }

    public static function send($to, $sign, $code, $value)
    {
        $client         = new Client(config("push.endPoint"), config("push.accessId"), config("push.accessKey"));
        $topic          = $client->getTopicRef(config("push.topic"));
        $batchSmsAttributes = new BatchSmsAttributes($sign, $code);
        $batchSmsAttributes->addReceiver($to, $value);
        $messageAttributes  = new MessageAttributes(array($batchSmsAttributes));
        $messageBody    = "smsMessage";
        $request        = new PublishMessageRequest($messageBody, $messageAttributes);
        try
        {
            $res = $topic->publishMessage($request);
            $data["result"] = $res->isSucceed();
            $data["msgID"]  = $res->getMessageId();
        }
        catch (MnsException $e)
        {
            $data["result"] = "fail";
            $data["msg"]    = $e->getMessage();
        }
        return  $data;
    }
}
