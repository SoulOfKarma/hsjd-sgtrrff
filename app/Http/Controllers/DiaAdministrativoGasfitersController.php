<?php

namespace App\Http\Controllers;

use App\DiaAdministrativoGasfiters;
use Illuminate\Http\Request;
use DB;

class DiaAdministrativoGasfitersController extends Controller
{
    public function get_dia_adm(){
        $get_all = DiaAdministrativoGasfiters::all();
        return $get_all;
    }
}
