<?php

namespace App\Http\Controllers;

use App\prioridadSolicitud;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;

class PrioridadSolicitudController extends Controller
{
    public function GetPrioridades(){
        try {
            $get_all = prioridadSolicitud::all();
            return $get_all;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
}
