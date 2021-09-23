<?php

namespace App\Http\Controllers;

use App\TurnoExtraCalderas;
use Illuminate\Http\Request;
use DB;

class TurnoExtraCalderasController extends Controller
{
    public function get_turnoExtra(){
        $get_all = TurnoExtraCalderas::all();
        return $get_all;
    }
}
