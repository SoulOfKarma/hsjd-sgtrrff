<?php

namespace App\Http\Controllers;

use App\DiaAdministrativoOxigenistas;
use Illuminate\Http\Request;
use DB;

class DiaAdministrativoOxigenistasController extends Controller
{
    public function get_dia_adm(){
        $get_all = DiaAdministrativoOxigenistas::all();
        return $get_all;
    }
}
