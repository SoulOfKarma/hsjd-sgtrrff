<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\DiaAdministrativoAscensores;

class DiaAdministrativoController extends Controller
{
    public function get_dia_adm(){
        $get_all = DiaAdministrativoAscensores::all();
        return $get_all;
    }
}
