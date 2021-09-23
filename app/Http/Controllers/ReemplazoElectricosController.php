<?php

namespace App\Http\Controllers;

use App\ReemplazoElectricos;
use Illuminate\Http\Request;
use DB;

class ReemplazoElectricosController extends Controller
{
    public function get_reemplazo(){
        $get_all = ReemplazoElectricos::all();
        return $get_all;
    }
}
