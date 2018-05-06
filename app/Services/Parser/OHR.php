<?php
namespace App\Services\Parser;

class OHR
{
    public function __construct($content)
    {
        $this->content  = $content;
    }

    public function handle()
    {
        $data       = array();
        $this->content = str_replace("\n","",$this->content);
        $pattern    = "/<div class=\"info_td com_name\">(.*?)<\/div>/";
        preg_match_all($pattern,$this->content,$result);
        if(count($result[1])){
            $pattern    = "/title=\"(.*?)\" /";
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