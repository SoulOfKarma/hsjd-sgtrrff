<?php

namespace App\Http\Controllers;

use App\SolicitudTicketINDs;
use App\Mail\TicketGenerado;
use App\Users;
use App\seguimientoINDSolicitudes;
use App\EstadoSolicituds;
use Uuid;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class SolicitudTicketINDsController extends Controller
{
    public function traerUltimoT(){
        try {
            $get_all = SolicitudTicketINDs::latest('id')->first();
            return $get_all;
        } catch (\Throwable $th) {
            log::info($th);
        }
    }

    public function GetSolicitudCreada(Request $request)
    {
        try {
            $get_all = SolicitudTicketINDs::find($request->id);
        return  $get_all;
        } catch (\Throwable $th) {
            log::info($th);
        }
        
    }

    public function ModificarSolicitud(Request $request)
    {
        try {
            $response2 = SolicitudTicketINDs::where('uuid', $request->uuid)
            ->where('id', $request->id)
            ->update([
                'id_edificio' => $request->id_edificio, 'id_servicio' => $request->id_servicio,
                'id_ubicacionEx' => $request->id_ubicacionEx, 'id_tipoReparacion' => $request->id_tipoReparacion,
                'id_estado' => $request->id_estado, 'descripcionP' => $request->descripcionP, 'tituloP' => $request->tituloP
            ]);

         $response = seguimientoINDSolicitudes::create($request->all());

         $nombre = $request->nombre;
         $id = $request->id_user;
         $titulo = $request->tituloP;
         $descripcionTicket = $request->descripcionP;
         $estado = $request->id_estado;
         $razon = $request->razonMail;
         $descripcionProblema = $request->descripcionProblema;

            $userSearch = Users::where('id',$id)->first();
            $ValidarCargo = $userSearch->id_cargo_asociado;     
            $userMail = [];

            $getEstado = EstadoSolicituds::where('id',$estado)->first();
            

            $desEstado = $getEstado->descripcionEstado;

            if($ValidarCargo == null || $ValidarCargo == 0){
                $userMail = Users::select('email')
                ->Where('id',$id)
                ->orWhere('id_cargo_asociado',$id)
                ->get();
              
            }else{
               
            $userMail = Users::select('email')
            ->where('id_cargo_asociado',$ValidarCargo)
            ->orWhere('id',$ValidarCargo)
            ->get();
           
            }

            if($userMail == [] || $userMail == null){
                $userMail[0] = 'soporte.rrff@redsalud.gov.cl';
            }

            /* $listContactos = [];
            $i = 0;
        
            foreach ($userMail as $key) {
                if($i == 0){
                $listContactos[$i] = $key->email;
                $i++;
                }
            } */
            
            Mail::send('/Mails/SolicitudModificadaUsuario',['nombre' => $nombre, 'id' => $id, 'titulo' => $titulo, 'descripcionTicket' => $descripcionProblema, 'estado' => $desEstado, 'razon' => $razon], function ($message) use($listContactos){
                $message->setTo($userMail)->setSubject('Modificacion de ticket');
                $message->setFrom('soporte.rrff@redsalud.gov.cl', 'Mantencion');
                //$message->setBcc(['ricardo.soto.g@redsalud.gov.cl'=> 'Ricardo Soto Gomez']);
            });
            return "ok";
        } catch (\Throwable $th) {
            log::info($th);
        }
 
    }

    public function indexSeguimiento($uuid)
    {
       try {
            $users = DB::table('seguimiento_i_n_d_solicitudes')
                ->join('users', 'seguimiento_i_n_d_solicitudes.id_user', '=', 'users.id')
                ->select('seguimiento_i_n_d_solicitudes.*', 'users.nombre')
                ->where('seguimiento_i_n_d_solicitudes.uuid', '=', $uuid)
                ->get();
            return $users;

       } catch (\Throwable $th) {
           log::info($th);
           return false;
       }
        
    }

    public function indexEspecifico($id)
    {
        $get_all = SolicitudTicketINDs::select('solicitud_ticket_i_n_ds.*',DB::raw("CONCAT(DATE_FORMAT(solicitud_ticket_i_n_ds.created_at, '%d%m%Y'),'-',solicitud_ticket_i_n_ds.id,'-',solicitud_ticket_i_n_ds.id_user) as nticket"))
            ->where('solicitud_ticket_i_n_ds.id', '=', $id)
            ->get();
  
        return  $get_all;
    }

    public function store(Request $request)
    {
        try {
            $uuid = Uuid::generate()->string;
            $response = SolicitudTicketINDs::create(array_merge($request->all(), ['uuid' => $uuid]));
            seguimientoINDSolicitudes::create(array_merge($request->all(), ['uuid' => $uuid, 'id_solicitud' => $response->id, 'descripcionSeguimiento' => 'Ticket creado']));
            $id = $request->id_user;
            $userSearch = Users::where('id',$id)->first();
                $ValidarCargo = $userSearch->id_cargo_asociado;     
                $userMail = [];
    
                if($ValidarCargo == null || $ValidarCargo == 0){
                    $userMail = Users::select('email')
                    ->Where('id',$id)
                    ->orWhere('id_cargo_asociado',$id)
                    ->get();
                }else{
                   
                $userMail = Users::select('email')
                ->where('id_cargo_asociado',$ValidarCargo)
                ->orWhere('id',$ValidarCargo)
                ->get();
                }

                if($userMail == [] || $userMail == null){
                    $userMail[0] = 'soporte.rrff@redsalud.gov.cl';
                }
    
                /* $listContactos = [];
                $i = 0;
    
                foreach ($userMail as $key) {
                    $listContactos[$i] = $key->email;
                    $i++;
                } */
    
               $nombre = $request->nombre;
               $descripcionP = $request->descripcionCorreo;
               $id_solicitud = $response->id;
               $titulo = $request->tituloP;
               $validarTicket = 1;
               
                Mail::send('/Mails/TicketGenerado', ['nombre' => $nombre, 'id' => $id_solicitud, 'descripcionTicket' => $descripcionP, 'titulo' => $titulo], function ($message) use($listContactos) {
                    $message->setTo($userMail)->setSubject('Nuevo Ticket Generado');
                    $message->setFrom('soporte.rrff@redsalud.gov.cl', 'Mantencion');
                   
                  });
                  return true;
               
               
                
        } catch (\Throwable $th) {
            if($validarTicket == 1){
                return true;
            }
            else{
                log::info($th);
                return false;
            }
            
        }
    }

    public function destroy($id)
    {
        $estadoEliminado = 7;
        $ticket = SolicitudTicketINDs::find($id);
        $ticket->id_estado = $estadoEliminado;
        $ticket->save();

        return true;
    }
}
