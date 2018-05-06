<?php
namespace App\Services\Parser;

class SZRC
{
    public function __construct($content)
    {
        $this->content  = $content;
    }

    public function handle()
    {
        $data       = array();
        $this->content = str_replace("\n","",$this->content);
        $pattern    = "/<td class=\"td_companyName\">(.*?)<\/td>/";
        preg_match_all($pattern,$this->content,$result);
        if(count($result[1])){
            foreach($result[1] as $v){
                $data[]     = trim($v);
            }
        }
        return array_unique($data);
    }
}
