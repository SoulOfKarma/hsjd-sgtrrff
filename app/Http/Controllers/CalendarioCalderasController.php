<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;
use App\trabajadores;
use App\CalendarioCalderas;
use App\DiaAdministrativoCalderas;
use App\ReemplazoCalderas;
use App\TurnoExtraCalderas;
use App\VacacionesCalderas;

class CalendarioCalderasController extends Controller
{
    public function getTodoCalendario()
    {
        $getall = CalendarioCalderas::all();
        return $getall;
    }

    public function postNuevoTCalendario(Request $request){
        $res = CalendarioCalderas::create($request->all());

        return $res;
    }

    public function PutNuevoTCalendario(Request $request){
        try {
             
            $idAdministrativo = $request->id_val_dia_administrativo;
            $idVacaciones = $request->id_val_vacaciones;
            $idReemplazo = $request->id_val_reemplazo;
            $idTurnoExtra = $request->id_val_turno_extra;
            $idCalendario = $request->id_calendario_calderas;
            $classesL = $request->classes;

            if($idAdministrativo == 1){
                
                $get_All = DiaAdministrativoCalderas::UpdateOrCreate(['id_calendario_calderas' => $request->id_calendario_calderas,'id_tipo_dia_administrativo' => $request->id_tipo_dia_administrativo,'fecha_dia_administrativo' => $request->fecha_dia_administrativo,
                 'estado_dia_administrativo' => $request->estado_dia_administrativo]);
            }
            if($idVacaciones == 1 ){
                VacacionesCalderas::UpdateOrCreate(['id_calendario_calderas' => $request->id_calendario_calderas,'fecha_inicio_vacaciones'=> $request->fecha_inicio_vacaciones,'fecha_termino_vacaciones' => $request->fecha_termino_vacaciones,
                 'dias_vacaciones' => $request->dias_vacaciones, 'estado_vacaciones' => $request->estado_vacaciones]);
            }
            if($idReemplazo == 1){
                ReemplazoCalderas::UpdateOrCreate(['id_calendario_calderas' => $request->id_calendario_calderas,'id_trabajador_reemplazo' => $request->id_trabajador_reemplazo,'fecha_inicio_reemplazo' => $request->fecha_inicio_reemplazo,
                'fecha_termino_reemplazo' => $request->fecha_termino_reemplazo,'dias_reemplazo' => $request->dias_reemplazo,'estado_reemplazo' => $request->estado_reemplazo]);
            }
            if($idTurnoExtra == 1){
                TurnoExtraCalderas::UpdateOrCreate(['id_calendario_calderas' => $request->id_calendario_calderas,'hora_inicio_turno_extra' => $request->hora_inicio_turno_extra,'hora_termino_turno_extra' => $request->hora_termino_turno_extra,
                'fecha_inicio_turno_extra' => $request->fecha_inicio_turno_extra,'fecha_termino_turno_extra'=> $request->fecha_termino_turno_extra,
                'dias_ejecucion_turno_extra'=> $request->dias_ejecucion_turno_extra,'horas_ejecucion_turno_extra'=> $request->horas_ejecucion_turno_extra,
                'estado_turno_extra' => $request->estado_turno_extra]);
            }

            CalendarioCalderas::where('id',$idCalendario)
            ->update(['title' => $request->title,'descripcion_calderas' => $request->descripcion_calderas,'id_turno' => $request->id_turno,
            'id_trabajador' => $request->id_trabajador,'id_edificio' => $request->id_edificio,'label' => $request->label,'classes' => $request->classes,
            'id_val_dia_administrativo' => $request->id_val_dia_administrativo,'id_val_vacaciones' => $request->id_val_vacaciones,
            'id_val_reemplazo' => $request->id_val_reemplazo,'id_val_turno_extra' => $request->id_val_turno_extra,
            'hora_inicio' => $request->hora_inicio,'hora_termino' => $request->hora_termino,'startDate' => $request->startDate,'endDate' => $request->endDate]);

            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return $th;
        }
        
    }

    public function get_data_esp_asc(Request $request){
        try {
            $get_alls = CalendarioCalderas::select('*')
            ->leftjoin('dia_administrativo_calderas','calendario_calderas.id','=','dia_administrativo_calderas.id_calendario_calderas')
            ->leftjoin('vacaciones_calderas','calendario_calderas.id','=','vacaciones_calderas.id_calendario_calderas')
            ->leftjoin('reemplazo_calderas','calendario_calderas.id','=','reemplazo_calderas.id_calendario_calderas')
            ->leftjoin('turno_extra_calderas','calendario_calderas.id','=','turno_extra_calderas.id_calendario_calderas')
            ->leftjoin('trabajadores','reemplazo_calderas.id_trabajador_reemplazo','=','trabajadores.id')
            ->where('calendario_calderas.id',$request->id)
            ->first();
            return $get_alls;
        } catch (\Throwable $th) {
            return $th;
        }
            
    }
}
