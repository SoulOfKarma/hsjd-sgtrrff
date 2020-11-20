<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;
use App\CalendarioAscensores;
use App\DiaAdministrativoAscensores;
use App\TurnoExtraAscensores;
use App\VacacionesAscensores;
use App\ReemplazoAscensores;
use App\trabajadores;


class CalendarioAscensoresController extends Controller
{
    public function getTodoCalendario()
    {
        $getall = CalendarioAscensores::all();
        return $getall;
    }

    public function postNuevoTCalendario(Request $request){
        $res = CalendarioAscensores::create($request->all());

        return $res;
    }

    public function PutNuevoTCalendario(Request $request){
        try {
             
            $idAdministrativo = $request->id_val_dia_administrativo;
            $idVacaciones = $request->id_val_vacaciones;
            $idReemplazo = $request->id_val_reemplazo;
            $idTurnoExtra = $request->id_val_turno_extra;
            $idCalendario = $request->id_calendario_ascensores;
            $classesL = $request->classes;

            log::info($request);

            if($idAdministrativo == 1){
                
                $get_All = DiaAdministrativoAscensores::UpdateOrCreate(['id_calendario_ascensores' => $request->id_calendario_ascensores,'id_tipo_dia_administrativo' => $request->id_tipo_dia_administrativo,'fecha_dia_administrativo' => $request->fecha_dia_administrativo,
                 'estado_dia_administrativo' => $request->estado_dia_administrativo]);

                 log::info($get_All);
            }
            if($idVacaciones == 1 ){
                VacacionesAscensores::UpdateOrCreate(['id_calendario_ascensores' => $request->id_calendario_ascensores,'fecha_inicio_vacaciones'=> $request->fecha_inicio_vacaciones,'fecha_termino_vacaciones' => $request->fecha_termino_vacaciones,
                 'dias_vacaciones' => $request->dias_vacaciones, 'estado_vacaciones' => $request->estado_vacaciones]);
            }
            if($idReemplazo == 1){
                ReemplazoAscensores::UpdateOrCreate(['id_calendario_ascensores' => $request->id_calendario_ascensores,'id_trabajador_reemplazo' => $request->id_trabajador_reemplazo,'fecha_inicio_reemplazo' => $request->fecha_inicio_reemplazo,
                'fecha_termino_reemplazo' => $request->fecha_termino_reemplazo,'dias_reemplazo' => $request->dias_reemplazo,'estado_reemplazo' => $request->estado_reemplazo]);
            }
            if($idTurnoExtra == 1){
                TurnoExtraAscensores::UpdateOrCreate(['id_calendario_ascensores' => $request->id_calendario_ascensores,'hora_inicio_turno_extra' => $request->hora_inicio_turno_extra,'hora_termino_turno_extra' => $request->hora_termino_turno_extra,
                'fecha_inicio_turno_extra' => $request->fecha_inicio_turno_extra,'fecha_termino_turno_extra'=> $request->fecha_termino_turno_extra,
                'dias_ejecucion_turno_extra'=> $request->dias_ejecucion_turno_extra,'horas_ejecucion_turno_extra'=> $request->horas_ejecucion_turno_extra,
                'estado_turno_extra' => $request->estado_turno_extra]);
            }

            CalendarioAscensores::where('id',$idCalendario)
            ->update(['title' => $request->title,'descripcion_ascensores' => $request->descripcion_ascensores,'id_turno' => $request->id_turno,
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
            $get_alls = CalendarioAscensores::select('*')
            ->leftjoin('dia_administrativo_ascensores','calendario_ascensores.id','=','dia_administrativo_ascensores.id_calendario_ascensores')
            ->leftjoin('vacaciones_ascensores','calendario_ascensores.id','=','vacaciones_ascensores.id_calendario_ascensores')
            ->leftjoin('reemplazo_ascensores','calendario_ascensores.id','=','reemplazo_ascensores.id_calendario_ascensores')
            ->leftjoin('turno_extra_ascensores','calendario_ascensores.id','=','turno_extra_ascensores.id_calendario_ascensores')
            ->leftjoin('trabajadores','reemplazo_ascensores.id_trabajador_reemplazo','=','trabajadores.id')
            ->where('calendario_ascensores.id',$request->id)
            ->first();
            return $get_alls;
        } catch (\Throwable $th) {
            return $th;
        }
            
    }
}
