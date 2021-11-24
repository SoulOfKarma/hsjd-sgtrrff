<?php

namespace App\Http\Controllers;

use App\responsable_ap_mantenciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use DB;

class ResponsableApMantencionesController extends Controller
{
    public function PostResponsableAP(Request $request){
        try {
            $data = responsable_ap_mantenciones::where('codMan', $request->CodMantencionN)
            ->get();
            $dataCount = count($data);

            if($dataCount > 0){
                responsable_ap_mantenciones::where('codMan', $request->CodMantencionN)
               ->update(
                  ['id_mantencion_ap' => $request->id, 'codMan' => $request->CodMantencionN,
                  'id_trabajador' => $request->id_trabajador, 'codManMes' => $request->codManMes]
               );
            }else{
               $estadoMantenciones = new responsable_ap_mantenciones;
               $estadoMantenciones->id_mantencion_ap = $request->id;
               $estadoMantenciones->codMan = $request->CodMantencionN;
               $estadoMantenciones->id_trabajador = $request->id_trabajador;
               $estadoMantenciones->codManMes = $request->codManMes;
               $estadoMantenciones->save();
            }
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
}
