<?php

namespace App\Http\Controllers;

use App\TurnoExtraOxigenistas;
use Illuminate\Http\Request;
use DB;

class TurnoExtraOxigenistasController extends Controller
{
    public function get_turnoExtra(){
        $get_all = TurnoExtraOxigenistas::all();
        return $get_all;
    }
}
