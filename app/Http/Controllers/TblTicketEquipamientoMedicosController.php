<?php

namespace App\Http\Controllers;

use App\tbl_ticket_equipamientoMedicos;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;

class TblTicketEquipamientoMedicosController extends Controller
{
    public function ListadoEquipamientoMedicoByID(Request $request){
        try {
            $get_all = tbl_ticket_equipamientoMedicos::select('tbl_ticket_equipamiento_medicos.id_solicitud',
            'tbl_ticket_equipamiento_medicos.id_equipamiento_medico',
            DB::raw("IF (equipamiento_medicos.equipo IS NULL ,CONCAT('PENDIENTE'), equipamiento_medicos.equipo) as equipo"),
            DB::raw("IF (equipamiento_medicos.marca IS NULL ,CONCAT('PENDIENTE'), equipamiento_medicos.marca) as marca"),
            DB::raw("IF (equipamiento_medicos.modelo IS NULL ,CONCAT('PENDIENTE'), equipamiento_medicos.modelo) as modelo"),
            DB::raw("IF (equipamiento_medicos.serie IS NULL ,CONCAT('PENDIENTE'), equipamiento_medicos.serie) as serie"),
            DB::raw("IF (equipamiento_medicos.ninventario IS NULL ,CONCAT('PENDIENTE'), equipamiento_medicos.ninventario) as ninventario"))
            ->join('solicitud_tickets_e_m_s','tbl_ticket_equipamiento_medicos.id_solicitud', '=', 'solicitud_tickets_e_m_s.id')
            ->join('equipamiento_medicos','tbl_ticket_equipamiento_medicos.id_equipamiento_medico', '=', 'equipamiento_medicos.id')
            ->where('tbl_ticket_equipamiento_medicos.id_solicitud',$request->id)
            ->get();
            return $get_all;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
}
