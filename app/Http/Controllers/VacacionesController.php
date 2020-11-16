<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\VacacionesAscensores;

class VacacionesController extends Controller
{
    public function get_vacaciones(){
        $get_all = VacacionesAscensores::all();
        return $get_all;
    }
}
