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
            $rDAdmin = $request->rDAdmin;
            $rVacaciones = $request->rVacaciones;
            $rReemplazo = $request->rReemplazo;
            $rTurnoExtra = $request->rTurnoExtra;
            $idCalendario = $request->id_calendario_ascensores;
            $classesL = $request->classes;

            if($idAdministrativo == 1 && $rDAdmin == 2){
                DiaAdministrativoAscensores::where('id_calendario_ascensores',$idCalendario)
                 ->update(['id_tipo_dia_administrativo' => $request->id_tipo_dia_administrativo,'fecha_dia_administrativo' => $request->fecha_dia_administrativo,
                 'estado_dia_administrativo' => $request->estado_dia_administrativo]);
            }else if($idAdministrativo == 1 && $rDAdmin == 1){
               
                $data = DiaAdministrativoAscensores::create($request->all());
               
            }
            if($idVacaciones == 1 && $rVacaciones == 2){
                VacacionesAscensores::where('id_calendario_ascensores',$idCalendario)
                 ->update(['fecha_inicio_vacaciones'=> $request->fecha_inicio_vacaciones,'fecha_termino_vacaciones' => $request->fecha_termino_vacaciones,
                 'dias_vacaciones' => $request->dias_vacaciones, 'estado_vacaciones' => $request->estado_vacaciones]);
            }else if($idVacaciones == 1 && $rVacaciones == 1){
                VacacionesAscensores::create($request->all());
            }
            if($idReemplazo == 1 && $rReemplazo == 2){
                ReemplazoAscensores::where('id_calendario_ascensores',$idCalendario)
                ->update(['id_trabajador_reemplazo' => $request->id_trabajador_reemplazo,'fecha_inicio_reemplazo' => $request->fecha_inicio_reemplazo,
                'fecha_termino_reemplazo' => $request->fecha_termino_reemplazo,'dias_reemplazo' => $request->dias_reemplazo,'estado_reemplazo' => $request->estado_reemplazo]);
            }else if($idReemplazo == 1 && $rReemplazo == 1){
                ReemplazoAscensores::create($request->all());
            }
            if($idTurnoExtra == 1 && $rTurnoExtra == 2){
                TurnoExtraAscensores::where('id_calendario_ascensores',$idCalendario)
                ->update(['hora_inicio_turno_extra' => $request->hora_inicio_turno_extra,'hora_termino_turno_extra' => $request->hora_termino_turno_extra,
                'fecha_inicio_turno_extra' => $request->fecha_inicio_turno_extra,'fecha_termino_turno_extra'=> $request->fecha_termino_turno_extra,
                'dias_ejecucion_turno_extra'=> $request->dias_ejecucion_turno_extra,'horas_ejecucion_turno_extra'=> $request->horas_ejecucion_turno_extra,
                'estado_turno_extra' => $request->estado_turno_extra]);
            }else if($idTurnoExtra == 1 && $rTurnoExtra == 1){
                TurnoExtraAscensores::create($request->all());
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
}
