<?php
namespace App\Services;

class LjlcParser
{
    public function __construct($content)
    {
        $this->content  = $content;
    }

    public function handle()
    {
        $pattern    = "/<span class=\"t2\">(.*?)i</span>/";
        preg_match($pattern,$content,$result);
        var_dump($result);
    }

}
