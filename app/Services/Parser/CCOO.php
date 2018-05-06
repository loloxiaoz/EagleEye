<?php
namespace App\Services\Parser;

class CCOO
{
    public function __construct($content)
    {
        $this->content  = $content;
    }

    public function handle()
    {
        $data       = array();
        $this->content = str_replace("\n","",$this->content);
        $pattern    = "/class=\"zp-mc\">(.*?)<\/div>/";
        preg_match_all($pattern,$this->content,$result);
        if(count($result[1])){
            foreach($result[1] as $v){
                $data[]     = trim($v);
            }
        }
        return array_unique($data);
    }
}
