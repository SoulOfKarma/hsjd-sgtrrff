<?php

namespace App\Http\Controllers;

use App\DiaAdministrativoElectricos;
use Illuminate\Http\Request;
use DB;

class DiaAdministrativoElectricosController extends Controller
{
    public function get_dia_adm(){
        $get_all = DiaAdministrativoElectricos::all();
        return $get_all;
    }
}
