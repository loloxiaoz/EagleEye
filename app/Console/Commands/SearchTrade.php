<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\CurlHelper as CurlHelper;

class SearchTrade extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:trade';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'search wujiang trade company';

    public function __construct()
    {
       $this->curlHelper = new CurlHelper;
       $this->config     = json_decode(file_get_contents($_SERVER["PWD"]."/app/Console/Commands/targets.json"),true);
       parent::__construct();
    }

    private function handleTarget($target)
    {
        $this->curlHelper->setHeader($target["header"]);
        $this->curlHelper->setUserAgent($target["userAgent"]);
        $content    = $this->curlHelper->request($target["url"]);
        $content    = $this->curlHelper->translate($content);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach($this->config as $target){
            try{
            $this->handleTarget($target);
            }catch(Exception $e){
                
            }
        }
    }
}
