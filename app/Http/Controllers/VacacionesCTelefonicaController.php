<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\VacacionesCTelefonicas;

class VacacionesCTelefonicaController extends Controller
{
    public function get_vacaciones(){
        $get_all = VacacionesCTelefonicas::all();
        return $get_all;
    }
}
