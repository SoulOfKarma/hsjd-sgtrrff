<?php

namespace App\Http\Controllers;

use App\mantencion_ap_programadas;
use App\estado_ap_mantenciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use DB;

class MantencionApProgramadasController extends Controller
{
    public function GetListadoMantencion(Request $request){
        try {
            $get_all = mantencion_ap_programadas::select('mantencion_ap_programadas.*','tipo_mantenciones.descripcionTMantencion','edificios.descripcionEdificio')
            ->join('tipo_mantenciones','mantencion_ap_programadas.id_tmantencion','=','tipo_mantenciones.id')
            ->join('edificios','mantencion_ap_programadas.id_edificio','=','edificios.id')
            ->where('mantencion_ap_programadas.id_anio', $request->id_anio)
            ->get();
            return $get_all;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function GetListadoEstRes(Request $request){
        try {
            $get_all = mantencion_ap_programadas::select('estado_cod_m_industriales.descripcion_estadoI',"estado_ap_mantenciones.codMan","estado_ap_mantenciones.codManMes",DB::raw('CONCAT(trabajadores.tra_nombre," ",trabajadores.tra_apellido) AS tra_nom_ape'))
            ->join('estado_ap_mantenciones','mantencion_ap_programadas.id','=','estado_ap_mantenciones.id_mantencionAP')
            ->join('estado_cod_m_industriales','estado_ap_mantenciones.idEstadoManAP','=','estado_cod_m_industriales.id')
            ->join('responsable_ap_mantenciones','mantencion_ap_programadas.id','=','responsable_ap_mantenciones.id_mantencion_ap')
            ->join('trabajadores','responsable_ap_mantenciones.id_trabajador','=','trabajadores.id')
            ->where('estado_ap_mantenciones.codMan', $request->id)
            ->get();
            log::info($get_all);
            return $get_all;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PostEstadoM(Request $request){
        try {
             $data = estado_ap_mantenciones::where('codMan', $request->CodMantencionN)
             ->get();
             $dataCount = count($data);

             if($dataCount > 0){
                estado_ap_mantenciones::where('codMan', $request->CodMantencionN)
                ->update(
                   ['id_mantencionAP' => $request->id, 'codMan' => $request->CodMantencionN,
                   'idEstadoManAP' => $request->idEstado, 'codManMes' => $request->codManMes]
                );
             }else{
                $estadoMantenciones = new estado_ap_mantenciones;
                $estadoMantenciones->id_mantencionAP = $request->id;
                $estadoMantenciones->codMan = $request->CodMantencionN;
                $estadoMantenciones->idEstadoManAP = $request->idEstado;
                $estadoMantenciones->codManMes = $request->codManMes;
                $estadoMantenciones->save();
             }
             
             
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PostCalMantencionI(Request $request){
        try {
            $response = mantencion_ap_programadas::create($request->all());
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PostCodMantencionN(Request $request){
       try {
        mantencion_ap_programadas::where('id',$request->id)
           ->update([$request->codMan => $request->codMantencionNuevo]);
           return true;
       } catch (\Throwable $th) {
           log::info($th);
           return false;
       }
    }

    public function GetListadoEspecifico(Request $request){
        try {
            $get_all = mantencion_ap_programadas::where('id',$request->id)
            ->get();
            return $get_all;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PutModificarCodigoM(Request $request){
       try {
        mantencion_ap_programadas::where('id',$request->id)
           ->update([$request->codManEspecificoMod => $request->codManModificar]);
           return true;
       } catch (\Throwable $th) {
           log::info($th);
           return false;
       } 
    }

    public function PostDeleteMantencion(Request $request){
        try {
            $res = mantencion_ap_programadas::where('id',$request->id)->delete();
            if($res){
                return true;
            }
        } catch (\Throwable $th) {
            log::info($th);
           return false;
        }
    }

    public function getTicketsKPI(){
        try {
            $get_all = estado_ap_mantenciones::select('estado_cod_m_industriales.descripcion_estadoI as orderType',
            DB::raw("(CASE WHEN estado_ap_mantenciones.idEstadoManAP = 1 THEN COUNT(estado_ap_mantenciones.idEstadoManAP)
                          WHEN estado_ap_mantenciones.idEstadoManAP = 2 THEN COUNT(estado_ap_mantenciones.idEstadoManAP)
                          WHEN estado_ap_mantenciones.idEstadoManAP = 3 THEN COUNT(estado_ap_mantenciones.idEstadoManAP)
                          WHEN estado_ap_mantenciones.idEstadoManAP = 4 THEN COUNT(estado_ap_mantenciones.idEstadoManAP)
                          END) AS counts"),
            DB::raw("(CASE WHEN estado_ap_mantenciones.idEstadoManAP = 1 THEN 'primary'
                          WHEN estado_ap_mantenciones.idEstadoManAP = 2 THEN 'warning'
                          WHEN estado_ap_mantenciones.idEstadoManAP = 3 THEN 'danger'
                          WHEN estado_ap_mantenciones.idEstadoManAP = 4 THEN 'success'
                          END) AS color"),
            DB::raw("(CASE WHEN estado_ap_mantenciones.idEstadoManAP = 1 THEN '#7961F9'
                          WHEN estado_ap_mantenciones.idEstadoManAP = 2 THEN '#FF9F43'
                          WHEN estado_ap_mantenciones.idEstadoManAP = 3 THEN '#EA5455'
                          WHEN estado_ap_mantenciones.idEstadoManAP = 4 THEN '#1fcd39'
                          END) AS codcolor"),        
            DB::raw("(CASE WHEN estado_ap_mantenciones.idEstadoManAP = 1 THEN '#9c8cfc'
                          WHEN estado_ap_mantenciones.idEstadoManAP = 2 THEN '#FFC085'
                          WHEN estado_ap_mantenciones.idEstadoManAP = 3 THEN '#f29292'
                          WHEN estado_ap_mantenciones.idEstadoManAP = 4 THEN '#1fcd39'
                          END) AS gradcolor"),                    
            DB::raw("(CASE WHEN estado_ap_mantenciones.idEstadoManAP = 1 THEN COALESCE(ROUND(((SELECT COUNT(idEstadoManAP) FROM estado_ap_mantenciones WHERE idEstadoManAP = 1)*100)/(SELECT COUNT(idEstadoManAP) FROM estado_ap_mantenciones),1),0)
            WHEN estado_ap_mantenciones.idEstadoManAP = 2 THEN COALESCE(ROUND(((SELECT COUNT(idEstadoManAP) FROM estado_ap_mantenciones WHERE idEstadoManAP = 2)*100)/(SELECT COUNT(idEstadoManAP) FROM estado_ap_mantenciones),1),0)
            WHEN estado_ap_mantenciones.idEstadoManAP = 3 THEN COALESCE(ROUND(((SELECT COUNT(idEstadoManAP) FROM estado_ap_mantenciones WHERE idEstadoManAP = 3)*100)/(SELECT COUNT(idEstadoManAP) FROM estado_ap_mantenciones),1),0)
            WHEN estado_ap_mantenciones.idEstadoManAP = 4 THEN ROUND(((SELECT COUNT(idEstadoManAP) FROM estado_ap_mantenciones WHERE idEstadoManAP = 4)*100)/(SELECT COUNT(idEstadoManAP) FROM estado_ap_mantenciones),1)
            END) AS porcentaje"))
            ->join('estado_cod_m_industriales','estado_ap_mantenciones.idEstadoManAP','=','estado_cod_m_industriales.id')
            ->groupby('estado_cod_m_industriales.id')
            ->get();
            //log::info($get_all);
            return $get_all;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
}
