<?php
namespace App\Services\Parser;

class Job51 
{
    public function __construct($content)
    {
        $this->content  = $content;
    }

    public function handle()
    {
        $data       = array();
        $this->content = str_replace("\n","",$this->content);
        $pattern    = "/<span class=\"t2\">(.*?)<\/span>/";
        preg_match_all($pattern,$this->content,$result);
        if(count($result[1])){
            $pattern    = "/title=\"(.*?)\" href/";
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
