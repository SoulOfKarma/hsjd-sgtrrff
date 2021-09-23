<?php

namespace App\Http\Controllers;

use App\DiaAdministrativoCalderas;
use Illuminate\Http\Request;
use DB;

class DiaAdministrativoCalderasController extends Controller
{
    public function get_dia_adm(){
        $get_all = DiaAdministrativoCalderas::all();
        return $get_all;
    }
}
