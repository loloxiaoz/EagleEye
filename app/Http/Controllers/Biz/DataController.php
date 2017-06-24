<?php

namespace App\Http\Controllers\Biz;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Snapshot;

class DataController extends Controller
{
    public function get()
    {
        return $data   =SnapShot::all(); 
    }

    public function insert()
    {
        $data   = DB::table('snapshot')->insert([
            ['url'=>1,'ymd'=>2,'keyword'=>3,'content'=>4],
        ]);
        return array("ok");
    }

}
