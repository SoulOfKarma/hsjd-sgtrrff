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
            log::info($request);
            $idAdministrativo = $request->id_val_dia_administrativo;
            $idVacaciones = $request->id_val_vacaciones;
            $idReemplazo = $request->id_val_reemplazo;
            $idTurnoExtra = $request->id_val_turno_extra;
            $rDAdmin = $request->rDAdmin;
            $rVacaciones = $request->rVacaciones;
            $rReemplazo = $request->rReemplazo;
            $rTurnoExtra = $request->rTurnoExtra;
            $idCalendario = $request->id_calendario;

            log::info($request);

            if($idAdministrativo == 1 || $rDAdmin == "2"){
                DiaAdministrativoAscensores::where('id_calendario_ascensores')
                 ->update([]);
            }else if($idAdministrativo == 1 || $rDAdmin == "1"){
                DiaAdministrativoAscensores::create($request->all());
            }
            if($idVacaciones == 1 || $rVacaciones == "2"){
                VacacionesAscensores::where('id_calendario_ascensores')
                 ->update([]);
            }else if($idVacaciones == 1 || $rVacaciones == "1"){
                VacacionesAscensores::create($request->all());
            }
            if($idReemplazo == 1 || $rReemplazo == "2"){
                ReemplazoAscensores::where('id_calendario_ascensores')
                ->update([]);
            }else if($idReemplazo == 1 || $rReemplazo == "1"){
                ReemplazoAscensores::create($request->all());
            }
            if($idTurnoExtra == 1 || $rTurnoExtra == "2"){
                TurnoExtraAscensores::where('id_calendario_ascensores')
                ->update([]);
            }else if($idTurnoExtra == 1 || $rTurnoExtra == "1"){
                TurnoExtraAscensores::create($request->all());
            }

            CalendarioAscensores::where('id',$idCalendario)
            ->update(['title' => $request->title,'descripcion_ascensores' => $request->descripcion_ascensores,'id_turno' => $request->id_turno,
            'id_trabajador' => $request->id_trabajador,'id_edificio' => $request->id_edificio,'label' => $request->label,
            'id_val_dia_administrativo' => $request->id_val_dia_administrativo,'id_val_vacaciones' => $request->id_val_vacaciones,
            'id_val_reemplazo' => $request->id_val_reemplazo,'id_val_turno_extra' => $request->id_val_turno_extra,
            'hora_inicio' => $request->hora_inicio,'hora_termino' => $request->hora_termino,'startDate' => $request->startDate,'endDate' => $request->endDate]);

            return true;
        } catch (\Throwable $th) {
            return $th;
        }
        
    }
}
