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
            $get_all = tbl_ticket_equipamientoMedicos::select('tbl_ticket_equipamiento_medicos.id_solicitud','equipamiento_medicos.marca',
            'equipamiento_medicos.modelo','equipamiento_medicos.serie','equipamiento_medicos.ninventario')
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
