<?php

namespace App\Http\Controllers;

use App\DiaAdministrativoTIndustrials;
use Illuminate\Http\Request;

class DiaAdministrativoTIndustrialsController extends Controller
{
    public function get_dia_adm(){
        $get_all = DiaAdministrativoTIndustrials::all();
        return $get_all;
    }
}
