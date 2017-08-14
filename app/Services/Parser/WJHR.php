<?php
namespace App\Services\Parser;

class WJHR 
{
    public function __construct($content)
    {
        $this->content  = $content;
    }

    public function handle()
    {
        $data       = array();
        $this->content = str_replace("\n","",$this->content);
        $pattern    = "/<div id=\"sreachjg\">(.*?)<\/div>/";
        preg_match_all($pattern,$this->content,$result);
        if(count($result[1])){
            $pattern    = "/<span style=\"color: #1767ab; font-weight: bold\">(.*?)<\/span>/";
            foreach($result[1] as $v){
                preg_match($pattern,$v,$ret);
                if(count($ret)){
                    $data[]     = trim($ret[1]);
                }
            }
        }
        return $data;
    }
}
