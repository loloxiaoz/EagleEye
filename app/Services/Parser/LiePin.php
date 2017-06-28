<?php
namespace App\Services\Parser;

class LiePin
{
    public function __construct($content)
    {
        $this->content  = $content;
    }

    public function handle()
    {
        $data       = array();
        $this->content = str_replace("\n","",$this->content);
        $pattern    = "/<p class=\"company-name\">(.*?)<\/p>/";
        preg_match_all($pattern,$this->content,$result);
        if(count($result[1])){
            $pattern    = "/>(.*?)<\/a>/";
            foreach($result[1] as $v){
                preg_match($pattern,$v,$ret);
                if(count($ret)){
                    $data[]     = $ret[1];
                }
            }
        }
        return $data;
    }
}
