<?php

namespace App\Http\Controllers;

use App\ReemplazoCalderas;
use Illuminate\Http\Request;
use DB;

class ReemplazoCalderasController extends Controller
{
    public function get_reemplazo(){
        $get_all = ReemplazoCalderas::all();
        return $get_all;
    }
}
