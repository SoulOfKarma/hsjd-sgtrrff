<?php

namespace App\Http\Controllers;

use App\mantencionProgramadas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use DB;

class MantencionProgramadasController extends Controller
{
    public function GetListadoMantencion(Request $request){
        try {
            $get_all = mantencionProgramadas::select('mantencion_programadas.*','tipo_mantenciones.descripcionTMantencion','edificios.descripcionEdificio')
            ->join('tipo_mantenciones','mantencion_programadas.id_tmantencion','=','tipo_mantenciones.id')
            ->join('edificios','mantencion_programadas.id_edificio','=','edificios.id')
            ->where('mantencion_programadas.id_anio', $request->id_anio)
            ->get();
            return $get_all;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PostCalMantencionI(Request $request){
        try {
            mantencionProgramadas::create($request->all());
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PostCodMantencionN(Request $request){
       try {
           mantencionProgramadas::where('id',$request->id)
           ->update([$request->codMan => $request->codMantencionNuevo]);
       } catch (\Throwable $th) {
           log::info($th);
           return false;
       }
    }
}
