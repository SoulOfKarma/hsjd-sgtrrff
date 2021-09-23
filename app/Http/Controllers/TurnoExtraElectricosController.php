<?php

namespace App\Http\Controllers;

use App\TurnoExtraElectricos;
use Illuminate\Http\Request;
use DB;

class TurnoExtraElectricosController extends Controller
{
    public function get_turnoExtra(){
        $get_all = TurnoExtraElectricos::all();
        return $get_all;
    }
}
