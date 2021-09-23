<?php

namespace App\Http\Controllers;

use App\VacacionesElectricos;
use Illuminate\Http\Request;
use DB;

class VacacionesElectricosController extends Controller
{
    public function get_vacaciones(){
        $get_all = VacacionesElectricos::all();
        return $get_all;
    }
}
