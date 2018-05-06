<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\CurlHelper;
use App\Services\Parser\Job51;
use App\Services\Push\AliYun;
use App\Snapshot;
use Log;

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

    private function save($data,$tag)
    {
        foreach($data as $v){
            $ret    = Snapshot::where("keyword",$v)->count();
            if(!$ret){
                $snapShot = new Snapshot;
                $snapShot->url          = $tag;
                $snapShot->ymd          = Date("Y-m-d");
                $snapShot->keyword      = $v;
                $snapShot->content      = $v;
                $snapShot->created_at   = time();
                $snapShot->save();
                $ret = AliYun::sendCompanyAlarm($v,$tag);
                var_dump($ret);
            }
        }
    }

    private function handleTarget($target)
    {
        $this->curlHelper->setHeader($target["header"]);
        $this->curlHelper->setUserAgent($target["userAgent"]);
        $content    = $this->curlHelper->request($target["url"]);
        $content    = $this->curlHelper->translate($content);
        $parserName = $target["name"];
        $parser     = new $parserName($content);
        $data       = $parser->handle();
        $this->save($data,$target["tag"]);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        echo Date("Y-m-d H:i:s")."\n";
        foreach($this->config as $target){
            try{
                $this->handleTarget($target);
            }catch(\Exception $e){
                Log::error('获取数据失败'.$target["tag"]);
            }
        }
    }
}
