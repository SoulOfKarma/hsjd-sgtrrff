<?php

namespace App\Http\Controllers;

use App\ReemplazoGasfiters;
use Illuminate\Http\Request;
use DB;

class ReemplazoGasfitersController extends Controller
{
    public function get_reemplazo(){
        $get_all = ReemplazoGasfiters::all();
        return $get_all;
    }
}
