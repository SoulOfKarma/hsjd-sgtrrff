<?php

namespace App\Http\Controllers;

use DB;
use App\Calendario_taller_industrial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\trabajadores;
use App\DiaAdministrativoTIndustrials;
use App\Reemplazotindustrials;
use App\TurnoExtratindustrials;
use App\Vacacionestindustrials;

class CalendarioTallerIndustrialController extends Controller
{
    public function getTodoCalendario()
    {
        try {
            $getall = Calendario_taller_industrial::all();
            return $getall;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
        
    }

    public function postNuevoTCalendario(Request $request){
        try {
            $res = Calendario_taller_industrial::create($request->all());
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
            $idCalendario = $request->id_calendario_oxigenistas;
            $classesL = $request->classes;

            if($idAdministrativo == 1){
                
                $get_All = DiaAdministrativoTIndustrials::UpdateOrCreate(['id_calendario_t_industrials' => $request->id_calendario_t_industrials,'id_tipo_dia_administrativo' => $request->id_tipo_dia_administrativo,'fecha_dia_administrativo' => $request->fecha_dia_administrativo,
                 'estado_dia_administrativo' => $request->estado_dia_administrativo]);
            }
            if($idVacaciones == 1 ){
                Vacacionestindustrials::UpdateOrCreate(['id_calendario_tindustrials' => $request->id_calendario_tindustrials,'fecha_inicio_vacaciones'=> $request->fecha_inicio_vacaciones,'fecha_termino_vacaciones' => $request->fecha_termino_vacaciones,
                 'dias_vacaciones' => $request->dias_vacaciones, 'estado_vacaciones' => $request->estado_vacaciones]);
            }
            if($idReemplazo == 1){
                Reemplazotindustrials::UpdateOrCreate(['id_calendario_tindustrials' => $request->id_calendario_tindustrials,'id_trabajador_reemplazo' => $request->id_trabajador_reemplazo,'fecha_inicio_reemplazo' => $request->fecha_inicio_reemplazo,
                'fecha_termino_reemplazo' => $request->fecha_termino_reemplazo,'dias_reemplazo' => $request->dias_reemplazo,'estado_reemplazo' => $request->estado_reemplazo]);
            }
            if($idTurnoExtra == 1){
                TurnoExtratindustrials::UpdateOrCreate(['id_calendario_tindustrials' => $request->id_calendario_tindustrials,'hora_inicio_turno_extra' => $request->hora_inicio_turno_extra,'hora_termino_turno_extra' => $request->hora_termino_turno_extra,
                'fecha_inicio_turno_extra' => $request->fecha_inicio_turno_extra,'fecha_termino_turno_extra'=> $request->fecha_termino_turno_extra,
                'dias_ejecucion_turno_extra'=> $request->dias_ejecucion_turno_extra,'horas_ejecucion_turno_extra'=> $request->horas_ejecucion_turno_extra,
                'estado_turno_extra' => $request->estado_turno_extra]);
            }

            Calendario_taller_industrial::where('id',$idCalendario)
            ->update(['title' => $request->title,'descripcion_tindustrial' => $request->descripcion_tindustrial,'id_turno' => $request->id_turno,
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
            $get_alls = Calendario_taller_industrial::select('*')
            ->leftjoin('dia_administrativo_t_industrials','calendario_taller_industrials.id','=','dia_administrativo_t_industrials.id_calendario_t_industrials')
            ->leftjoin('vacacionestindustrials','calendario_taller_industrials.id','=','vacacionestindustrials.id_calendario_tindustrials')
            ->leftjoin('reemplazotindustrials','calendario_taller_industrials.id','=','reemplazotindustrials.id_calendario_tindustrials')
            ->leftjoin('turno_extratindustrials','calendario_taller_industrials.id','=','turno_extratindustrials.id_calendario_tindustrials')
            ->leftjoin('trabajadores','reemplazotindustrials.id_trabajador_reemplazo','=','trabajadores.id')
            ->where('calendario_taller_industrials.id',$request->id)
            ->first();
            return $get_alls;
        } catch (\Throwable $th) {
            return $th;
        }
            
    }
}
