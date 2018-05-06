<?php

namespace App\Services;
use \RuntimeException;

class CurlHelper
{
    private static $retriableErrorCodes = array(
        CURLE_COULDNT_RESOLVE_HOST,
        CURLE_COULDNT_CONNECT,
        CURLE_HTTP_NOT_FOUND,
        CURLE_READ_ERROR,
        CURLE_OPERATION_TIMEOUTED,
        CURLE_HTTP_POST_ERROR,
        CURLE_SSL_CONNECT_ERROR,
    );

    /**
     * cookie
     *
     */
    protected $cookie  = '';

    /**
     * userAgent
     *
     */
    protected $userAgent= '';


    public function __construct()
    {
        $this->ch = curl_init();
    }

    public function setUserAgent($userAgent)
    {
        $this->userAgent = $userAgent;
    }

    public function setCookie($cookie)
    {
        $this->cookie = $cookie;
    }

    public function setHeader($header)
    {
        $this->header = $header;
    }
 
    public function restore()
    {
        $this->userAgent = '';
        $this->cookie    = '';
    }

    /**
     * [request 执行curl请求]
     * @param  [string] $method   请求方法
     * @param  [string] $url      请求的URL
     * @param  array  $fields     执行POST请求时的数据
     * @return [stirng]           请求结果
     */
    public function request($url, $method='GET', $fields = array())
    {
        curl_setopt($this->ch, CURLOPT_URL, $url);
        if(!empty($this->header)){
            curl_setopt($this->ch, CURLOPT_HTTPHEADER, $this->header);
        }
        if(!empty($this->cookie)){
            curl_setopt($this->ch, CURLOPT_COOKIE, $this->cookie);
        }
        if(!empty($this->userAgent)){
            curl_setopt($this->ch, CURLOPT_USERAGENT, $this->userAgent);
        }
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($this->ch, CURLOPT_TIMEOUT, 10);
        if ($method === 'POST')
        {
            curl_setopt($this->ch, CURLOPT_POST, true );
            curl_setopt($this->ch, CURLOPT_POSTFIELDS, $fields);
        }
        return $this->execute($this->ch);
    }

    public function execute($ch, $retries = 5, $closeAfterDone = true)
    {
        while ($retries--) {
            $ret    = curl_exec($ch);
            if ($closeAfterDone) {
                curl_close($ch);
            }
            if ($ret === false) {
                $curlErrno = curl_errno($ch);
                if (false === in_array($curlErrno, self::$retriableErrorCodes, true) || !$retries) {
                    $curlError = curl_error($ch);
                    if ($closeAfterDone) {
                        curl_close($ch);
                    }
                    throw new \RuntimeException(sprintf('Curl error (code %s): %s', $curlErrno, $curlError));
                }
            }else{
                return $ret;
            }
        }
    }

    public function translate($content,$toEncode="UTF-8")
    {
        $fromEncode    = $this->extractEncode($content);
        if(empty($fromEncode)||stristr($fromEncode, "UTF")){
            return $content;
        }else{
            return mb_convert_encoding($content,$toEncode,$fromEncode);;
        }
    }

    public function extractEncode($content)
    {
        $regx = "/charset=(.*?)\"/";
        preg_match($regx,$content,$result);
        if(count($result)){
            $encode = ltrim($result[1], "\"");
            return $encode;
        }else{
            return '';
        }
    }
}
