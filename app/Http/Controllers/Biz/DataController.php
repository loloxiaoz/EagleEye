<?php

namespace App\Http\Controllers\Biz;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DataController extends Controller
{
    public function get()
    {
        $data   = DB::table('snapshot')->get();
        return $data;
    }

    public function insert()
    {
        $data   = DB::table('snapshot')->insert([
            ['url'=>1,'ymd'=>2,'keyword'=>3,'content'=>4],
        ]);
        return array("ok");
    }

}
