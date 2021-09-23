<?php

namespace App\Http\Controllers;

use App\ReemplazoOxigenistas;
use Illuminate\Http\Request;
use DB;

class ReemplazoOxigenistasController extends Controller
{
    public function get_reemplazo(){
        $get_all = ReemplazoOxigenistas::all();
        return $get_all;
    }
}
