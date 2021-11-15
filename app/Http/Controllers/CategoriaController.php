<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\categoria;
use DB;
use App\SolicitudTickets;
use App\SolicitudTicketINDs;
use App\SolicitudTicketsEM;
use App\SolicitudTicketsAps;
use Illuminate\Support\Facades\Log;
use App\SeguimientoSolicitudes;
use App\seguimientoAPSolicitudes;
use App\seguimientoEMSolicitudes;
use App\seguimientoINDSolicitudes;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $getall = categoria::all();

        return $getall;
    }

    public function getCategoriaSI()
    {
        $getall = categoria::select("*")
        ->where("id","!=",5)
        ->get();

        return $getall;
    }

    public function PutCategoria(Request $request){
        try {
            $data = [];
            if($request->idCategoriaOriginal == 1){
              $data = SolicitudTickets::firstwhere('id',$request->idsolicitud);       
            }else if($request->idCategoriaOriginal == 2){
              $data = SolicitudTicketsEM::firstwhere('id',$request->idsolicitud); 
            }else if($request->idCategoriaOriginal == 3){
              $data = SolicitudTicketINDs::firstwhere('id',$request->idsolicitud); 
            }else if($request->idCategoriaOriginal == 4){
              $data = SolicitudTicketsAps::firstwhere('id',$request->idsolicitud); 
            }

            if($request->idCategoria == 1){
                $solicitud = new SolicitudTickets();
                $solicitud->uuid = $data->uuid;
                $solicitud->id_user = $data->id_user;
                $solicitud->id_estado = $data->id_estado;
                $solicitud->id_edificio = $data->id_edificio;
                $solicitud->id_servicio = $data->id_servicio;
                $solicitud->id_ubicacionEx = $data->id_ubicacionEx;
                $solicitud->id_prioridad = $data->id_prioridad;
                $solicitud->id_tipoReparacion = $data->id_tipoReparacion;
                $solicitud->id_categoria = $request->idCategoria;
                $solicitud->tituloP = $data->tituloP;
                $solicitud->descripcionP = $data->descripcionP;
                $solicitud->created_at = $data->created_at;
                $solicitud->updated_at = $data->updated_at;
                $solicitud->save();
            }else if($request->idCategoria == 2){
                $solicitud = new SolicitudTicketsEM();
                $solicitud->uuid = $data->uuid;
                $solicitud->id_user = $data->id_user;
                $solicitud->id_estado = $data->id_estado;
                $solicitud->id_edificio = $data->id_edificio;
                $solicitud->id_servicio = $data->id_servicio;
                $solicitud->id_ubicacionEx = $data->id_ubicacionEx;
                $solicitud->id_prioridad = $data->id_prioridad;
                $solicitud->id_tipoReparacion = $data->id_tipoReparacion;
                $solicitud->id_categoria = $request->idCategoria;
                $solicitud->tituloP = $data->tituloP;
                $solicitud->descripcionP = $data->descripcionP;
                $solicitud->created_at = $data->created_at;
                $solicitud->updated_at = $data->updated_at;
                $solicitud->save();

            }else if($request->idCategoria == 3){
                $solicitud = new SolicitudTicketINDs();
                $solicitud->uuid = $data->uuid;
                $solicitud->id_user = $data->id_user;
                $solicitud->id_estado = $data->id_estado;
                $solicitud->id_edificio = $data->id_edificio;
                $solicitud->id_servicio = $data->id_servicio;
                $solicitud->id_ubicacionEx = $data->id_ubicacionEx;
                $solicitud->id_prioridad = $data->id_prioridad;
                $solicitud->id_tipoReparacion = $data->id_tipoReparacion;
                $solicitud->id_categoria = $request->idCategoria;
                $solicitud->tituloP = $data->tituloP;
                $solicitud->descripcionP = $data->descripcionP;
                $solicitud->created_at = $data->created_at;
                $solicitud->updated_at = $data->updated_at;
                $solicitud->save();

            }else if($request->idCategoria == 4){
                $solicitud = new SolicitudTicketsAps();
                $solicitud->uuid = $data->uuid;
                $solicitud->id_user = $data->id_user;
                $solicitud->id_estado = $data->id_estado;
                $solicitud->id_edificio = $data->id_edificio;
                $solicitud->id_servicio = $data->id_servicio;
                $solicitud->id_ubicacionEx = $data->id_ubicacionEx;
                $solicitud->id_prioridad = $data->id_prioridad;
                $solicitud->id_tipoReparacion = $data->id_tipoReparacion;
                $solicitud->id_categoria = $request->idCategoria;
                $solicitud->tituloP = $data->tituloP;
                $solicitud->descripcionP = $data->descripcionP;
                $solicitud->created_at = $data->created_at;
                $solicitud->updated_at = $data->updated_at;
                $solicitud->save();
            }

            if($request->idCategoriaOriginal == 1){
                $data = SolicitudTickets::where('id',$request->idsolicitud)->delete();    
                $seguimiento = new SeguimientoSolicitudes();

                $seguimiento->id_solicitud = $request->idsolicitud;
                $seguimiento->uuid = $request->uuid;
                $seguimiento->descripcionSeguimiento = "El agente " . $request->nombre . " a derivado el Ticket N°" . $request->idSolicitud . " a " . $request->des_categoria . "";
                $seguimiento->id_user = $request->id_user;

                $seguimiento->save();   
            }else if($request->idCategoriaOriginal == 2){
                $data = SolicitudTicketsEM::where('id',$request->idsolicitud)->delete(); 
                $seguimiento = new seguimientoEMSolicitudes();

                $seguimiento->id_solicitud = $request->idsolicitud;
                $seguimiento->uuid = $request->uuid;
                $seguimiento->descripcionSeguimiento = "El agente " . $request->nombre . " a derivado el Ticket N°" . $request->idSolicitud . " a " . $request->des_categoria . "";
                $seguimiento->id_user = $request->id_user;

                $seguimiento->save();
            }else if($request->idCategoriaOriginal == 3){
                $data = SolicitudTicketINDs::where('id',$request->idsolicitud)->delete(); 
                $seguimiento = new seguimientoINDSolicitudes();

                $seguimiento->id_solicitud = $request->idsolicitud;
                $seguimiento->uuid = $request->uuid;
                $seguimiento->descripcionSeguimiento = "El agente " . $request->nombre . " a derivado el Ticket N°" . $request->idSolicitud . " a " . $request->des_categoria . "";
                $seguimiento->id_user = $request->id_user;

                $seguimiento->save();
            }else if($request->idCategoriaOriginal == 4){
                $data = SolicitudTicketsAps::where('id',$request->idsolicitud)->delete();
                $seguimiento = new seguimientoAPSolicitudes();

                $seguimiento->id_solicitud = $request->idsolicitud;
                $seguimiento->uuid = $request->uuid;
                $seguimiento->descripcionSeguimiento = "El agente " . $request->nombre . " a derivado el Ticket N°" . $request->idSolicitud . " a " . $request->des_categoria . "";
                $seguimiento->id_user = $request->id_user;

                $seguimiento->save(); 
            }

            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    
}
