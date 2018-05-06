<?php
namespace App\Services\Parser;

class CaiHao
{
    public function __construct($content)
    {
        $this->content  = $content;
    }

    public function handle()
    {
        $data       = array();
        $this->content = str_replace("\n","",$this->content);
        $pattern    = "/class=\"corp-name-colum\">(.*?)<\/li>/";
        preg_match_all($pattern,$this->content,$result);
        if(count($result[1])){
            $pattern    = "/target=\"_blank\">(.*?)<\/a>/";
            foreach($result[1] as $v){
                preg_match($pattern,$v,$ret);
                if(count($ret)){
                    $data[]     = trim($ret[1]);
                }
            }
        }
        return array_unique($data);
    }
}
