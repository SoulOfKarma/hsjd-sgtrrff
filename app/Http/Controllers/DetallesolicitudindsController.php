<?php

namespace App\Http\Controllers;

use App\detallesolicitudinds;
use Illuminate\Http\Request;

class DetallesolicitudindsController extends Controller
{
    public function GetDetallesSIndustrial(Request $request){
        try {
            $get_all = detallesolicitudinds::select('detallesolicitudinds.desresolucionresultados')
            ->where('detallesolicitudinds.id_solicitud',$request->id)
            ->get();
 
            return $get_all;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
}
