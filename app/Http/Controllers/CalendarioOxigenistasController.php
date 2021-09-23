<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\trabajadores;
use App\CalendarioOxigenistas;
use App\DiaAdministrativoOxigenistas;
use App\ReemplazoOxigenistas;
use App\TurnoExtraOxigenistas;
use App\VacacionesOxigenistas;


class CalendarioOxigenistasController extends Controller
{
    public function getTodoCalendario()
    {
        $getall = CalendarioOxigenistas::all();
        return $getall;
    }

    public function postNuevoTCalendario(Request $request){
        $res = CalendarioOxigenistas::create($request->all());

        return $res;
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
                
                $get_All = DiaAdministrativoOxigenistas::UpdateOrCreate(['id_calendario_oxigenistas' => $request->id_calendario_oxigenistas,'id_tipo_dia_administrativo' => $request->id_tipo_dia_administrativo,'fecha_dia_administrativo' => $request->fecha_dia_administrativo,
                 'estado_dia_administrativo' => $request->estado_dia_administrativo]);
            }
            if($idVacaciones == 1 ){
                VacacionesOxigenistas::UpdateOrCreate(['id_calendario_oxigenistas' => $request->id_calendario_oxigenistas,'fecha_inicio_vacaciones'=> $request->fecha_inicio_vacaciones,'fecha_termino_vacaciones' => $request->fecha_termino_vacaciones,
                 'dias_vacaciones' => $request->dias_vacaciones, 'estado_vacaciones' => $request->estado_vacaciones]);
            }
            if($idReemplazo == 1){
                ReemplazoOxigenistas::UpdateOrCreate(['id_calendario_oxigenistas' => $request->id_calendario_oxigenistas,'id_trabajador_reemplazo' => $request->id_trabajador_reemplazo,'fecha_inicio_reemplazo' => $request->fecha_inicio_reemplazo,
                'fecha_termino_reemplazo' => $request->fecha_termino_reemplazo,'dias_reemplazo' => $request->dias_reemplazo,'estado_reemplazo' => $request->estado_reemplazo]);
            }
            if($idTurnoExtra == 1){
                TurnoExtraOxigenistas::UpdateOrCreate(['id_calendario_oxigenistas' => $request->id_calendario_oxigenistas,'hora_inicio_turno_extra' => $request->hora_inicio_turno_extra,'hora_termino_turno_extra' => $request->hora_termino_turno_extra,
                'fecha_inicio_turno_extra' => $request->fecha_inicio_turno_extra,'fecha_termino_turno_extra'=> $request->fecha_termino_turno_extra,
                'dias_ejecucion_turno_extra'=> $request->dias_ejecucion_turno_extra,'horas_ejecucion_turno_extra'=> $request->horas_ejecucion_turno_extra,
                'estado_turno_extra' => $request->estado_turno_extra]);
            }

            CalendarioOxigenistas::where('id',$idCalendario)
            ->update(['title' => $request->title,'descripcion_oxigenistas' => $request->descripcion_oxigenistas,'id_turno' => $request->id_turno,
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
            $get_alls = CalendarioOxigenistas::select('*')
            ->leftjoin('dia_administrativo_oxigenistas','calendario_oxigenistas.id','=','dia_administrativo_oxigenistas.id_calendario_oxigenistas')
            ->leftjoin('vacaciones_oxigenistas','calendario_oxigenistas.id','=','vacaciones_oxigenistas.id_calendario_oxigenistas')
            ->leftjoin('reemplazo_oxigenistas','calendario_oxigenistas.id','=','reemplazo_oxigenistas.id_calendario_oxigenistas')
            ->leftjoin('turno_extra_oxigenistas','calendario_oxigenistas.id','=','turno_extra_oxigenistas.id_calendario_oxigenistas')
            ->leftjoin('trabajadores','reemplazo_oxigenistas.id_trabajador_reemplazo','=','trabajadores.id')
            ->where('calendario_oxigenistas.id',$request->id)
            ->first();
            return $get_alls;
        } catch (\Throwable $th) {
            return $th;
        }
            
    }
}
