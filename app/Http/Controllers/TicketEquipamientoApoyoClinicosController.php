<?php

namespace App\Http\Controllers;

use App\TicketEquipamientoApoyoClinicos;
use Illuminate\Http\Request;
use App\EquipamientoApoyoClinicos;
use Illuminate\Support\Facades\Log;
use DB;

class TicketEquipamientoApoyoClinicosController extends Controller
{
    public function ListadoEquipamientoApoyoClinicoByID(Request $request){
        try {
            $get_all = [];

            $get_datos = TicketEquipamientoApoyoClinicos::select('*')
            ->where('ticket_equipamiento_apoyo_clinicos.id_solicitud',$request->id)
            ->get();
            
            if(count($get_datos) < 1){
                $resp = EquipamientoApoyoClinicos::create(['equipo' => 'PENDIENTE','marca' => 'PENDIENTE','modelo' => 'PENDIENTE','serie' => 'PENDIENTE','ninventario' => 'PENDIENTE']);
                TicketEquipamientoApoyoClinicos::create(['id_solicitud' => $request->id,'id_equipamiento_apoyoclinico' => $resp->id]);
                $get_all = TicketEquipamientoApoyoClinicos::select('ticket_equipamiento_apoyo_clinicos.id_solicitud',
                'ticket_equipamiento_apoyo_clinicos.id_equipamiento_apoyoclinico',
                DB::raw("IF (equipamiento_apoyo_clinicos.equipo IS NULL ,CONCAT('PENDIENTE'), equipamiento_apoyo_clinicos.equipo) as equipo"),
                DB::raw("IF (equipamiento_apoyo_clinicos.marca IS NULL ,CONCAT('PENDIENTE'), equipamiento_apoyo_clinicos.marca) as marca"),
                DB::raw("IF (equipamiento_apoyo_clinicos.modelo IS NULL ,CONCAT('PENDIENTE'), equipamiento_apoyo_clinicos.modelo) as modelo"),
                DB::raw("IF (equipamiento_apoyo_clinicos.serie IS NULL ,CONCAT('PENDIENTE'), equipamiento_apoyo_clinicos.serie) as serie"),
                DB::raw("IF (equipamiento_apoyo_clinicos.ninventario IS NULL ,CONCAT('PENDIENTE'), equipamiento_apoyo_clinicos.ninventario) as ninventario"))
                ->join('solicitud_tickets_aps','ticket_equipamiento_apoyo_clinicos.id_solicitud', '=', 'solicitud_tickets_aps.id')
                ->join('equipamiento_apoyo_clinicos','ticket_equipamiento_apoyo_clinicos.id_equipamiento_apoyoclinico', '=', 'equipamiento_apoyo_clinicos.id')
                ->where('ticket_equipamiento_apoyo_clinicos.id_solicitud',$request->id)
                ->get();

            }else{
                $get_all = TicketEquipamientoApoyoClinicos::select('ticket_equipamiento_apoyo_clinicos.id_solicitud',
                'ticket_equipamiento_apoyo_clinicos.id_equipamiento_apoyoclinico',
                DB::raw("IF (equipamiento_apoyo_clinicos.equipo IS NULL ,CONCAT('PENDIENTE'), equipamiento_apoyo_clinicos.equipo) as equipo"),
                DB::raw("IF (equipamiento_apoyo_clinicos.marca IS NULL ,CONCAT('PENDIENTE'), equipamiento_apoyo_clinicos.marca) as marca"),
                DB::raw("IF (equipamiento_apoyo_clinicos.modelo IS NULL ,CONCAT('PENDIENTE'), equipamiento_apoyo_clinicos.modelo) as modelo"),
                DB::raw("IF (equipamiento_apoyo_clinicos.serie IS NULL ,CONCAT('PENDIENTE'), equipamiento_apoyo_clinicos.serie) as serie"),
                DB::raw("IF (equipamiento_apoyo_clinicos.ninventario IS NULL ,CONCAT('PENDIENTE'), equipamiento_apoyo_clinicos.ninventario) as ninventario"))
                ->join('solicitud_tickets_aps','ticket_equipamiento_apoyo_clinicos.id_solicitud', '=', 'solicitud_tickets_aps.id')
                ->join('equipamiento_apoyo_clinicos','ticket_equipamiento_apoyo_clinicos.id_equipamiento_apoyoclinico', '=', 'equipamiento_apoyo_clinicos.id')
                ->where('ticket_equipamiento_apoyo_clinicos.id_solicitud',$request->id)
                ->get();
            }

            
            return $get_all;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
}
