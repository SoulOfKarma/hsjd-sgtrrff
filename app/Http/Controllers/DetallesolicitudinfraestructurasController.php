<?php

namespace App\Http\Controllers;

use App\detallesolicitudinfraestructuras;
use Illuminate\Http\Request;

class DetallesolicitudinfraestructurasController extends Controller
{
    public function GetDetallesInfraestructura(Request $request){
        try {
            $get_all = detallesolicitudinfraestructuras::select('detallesolicitudinfraestructuras.desresolucionresultados')
            ->where('detallesolicitudinfraestructuras.id_solicitud',$request->id)
            ->get();
 
            return $get_all;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
}
