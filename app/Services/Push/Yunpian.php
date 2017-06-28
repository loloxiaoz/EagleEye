<?php

namespace App\Services\Push;
use App\Services\CurlHelper;

class YunPian
{
    public static function sendCompanyAlarm($content)
    {
        return static::send(config("companyAlarmTo"),config("companySign"),$content);
    }

    public static function send($to, $sign, $content)
    {
        $arg = [
            "apikey" => config("yunpianKey"),
            "text"   => $sign . $content,
            "mobile" => $to
        ];

        $svr = new CurlHelper();
        $res = $svr->request(config("yunpianUrl"),"post",$arg);
        return json_decode($res->body, true);
    }
}
