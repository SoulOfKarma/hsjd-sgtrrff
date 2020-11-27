<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\TurnoExtraCTelefonicas;

class TurnoExtraCTelefonicaController extends Controller
{
    public function get_turnoExtra(){
        $get_all = TurnoExtraCTelefonicas::all();
        return $get_all;
    }
}
