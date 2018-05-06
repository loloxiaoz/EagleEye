<?php
namespace App\Services\Push;

require_once(dirname(__FILE__).'/aliyun_push_sdk/mns-autoloader.php');
require_once(dirname(__FILE__).'/aliyun_push_sdk_lite/SignatureHelper.php');

use AliyunMNS\Client;
use AliyunMNS\Topic;
use AliyunMNS\Constants;
use AliyunMNS\Model\MailAttributes;
use AliyunMNS\Model\SmsAttributes;
use AliyunMNS\Model\BatchSmsAttributes;
use AliyunMNS\Model\MessageAttributes;
use AliyunMNS\Exception\MnsException;
use AliyunMNS\Requests\PublishMessageRequest;

use Aliyun\DySDKLite\SignatureHelper;

class AliYun
{
    public static function sendCompanyAlarm($company,$address)
    {
        $value["name"]      = $company;
        $value["address"]   = $address;
        return static::send(config("push.companyAlarmTo"),config("push.companySign"),config("push.companyAlarmCode"),$value);
    }

    public static function send($to, $sign, $code, $value) {

        $params = array ();

        // *** 需用户填写部分 ***

        // fixme 必填: 请参阅 https://ak-console.aliyun.com/ 取得您的AK信息
        $accessKeyId = config("push.accessId");
        $accessKeySecret = config("push.accessKey");

        // fixme 必填: 短信接收号码
        $params["PhoneNumbers"] = $to;

        // fixme 必填: 短信签名，应严格按"签名名称"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
        $params["SignName"] = $sign;

        // fixme 必填: 短信模板Code，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
        $params["TemplateCode"] = $code;

        // fixme 可选: 设置模板参数, 假如模板中存在变量需要替换则为必填项
        $params['TemplateParam'] = $value;

        // *** 需用户填写部分结束, 以下代码若无必要无需更改 ***
        if(!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
            $params["TemplateParam"] = json_encode($params["TemplateParam"], JSON_UNESCAPED_UNICODE);
        }

        // 初始化SignatureHelper实例用于设置参数，签名以及发送请求
        $helper = new SignatureHelper();

        // 此处可能会抛出异常，注意catch
        $content = $helper->request(
            $accessKeyId,
            $accessKeySecret,
            "dysmsapi.aliyuncs.com",
            array_merge($params, array(
                "RegionId" => "cn-hangzhou",
                "Action" => "SendSms",
                "Version" => "2017-05-25",
            ))
        );

        return $content;
    }
//    public static function send($to, $sign, $code, $value)
//    {
//        $client         = new Client(config("push.endPoint"), config("push.accessId"), config("push.accessKey"));
//        $topic          = $client->getTopicRef(config("push.topic"));
//        $batchSmsAttributes = new BatchSmsAttributes($sign, $code);
//        $batchSmsAttributes->addReceiver($to, $value);
//        $messageAttributes  = new MessageAttributes(array($batchSmsAttributes));
//        $messageBody    = "smsMessage";
//        $request        = new PublishMessageRequest($messageBody, $messageAttributes);
//        try
//        {
//            $res = $topic->publishMessage($request);
//            $data["result"] = $res->isSucceed();
//            $data["msgID"]  = $res->getMessageId();
//        }
//        catch (MnsException $e)
//        {
//            $data["result"] = "fail";
//            $data["msg"]    = $e->getMessage();
//        }
//        return  $data;
//    }
}
