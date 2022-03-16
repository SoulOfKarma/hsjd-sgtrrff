<?php

namespace App\Http\Controllers;

use App\TurnoExtratindustrials;
use Illuminate\Http\Request;

class TurnoExtratindustrialsController extends Controller
{
    public function get_turnoExtra(){
        $get_all = TurnoExtratindustrials::all();
        return $get_all;
    }
}
