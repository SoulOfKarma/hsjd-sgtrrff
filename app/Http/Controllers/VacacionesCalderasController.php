<?php

namespace App\Http\Controllers;

use App\VacacionesCalderas;
use Illuminate\Http\Request;
use DB;

class VacacionesCalderasController extends Controller
{
    public function get_vacaciones(){
        $get_all = VacacionesCalderas::all();
        return $get_all;
    }
}
