<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\TurnoExtraAscensores;

class TurnoExtraController extends Controller
{
    public function get_turnoExtra(){
        $get_all = TurnoExtraAscensores::all();
        return $get_all;
    }
}
