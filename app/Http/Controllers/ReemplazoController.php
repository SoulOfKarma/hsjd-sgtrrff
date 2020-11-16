<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\ReemplazoAscensores;

class ReemplazoController extends Controller
{
    public function get_reemplazo(){
        $get_all = ReemplazoAscensores::all();
        return $get_all;
    }
}
