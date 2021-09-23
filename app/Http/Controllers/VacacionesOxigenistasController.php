<?php

namespace App\Http\Controllers;

use App\VacacionesOxigenistas;
use Illuminate\Http\Request;
use DB;

class VacacionesOxigenistasController extends Controller
{
    public function get_vacaciones(){
        $get_all = VacacionesOxigenistas::all();
        return $get_all;
    }
}
