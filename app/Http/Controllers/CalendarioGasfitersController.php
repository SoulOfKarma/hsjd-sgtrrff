<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\trabajadores;
use App\CalendarioGasfiters;
use App\DiaAdministrativoGasfiters;
use App\ReemplazoGasfiters;
use App\TurnoExtraGasfiters;
use App\VacacionesGasfiters;

class CalendarioGasfitersController extends Controller
{
    public function getTodoCalendario()
    {
        try {
            $getall = CalendarioGasfiters::all();
            return $getall;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
        
    }

    public function postNuevoTCalendario(Request $request){
        try {
            $res = CalendarioGasfiters::create($request->all());
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
        
    }

    public function PutNuevoTCalendario(Request $request){
        try {
             
            $idAdministrativo = $request->id_val_dia_administrativo;
            $idVacaciones = $request->id_val_vacaciones;
            $idReemplazo = $request->id_val_reemplazo;
            $idTurnoExtra = $request->id_val_turno_extra;
            $idCalendario = $request->id_calendario_gasfiters;
            $classesL = $request->classes;

            if($idAdministrativo == 1){
                
                $get_All = DiaAdministrativoGasfiters::UpdateOrCreate(['id_calendario_gasfiters' => $request->id_calendario_gasfiters,'id_tipo_dia_administrativo' => $request->id_tipo_dia_administrativo,'fecha_dia_administrativo' => $request->fecha_dia_administrativo,
                 'estado_dia_administrativo' => $request->estado_dia_administrativo]);
            }
            if($idVacaciones == 1 ){
                VacacionesGasfiters::UpdateOrCreate(['id_calendario_gasfiters' => $request->id_calendario_gasfiters,'fecha_inicio_vacaciones'=> $request->fecha_inicio_vacaciones,'fecha_termino_vacaciones' => $request->fecha_termino_vacaciones,
                 'dias_vacaciones' => $request->dias_vacaciones, 'estado_vacaciones' => $request->estado_vacaciones]);
            }
            if($idReemplazo == 1){
                ReemplazoGasfiters::UpdateOrCreate(['id_calendario_gasfiters' => $request->id_calendario_gasfiters,'id_trabajador_reemplazo' => $request->id_trabajador_reemplazo,'fecha_inicio_reemplazo' => $request->fecha_inicio_reemplazo,
                'fecha_termino_reemplazo' => $request->fecha_termino_reemplazo,'dias_reemplazo' => $request->dias_reemplazo,'estado_reemplazo' => $request->estado_reemplazo]);
            }
            if($idTurnoExtra == 1){
                TurnoExtraGasfiters::UpdateOrCreate(['id_calendario_gasfiters' => $request->id_calendario_gasfiters,'hora_inicio_turno_extra' => $request->hora_inicio_turno_extra,'hora_termino_turno_extra' => $request->hora_termino_turno_extra,
                'fecha_inicio_turno_extra' => $request->fecha_inicio_turno_extra,'fecha_termino_turno_extra'=> $request->fecha_termino_turno_extra,
                'dias_ejecucion_turno_extra'=> $request->dias_ejecucion_turno_extra,'horas_ejecucion_turno_extra'=> $request->horas_ejecucion_turno_extra,
                'estado_turno_extra' => $request->estado_turno_extra]);
            }

            CalendarioGasfiters::where('id',$idCalendario)
            ->update(['title' => $request->title,'descripcion_gasfiters' => $request->descripcion_gasfiters,'id_turno' => $request->id_turno,
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
            $get_alls = CalendarioGasfiters::select('*')
            ->leftjoin('dia_administrativo_gasfiters','calendario_gasfiters.id','=','dia_administrativo_gasfiters.id_calendario_gasfiters')
            ->leftjoin('vacaciones_gasfiters','calendario_gasfiters.id','=','vacaciones_gasfiters.id_calendario_gasfiters')
            ->leftjoin('reemplazo_gasfiters','calendario_gasfiters.id','=','reemplazo_gasfiters.id_calendario_gasfiters')
            ->leftjoin('turno_extra_gasfiters','calendario_gasfiters.id','=','turno_extra_gasfiters.id_calendario_gasfiters')
            ->leftjoin('trabajadores','reemplazo_gasfiters.id_trabajador_reemplazo','=','trabajadores.id')
            ->where('calendario_gasfiters.id',$request->id)
            ->first();
            return $get_alls;
        } catch (\Throwable $th) {
            return $th;
        }
            
    }
}
