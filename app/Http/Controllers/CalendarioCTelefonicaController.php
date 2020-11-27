<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\CalendarioCTelefonicas;
use App\DiaAdministrativoCTelefonicas;
use App\TurnoExtraCTelefonicas;
use App\VacacionesCTelefonicas;
use App\ReemplazoCTelefonicas;
use App\trabajadores;
use \Illuminate\Support\Facades\Route;

class CalendarioCTelefonicaController extends Controller
{
    public function getTodoCalendarioCTEL()
    {
        $getall = CalendarioCTelefonicas::all();
        return $getall;
    }

    public function postNuevoTCalendarioCTEL(Request $request){
        $res = CalendarioCTelefonicas::create($request->all());

        return $res;
    }

    public function PutNuevoTCalendarioCTEL(Request $request){
        try {
             
            $idAdministrativo = $request->id_val_dia_administrativo;
            $idVacaciones = $request->id_val_vacaciones;
            $idReemplazo = $request->id_val_reemplazo;
            $idTurnoExtra = $request->id_val_turno_extra;
            $idCalendario = $request->id_calendario_ctelefonicas;
            $classesL = $request->classes;

            log::info($request);

            if($idAdministrativo == 1){
                
                $get_All = DiaAdministrativoCTelefonicas::UpdateOrCreate(['id_calendario_ctelefonicas' => $request->id_calendario_ctelefonicas,'id_tipo_dia_administrativo' => $request->id_tipo_dia_administrativo,'fecha_dia_administrativo' => $request->fecha_dia_administrativo,
                 'estado_dia_administrativo' => $request->estado_dia_administrativo]);

                 log::info($get_All);
            }
            if($idVacaciones == 1 ){
                VacacionesCTelefonicas::UpdateOrCreate(['id_calendario_ctelefonicas' => $request->id_calendario_ctelefonicas,'fecha_inicio_vacaciones'=> $request->fecha_inicio_vacaciones,'fecha_termino_vacaciones' => $request->fecha_termino_vacaciones,
                 'dias_vacaciones' => $request->dias_vacaciones, 'estado_vacaciones' => $request->estado_vacaciones]);
            }
            if($idReemplazo == 1){
                ReemplazoCTelefonicas::UpdateOrCreate(['id_calendario_ctelefonicas' => $request->id_calendario_ctelefonicas,'id_trabajador_reemplazo' => $request->id_trabajador_reemplazo,'fecha_inicio_reemplazo' => $request->fecha_inicio_reemplazo,
                'fecha_termino_reemplazo' => $request->fecha_termino_reemplazo,'dias_reemplazo' => $request->dias_reemplazo,'estado_reemplazo' => $request->estado_reemplazo]);
            }
            if($idTurnoExtra == 1){
                TurnoExtraCTelefonicas::UpdateOrCreate(['id_calendario_ctelefonicas' => $request->id_calendario_ctelefonicas,'hora_inicio_turno_extra' => $request->hora_inicio_turno_extra,'hora_termino_turno_extra' => $request->hora_termino_turno_extra,
                'fecha_inicio_turno_extra' => $request->fecha_inicio_turno_extra,'fecha_termino_turno_extra'=> $request->fecha_termino_turno_extra,
                'dias_ejecucion_turno_extra'=> $request->dias_ejecucion_turno_extra,'horas_ejecucion_turno_extra'=> $request->horas_ejecucion_turno_extra,
                'estado_turno_extra' => $request->estado_turno_extra]);
            }

            CalendarioCTelefonicas::where('id',$idCalendario)
            ->update(['title' => $request->title,'descripcion_ctelefonicas' => $request->descripcion_ctelefonicas,'id_turno' => $request->id_turno,
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

    public function get_data_esp_CTEL(Request $request){
        try {
            $get_alls = CalendarioCTelefonicas::select('*')
            ->leftjoin('dia_administrativo_c_telefonicas','calendario_ctelefonicas.id','=','dia_administrativo_c_telefonicas.id_calendario_ctelefonicas')
            ->leftjoin('vacaciones_c_telefonicas','calendario_ctelefonicas.id','=','vacaciones_c_telefonicas.id_calendario_ctelefonicas')
            ->leftjoin('reemplazo_c_telefonicas','calendario_ctelefonicas.id','=','reemplazo_c_telefonicas.id_calendario_ctelefonicas')
            ->leftjoin('turno_extra_c_telefonicas','calendario_ctelefonicas.id','=','turno_extra_c_telefonicas.id_calendario_ctelefonicas')
            ->leftjoin('trabajadores','reemplazo_c_telefonicas.id_trabajador_reemplazo','=','trabajadores.id')
            ->where('calendario_ctelefonicas.id',$request->id)
            ->first();
            return $get_alls;
        } catch (\Throwable $th) {
            return $th;
        }
            
    }
}