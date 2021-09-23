<?php

namespace App\Http\Controllers;

use App\TurnoExtraGasfiters;
use Illuminate\Http\Request;
USE DB;

class TurnoExtraGasfitersController extends Controller
{
    public function get_turnoExtra(){
        $get_all = TurnoExtraGasfiters::all();
        return $get_all;
    }
}
