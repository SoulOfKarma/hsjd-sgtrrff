<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\DiaAdministrativoCTelefonicas;

class DiaAdministrativoCTelefonicaController extends Controller
{
    public function get_dia_adm(){
        $get_all = DiaAdministrativoCTelefonicas::all();
        return $get_all;
    }
}
