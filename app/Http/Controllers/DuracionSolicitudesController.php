<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\DuracionSolicitudes;

class DuracionSolicitudesController extends Controller
{
    public function getAll(){
        $get_all = DuracionSolicitudes::all();
        return $get_all;
    }
}
