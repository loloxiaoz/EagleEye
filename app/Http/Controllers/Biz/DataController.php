<?php

namespace App\Http\Controllers\Biz;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Snapshot;

class DataController extends Controller
{
    public function get(Request $request)
    {
        $website    = $request->website;
        $beginYmd   = Date("Y-m-d",strtotime($request->beginTime));
        $endYmd     = Date("Y-m-d",strtotime($request->endTime));
        if(!empty($website)){
            return SnapShot::where("url",$website)->where("ymd",">=",$beginYmd)->where("ymd","<=",$endYmd)->orderBy('ymd','desc')->get(); 
        }else{
            return SnapShot::where("ymd",">=",$beginYmd)->where("ymd","<=",$endYmd)->orderBy('ymd','desc')->get(); 
        }
    }

    public function insert()
    {
        $data   = DB::table('snapshot')->insert([
            ['url'=>1,'ymd'=>2,'keyword'=>3,'content'=>4],
        ]);
        return array("ok");
    }

}
