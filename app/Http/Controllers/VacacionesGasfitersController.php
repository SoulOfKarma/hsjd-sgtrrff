<?php

namespace App\Http\Controllers;

use App\VacacionesGasfiters;
use Illuminate\Http\Request;
use DB;

class VacacionesGasfitersController extends Controller
{
    public function get_vacaciones(){
        $get_all = VacacionesGasfiters::all();
        return $get_all;
    }
}
