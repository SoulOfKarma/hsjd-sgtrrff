<?php

namespace App\Http\Controllers;

use App\mantencionProgramadas;
use App\estadoMantenciones;
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
            $codManEne = $request->codManEne;
            $codManFeb = $request->codManFeb;
            $codManMar = $request->codManMar;
            $codManAbr = $request->codManAbr;
            $codManMay = $request->codManMay;
            $codManJun = $request->codManJun;
            $codManJul = $request->codManJul;
            $codManAgo = $request->codManAgo;
            $codManSep = $request->codManSep;
            $codManOct = $request->codManOct;
            $codManNov = $request->codManNov;
            $codManDic = $request->codManDic;
            $estadoMantenciones = [];
            $response = mantencionProgramadas::create($request->all());
            if($codManEne > 0){
                $estadoMantenciones = new estadoMantenciones;
                $estadoMantenciones->id_mantencionIND = $response->id;
                $estadoMantenciones->codMan = $codManEne;
                $estadoMantenciones->idEstadoManI = $request->idEstadoManI;
                $estadoMantenciones->save();
            }
             if($codManFeb > 0){
                $estadoMantenciones = new estadoMantenciones;
                $estadoMantenciones->id_mantencionIND = $response->id;
                $estadoMantenciones->codMan = $codManFeb;
                $estadoMantenciones->idEstadoManI = $request->idEstadoManI;
                $estadoMantenciones->save();
            } 
            if($codManMar > 0){
                $estadoMantenciones = new estadoMantenciones;
                $estadoMantenciones->id_mantencionIND = $response->id;
                $estadoMantenciones->codMan = $codManMar;
                $estadoMantenciones->idEstadoManI = $request->idEstadoManI;
                $estadoMantenciones->save();
            } if($codManAbr > 0){
                $estadoMantenciones = new estadoMantenciones;
                $estadoMantenciones->id_mantencionIND = $response->id;
                $estadoMantenciones->codMan = $codManAbr;
                $estadoMantenciones->idEstadoManI = $request->idEstadoManI;
                $estadoMantenciones->save();
            } if($codManMay > 0){
                $estadoMantenciones = new estadoMantenciones;
                $estadoMantenciones->id_mantencionIND = $response->id;
                $estadoMantenciones->codMan = $codManMay;
                $estadoMantenciones->idEstadoManI = $request->idEstadoManI;
                $estadoMantenciones->save();
            } if($codManJun > 0){
                $estadoMantenciones = new estadoMantenciones;
                $estadoMantenciones->id_mantencionIND = $response->id;
                $estadoMantenciones->codMan = $codManJun;
                $estadoMantenciones->idEstadoManI = $request->idEstadoManI;
                $estadoMantenciones->save();
            } if($codManJul > 0){
                $estadoMantenciones = new estadoMantenciones;
                $estadoMantenciones->id_mantencionIND = $response->id;
                $estadoMantenciones->codMan = $codManJul;
                $estadoMantenciones->idEstadoManI = $request->idEstadoManI;
                $estadoMantenciones->save();
            } if($codManAgo > 0){
                $estadoMantenciones = new estadoMantenciones;
                $estadoMantenciones->id_mantencionIND = $response->id;
                $estadoMantenciones->codMan = $codManAgo;
                $estadoMantenciones->idEstadoManI = $request->idEstadoManI;
                $estadoMantenciones->save();
            } if($codManSep > 0){
                $estadoMantenciones = new estadoMantenciones;
                $estadoMantenciones->id_mantencionIND = $response->id;
                $estadoMantenciones->codMan = $codManSep;
                $estadoMantenciones->idEstadoManI = $request->idEstadoManI;
                $estadoMantenciones->save();
            } if($codManOct > 0){
                $estadoMantenciones = new estadoMantenciones;
                $estadoMantenciones->id_mantencionIND = $response->id;
                $estadoMantenciones->codMan = $codManOct;
                $estadoMantenciones->idEstadoManI = $request->idEstadoManI;
                $estadoMantenciones->save();
            } if($codManNov > 0){
                $estadoMantenciones = new estadoMantenciones;
                $estadoMantenciones->id_mantencionIND = $response->id;
                $estadoMantenciones->codMan = $codManNov;
                $estadoMantenciones->idEstadoManI = $request->idEstadoManI;
                $estadoMantenciones->save();
            } if($codManDic > 0){
                $estadoMantenciones = new estadoMantenciones;
                $estadoMantenciones->id_mantencionIND = $response->id;
                $estadoMantenciones->codMan = $codManDic;
                $estadoMantenciones->idEstadoManI = $request->idEstadoManI;
                $estadoMantenciones->save();
            } 
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
           return true;
       } catch (\Throwable $th) {
           log::info($th);
           return false;
       }
    }

    public function getTicketsKPI(){
        try {
            $get_all = estadoMantenciones::select('estado_cod_m_industriales.descripcion_estadoI as orderType',
            DB::raw("(CASE WHEN estado_mantenciones.idEstadoManI = 1 THEN COUNT(estado_mantenciones.idEstadoManI)
                          WHEN estado_mantenciones.idEstadoManI = 2 THEN COUNT(estado_mantenciones.idEstadoManI)
                          WHEN estado_mantenciones.idEstadoManI = 3 THEN COUNT(estado_mantenciones.idEstadoManI)
                          WHEN estado_mantenciones.idEstadoManI = 4 THEN COUNT(estado_mantenciones.idEstadoManI)
                          END) AS counts"),
            DB::raw("(CASE WHEN estado_mantenciones.idEstadoManI = 1 THEN 'primary'
                          WHEN estado_mantenciones.idEstadoManI = 2 THEN 'warning'
                          WHEN estado_mantenciones.idEstadoManI = 3 THEN 'danger'
                          WHEN estado_mantenciones.idEstadoManI = 4 THEN 'success'
                          END) AS color"),
            DB::raw("(CASE WHEN estado_mantenciones.idEstadoManI = 1 THEN '#7961F9'
                          WHEN estado_mantenciones.idEstadoManI = 2 THEN '#FF9F43'
                          WHEN estado_mantenciones.idEstadoManI = 3 THEN '#EA5455'
                          WHEN estado_mantenciones.idEstadoManI = 4 THEN '#1fcd39'
                          END) AS codcolor"),        
            DB::raw("(CASE WHEN estado_mantenciones.idEstadoManI = 1 THEN '#9c8cfc'
                          WHEN estado_mantenciones.idEstadoManI = 2 THEN '#FFC085'
                          WHEN estado_mantenciones.idEstadoManI = 3 THEN '#f29292'
                          WHEN estado_mantenciones.idEstadoManI = 4 THEN '#1fcd39'
                          END) AS gradcolor"),                    
            DB::raw("(CASE WHEN estado_mantenciones.idEstadoManI = 1 THEN COALESCE(ROUND(((SELECT COUNT(idEstadoManI) FROM estado_mantenciones WHERE idEstadoManI = 1)*100)/(SELECT COUNT(idEstadoManI) FROM estado_mantenciones),1),0)
            WHEN estado_mantenciones.idEstadoManI = 2 THEN COALESCE(ROUND(((SELECT COUNT(idEstadoManI) FROM estado_mantenciones WHERE idEstadoManI = 2)*100)/(SELECT COUNT(idEstadoManI) FROM estado_mantenciones),1),0)
            WHEN estado_mantenciones.idEstadoManI = 3 THEN COALESCE(ROUND(((SELECT COUNT(idEstadoManI) FROM estado_mantenciones WHERE idEstadoManI = 3)*100)/(SELECT COUNT(idEstadoManI) FROM estado_mantenciones),1),0)
            WHEN estado_mantenciones.idEstadoManI = 4 THEN ROUND(((SELECT COUNT(idEstadoManI) FROM estado_mantenciones WHERE idEstadoManI = 4)*100)/(SELECT COUNT(idEstadoManI) FROM estado_mantenciones),1)
            END) AS porcentaje"))
            ->join('estado_cod_m_industriales','estado_mantenciones.idEstadoManI','=','estado_cod_m_industriales.id')
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
