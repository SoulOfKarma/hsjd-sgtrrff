<?php

namespace App\Http\Controllers;

use App\DetalleSolicitudEMs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use DB;

class DetalleSolicitudEMsController extends Controller
{
   public function GetDetallesEquipoMedico(Request $request){
       try {
           $get_all = DetalleSolicitudEMs::select('detalle_solicitud_e_ms.desresolucionresultados','detalle_solicitud_e_ms.desobservaciones')
           ->where('detalle_solicitud_e_ms.id_solicitud',$request->id)
           ->get();

           return $get_all;
       } catch (\Throwable $th) {
           log::info($th);
           return false;
       }
   }
}
