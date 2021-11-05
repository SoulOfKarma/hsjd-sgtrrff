<?php

namespace App\Http\Controllers;

use App\GestionTicketsAps;
use App\SolicitudTicketsAps;
use Illuminate\Http\Request;
use App\Mail\TicketAsignado;
use App\SeguimientoSolicitudes;
use App\Mail\AutoRespuesta;
use App\Supervisores;
use App\Trabajadores;
use App\Users;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;
use DB;

class GestionTicketsApsController extends Controller
{
    public function ValidarTicketAsignadoMod($id)
    {
        $users = GestionTicketsAps::firstWhere('id_solicitud', $id);
        if ($users === null) {
            return 1;
        } else {
            return 2;
        }
    }

    public function ValidarTicketAsignado($id)
    {
        $users = GestionTicketsAps::firstWhere('id_solicitud', $id);
        if ($users === null) {
            return 1;
        } else {
            return 2;
        }
    }

    public function ticketsCategoriaCA()
    {
        $estadoEliminado = 7;
        $users = GestionTicketsAps::select('gestion_tickets_aps.id', 'gestion_tickets_aps.id_trabajador', 'trabajadores.tra_nombre','trabajadores.tra_apellido', 'gestion_tickets_aps.id_solicitud')
            ->join('trabajadores', 'gestion_tickets_aps.id_trabajador', '=', 'trabajadores.id')
            ->join('solicitud_tickets_aps', 'gestion_tickets_aps.id_solicitud', '=', 'solicitud_tickets_aps.id')
            ->where('solicitud_tickets_aps.id_categoria', 4)
            ->where('solicitud_tickets_aps.id_estado', '!=', $estadoEliminado)
            ->get();
        return $users;
    }

    public function GetTicketAsignado($id)
    {
        try {
            $users = GestionTicketsAps::select('gestion_tickets_aps.*','solicitud_tickets_aps.*',)
        ->join('solicitud_tickets_aps','gestion_tickets_aps.id_solicitud','=','solicitud_tickets_aps.id')
        ->where('gestion_tickets_aps.id_solicitud',$id)
        ->get();
        return $users;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
        
    }

    public function AsignarTicketCA(Request $request)
    {
        $validador = false;
        $count = 0;
        try {
            //Gestionando Correo
            $nombre = $request->nombre;
            $descripcionP = $request->descripcionP;
            $id_solicitud = $request->id_solicitud;
            $fecha = $request->fechaInicioFormateada;
            $fechacreacion = $request->fechaCreacion;
            $tituloP = $request->tituloP;
            $nombreTrabajador = $request->desTrabajador;
            $nombreSupervisor = $request->desSupervisor;
            $desEstado = $request->desEstado;
            $desApoyo1 = $request->desApoyo1;
            $desApoyo2 = $request->desApoyo2;
            $desApoyo3 = $request->desApoyo3;
            $id_user = $request->id_user;
            $id_usuarioSolicitante = $request->id_usuarioSolicitante;

        $userSearch = Users::where('id',$id_usuarioSolicitante)->first();
            $ValidarCargo = $userSearch->id_cargo_asociado;     
            $userMail = [];

            if($ValidarCargo == null || $ValidarCargo == 0){
                $userMail = Users::select('email')
                ->Where('id',$id_usuarioSolicitante)
                ->orWhere('id_cargo_asociado',$id_usuarioSolicitante)
                ->first();
            }else{
               
            $userMail = Users::select('email')
            ->where('id_cargo_asociado',$ValidarCargo)
            ->orWhere('id',$ValidarCargo)
            ->first();
            }
            $validador = true;

            $listContactos = [$userMail->email];
            $i = 0;

            $count = count($listContactos);

            /* foreach ($userMail as $key) {
                $listContactos[$i] = $key->email;
                $i++;
            } */

            SeguimientoSolicitudes::create($request->all());
            //Insertando Ticket
            $response2 = SolicitudTicketsAps::where('id', $request->id_solicitud)
                ->update(['id_edificio' => $request->id_edificio, 'id_servicio' => $request->id_servicio,
                'id_ubicacionEx' => $request->id_ubicacionEx, 'id_tipoReparacion' => $request->id_tipoReparacion,
                'id_estado' => $request->id_estado,'id_prioridad' => $request->id_prioridad]);

            $response = GestionTicketsAps::create($request->all());
        } catch (\Throwable $th) {
            if($validador == true){
                log::info($th);
                return true;
              }else{
                  log::info($th);
              return false;
              }
        } finally {
            if($validador == true){
                if($count == 0){
                    return true;
                }else{
                    log::info($th);
                    Mail::send('/Mails/TicketAsignado', ['Apoyo1' => $desApoyo1, 'Apoyo2' => $desApoyo2, 'Apoyo3' => $desApoyo3, 'estado' => $desEstado, 'fechaCreacion' => $fechacreacion, 'nombre' => $nombre, 'id' => $id_solicitud, 'descripcionTicket' => $descripcionP, 'titulo' => $tituloP, 'fecha' => $fecha, 'tra_nombre' => $nombreTrabajador, 'sup_nombre' => $nombreSupervisor], function ($message) use($listContactos){
                        $message->setTo($listContactos)->setSubject('Asignacion de ticket');
                        $message->setFrom('soporte.rrff@redsalud.gov.cl', 'Mantencion');
                        //$message->setBcc(['ricardo.soto.g@redsalud.gov.cl'=> 'Ricardo Soto Gomez']);
                    });
                    return true;
                }
              }else{
                  log::info($th);
                  return false;
              }
        }
    }

    public function getTicketCreado($id)
    {
        return  SolicitudTicketsAps::where('id', $id)->get();
    }

    public function getSolicitudUsuariosJoinCA()
    {
        try {
            $ticket = SolicitudTicketsAps::select('solicitud_tickets_aps.id','solicitud_tickets_aps.uuid',DB::raw("CONCAT(users.nombre,' ',users.apellido) as nombre"),
            'servicios.descripcionServicio','tipo_reparacions.descripcionTipoReparacion','solicitud_tickets_aps.descripcionP','solicitud_tickets_aps.id_estado',
            'estado_solicituds.descripcionEstado', DB::raw('TIMESTAMPDIFF(HOUR,solicitud_tickets_aps.created_at,NOW()) AS Horas'),
            DB::raw("CONCAT(solicitud_tickets_aps.id) as nticket"),
            DB::raw("fnStripTags(solicitud_tickets_aps.descripcionP) as desFormat"),
            DB::raw("(CASE WHEN solicitud_tickets_aps.created_at IS NULL THEN 'PENDIENTE'
            ELSE DATE_FORMAT(solicitud_tickets_aps.created_at,'%d/%m/%Y') END) AS fechaSolicitud"),
            DB::raw("'PENDIENTE' AS nombreTra"))
            ->join('users', 'solicitud_tickets_aps.id_user', '=', 'users.id')
            ->join('estado_solicituds', 'solicitud_tickets_aps.id_estado', '=', 'estado_solicituds.id')
            ->join('tipo_reparacions','solicitud_tickets_aps.id_tipoReparacion','=','tipo_reparacions.id')
            ->join('servicios','solicitud_tickets_aps.id_servicio','=','servicios.id')
            ->where('solicitud_tickets_aps.id_categoria', 4)
            ->where('solicitud_tickets_aps.id_estado', 1);

            $uticket = SolicitudTicketsAps::select('solicitud_tickets_aps.id','solicitud_tickets_aps.uuid',DB::raw("CONCAT(users.nombre,' ',users.apellido) as nombre"),
            'servicios.descripcionServicio','tipo_reparacions.descripcionTipoReparacion','solicitud_tickets_aps.descripcionP','solicitud_tickets_aps.id_estado',
            'estado_solicituds.descripcionEstado', DB::raw('TIMESTAMPDIFF(HOUR,solicitud_tickets_aps.created_at,NOW()) AS Horas'),
            DB::raw("CONCAT(solicitud_tickets_aps.id) as nticket"),
            DB::raw("fnStripTags(solicitud_tickets_aps.descripcionP) as desFormat"),
            DB::raw("(CASE WHEN gestion_tickets_aps.fechaInicio IS NULL THEN 'PENDIENTE'
            ELSE DATE_FORMAT(gestion_tickets_aps.fechaInicio,'%d/%m/%Y') END) AS fechaSolicitud"),
            DB::raw("(CASE WHEN gestion_tickets_aps.id_trabajador IS NULL THEN 'PENDIENTE'
             ELSE CONCAT(trabajadores.tra_nombre,' ',trabajadores.tra_apellido) END) AS nombreTra"))
            ->join('users', 'solicitud_tickets_aps.id_user', '=', 'users.id')
            ->join('estado_solicituds', 'solicitud_tickets_aps.id_estado', '=', 'estado_solicituds.id')
            ->join('tipo_reparacions','solicitud_tickets_aps.id_tipoReparacion','=','tipo_reparacions.id')
            ->join('servicios','solicitud_tickets_aps.id_servicio','=','servicios.id')
            ->join('gestion_tickets_aps', 'solicitud_tickets_aps.id', '=', 'gestion_tickets_aps.id_solicitud')
            ->join('trabajadores', 'gestion_tickets_aps.id_trabajador', '=', 'trabajadores.id')
            ->where('solicitud_tickets_aps.id_categoria', 4)
            ->union($ticket)
            ->orderBy('id','desc')
            ->get();
            return $uticket;
        } catch (\Throwable $th) {
           log::info($th);
           return false;
        }
    }

    public function NuevoTicketCA(Request $request)
    {
        //Insertando Ticket
        try {
            $uuid = Uuid::uuid4();
            $id = SolicitudTicketsAps::create(array_merge($request->all(), ['uuid' => $uuid]))->id;
    
            $response = GestionTicketsAps::create(array_merge($request->all(), ['uuid' => $uuid, 'id_solicitud' => $id]));
    
    
            $nombre = $request->nombre;
            $descripcionP = $request->descripcionCorreo;
            $id_solicitud = $id;
            $fecha = $request->fechaInicio;
            $tituloP = $request->tituloP;
            $id_user = $request->id_user;
    
            $userSearch = Users::where('id',$id_user)->first();
                $ValidarCargo = $userSearch->id_cargo_asociado;     
                $userMail = [];
    
                if($ValidarCargo == null || $ValidarCargo == 0){
                    $userMail = Users::select('email')
                    ->Where('id',$id_user)
                    ->orWhere('id_cargo_asociado',$id_user)
                    ->first();
                }else{
                   
                $userMail = Users::select('email')
                ->where('id_cargo_asociado',$ValidarCargo)
                ->orWhere('id',$ValidarCargo)
                ->first();
                }
    
                $listContactos = [$userMail->email];
                $i = 0;
    
                /* foreach ($userMail as $key) {
                    $listContactos[$i] = $key->email;
                    $i++;
                } */
    
            $descripcionSeguimiento = "Se a creado el Ticket N°" . $id_solicitud . " por el Usuario: " . $nombre;
    
            $idTrabajador = $request->id_trabajador;
            $idSupervisor = $request->id_supervisor;
    
            $trabajador = Trabajadores::where('id', $idTrabajador)->first();
            $supervisor = Supervisores::where('id', $idSupervisor)->first();
    
            $nombreTrabajador = $trabajador->tra_nombre . " " .$trabajador->tra_apellido;
            $nombreSupervisor = $supervisor->sup_nombre . " " .$supervisor->sup_apellido;
    
            SeguimientoSolicitudes::create(array_merge($request->all(), ['uuid' => $uuid, 'id_solicitud' => $id_solicitud, 'descripcionSeguimiento' => $descripcionSeguimiento]));
    
            Mail::send('/Mails/TicketGeneradoAgente', ['nombre' => $nombre, 'id' => $id_solicitud, 'descripcionTicket' => $descripcionP, 'titulo' => $tituloP, 'fecha' => $fecha, 'tra_nombre' => $nombreTrabajador, 'sup_nombre' => $nombreSupervisor], function ($message) use($listContactos){
                $message->setTo($listContactos)->setSubject('Nueva Creacion de ticket');
                $message->setFrom('soporte.rrff@redsalud.gov.cl', 'Mantencion');
               // $message->setBcc(['ricardo.soto.g@redsalud.gov.cl'=> 'Ricardo Soto Gomez']);
            });
    
            return $response;
        } catch (\Throwable $th) {
            return false;
        }
        
    }

    public function ModificarCategoria(Request $request)
    {
        try {
            SolicitudTicketsAps::where('id', $request->idsolicitud)
                ->where('uuid', $request->uuid)
                ->update(['id_categoria' => $request->idCategoria]);

            $seguimiento = new SeguimientoSolicitudes();

            $seguimiento->id_solicitud = $request->idSolicitud;
            $seguimiento->uuid = $request->uuid;
            $seguimiento->descripcionSeguimiento = "El agente " . $request->nombre . " a derivado el Ticket N°" . $request->idSolicitud . " a " . $request->des_categoria . "";
            $seguimiento->id_user = $request->id_user;

            $seguimiento->save();

            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return $th;
        }
    }

    public function modificarTicketCA(Request $request)
    {
        try {
            //Gestionando Correo
            $nombre = $request->nombre;
            $descripcionP = $request->descripcionP;
            $id_solicitud = $request->id_solicitud;
            $fecha = $request->fechaCambiadaFormateada;
            $fechacreacion = $request->fechaCreacion;
            $tituloP = $request->tituloP;
            $nombreTrabajador = $request->desTrabajador;
            $nombreSupervisor = $request->desSupervisor;
            $desEstado = $request->desEstado;
            $desApoyo1 = $request->desApoyo1;
            $desApoyo2 = $request->desApoyo2;
            $desApoyo3 = $request->desApoyo3;
            $id_user = $request->id_user;
            $id_busqueda_solicitante = $request->idUsuarioSesion;
            $descripcionSeguimiento = $request->descripcionSeguimiento;
            $razoncambio = $request->razoncambio;


            SeguimientoSolicitudes::create($request->all());


            $response2 = SolicitudTicketsAps::where('uuid', $request->uuid)
                ->where('id', $request->id_solicitud)
                ->update([
                    'id_edificio' => $request->id_edificio, 'id_servicio' => $request->id_servicio,
                    'id_ubicacionEx' => $request->id_ubicacionEx, 'id_tipoReparacion' => $request->id_tipoReparacion,
                    'id_estado' => $request->id_estado,'id_prioridad' => $request->id_prioridad,
                    'descripcionP' => $request->descripcionPFormat
                ]);
            $response = GestionTicketsAps::where('uuid', $request->uuid)
                ->where('id_solicitud', $request->id_solicitud)
                ->update([
                    'id_supervisor' => $request->id_supervisor, 'id_trabajador' => $request->id_trabajador,
                    'idApoyo1' => $request->idApoyo1, 'idApoyo2' => $request->idApoyo2,
                    'idApoyo3' => $request->idApoyo3, 'idTurno' => $request->idTurno,
                    'horaCambiada' => $request->horaCambiada,
                    'fechaCambiada' => $request->fechaCambiada, 'horaTermino' => $request->horaTermino,
                    'fechaTermino' => $request->fechaTermino
                ]);

                $userSearch = Users::where('id',$id_busqueda_solicitante)->first();
                $ValidarCargo = $userSearch->id_cargo_asociado;     
                $userMail = [];
    
                if($ValidarCargo == null || $ValidarCargo == 0){
                    $userMail = Users::select('email')
                    ->Where('id',$id_busqueda_solicitante)
                    ->orWhere('id_cargo_asociado',$id_busqueda_solicitante)
                    ->first();
                }else{
                   
                $userMail = Users::select('email')
                ->where('id_cargo_asociado',$ValidarCargo)
                ->orWhere('id',$ValidarCargo)
                ->first();
                }
    
                $listContactos = [$userMail->email];
                $i = 0;
    
                /* foreach ($userMail as $key) {
                    $listContactos[$i] = $key->email;
                    $i++;
                } */
                Mail::send('/Mails/TicketModificadoAgente',['Apoyo1' => $desApoyo1, 'Apoyo2' => $desApoyo2, 'Apoyo3' => $desApoyo3, 'estado' => $desEstado, 'fechaCreacion' => $fechacreacion, 'nombre' => $nombre, 'id' => $id_solicitud, 'descripcionTicket' => $descripcionP, 'titulo' => $tituloP, 'fecha' => $fecha, 'tra_nombre' => $nombreTrabajador, 'sup_nombre' => $nombreSupervisor, 'razon' => $razoncambio], function ($message) use($listContactos){
                    $message->setTo($listContactos)->setSubject('Modificacion de ticket');
                    $message->setFrom('soporte.rrff@redsalud.gov.cl', 'Mantencion');
                   // $message->setBcc(['ricardo.soto.g@redsalud.gov.cl'=> 'Ricardo Soto Gomez']);
                });
                return $response;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
        //Modificando Ticket
    }

    public function destroy(Request $request)
    {
        /* GestionSolicitudes::where('id_solicitud', $id)->delete();
        SolicitudTickets::where('id', $id)->delete(); */
        $id = $request->id_solicitud;
        $nombre = $request->nombre;
        $razon = $request->razonEliminacion;
        $descripcionSeguimiento = $request->descripcionSeguimiento;
        $seguimientoRazon = SeguimientoSolicitudes::create($request->all());
        $estadoEliminado = 7;
        $ticket = SolicitudTicketsAps::find($id);
        $idUser = $ticket->id_user;
        $ticket->id_estado = $estadoEliminado;
        $ticket->save();

        $userSearch = Users::where('id',$idUser)->first();
                $ValidarCargo = $userSearch->id_cargo_asociado;     
                $userMail = [];
    
                if($ValidarCargo == null || $ValidarCargo == 0){
                    $userMail = Users::select('email')
                    ->Where('id',$idUser)
                    ->orWhere('id_cargo_asociado',$idUser)
                    ->first();
                }else{
                   
                $userMail = Users::select('email')
                ->where('id_cargo_asociado',$ValidarCargo)
                ->orWhere('id',$ValidarCargo)
                ->first();
                }
    
                $listContactos = [$userMail->email];
                $i = 0;
    
                /* foreach ($userMail as $key) {
                    $listContactos[$i] = $key->email;
                    $i++;
                } */

                Mail::send('/Mails/TicketEliminado', ['nombre' => $nombre, 'id_solicitud' => $id, 'descripcionSeguimiento' => $razon], function ($message) use($listContactos) {
                    $message->setTo($listContactos)->setSubject('Seguimiento de ticket');
                    $message->setFrom('soporte.rrff@redsalud.gov.cl', 'Mantencion');
                   // $message->setBcc(['ricardo.soto.g@redsalud.gov.cl'=> 'Ricardo Soto Gomez']);
                });

        return true;
    }

    public function FinalizarTicket(Request $request){

        $id = $request->id_solicitud;
        $nombre = $request->nombre;
        $descripcionSeguimiento = $request->descripcionSeguimiento;
        $seguimientoRazon = SeguimientoSolicitudes::create($request->all());
        $estadoFinalizado = 6;
        $ticket = SolicitudTicketsAps::find($id);
        $idUser = $ticket->id_user;
        $ticket->id_estado = $estadoFinalizado;
        $ticket->save();

        $userSearch = Users::where('id',$idUser)->first();
                $ValidarCargo = $userSearch->id_cargo_asociado;     
                $userMail = [];
    
                if($ValidarCargo == null || $ValidarCargo == 0){
                    $userMail = Users::select('email')
                    ->Where('id',$idUser)
                    ->orWhere('id_cargo_asociado',$idUser)
                    ->first();
                }else{
                   
                $userMail = Users::select('email')
                ->where('id_cargo_asociado',$ValidarCargo)
                ->orWhere('id',$ValidarCargo)
                ->first();
                }
    
                $listContactos = [$userMail->email];
                $i = 0;
    
                /* foreach ($userMail as $key) {
                    $listContactos[$i] = $key->email;
                    $i++;
                } */

                Mail::send('/Mails/TicketFinalizado', ['nombre' => $nombre, 'id_solicitud' => $id], function ($message) use($listContactos) {
                    $message->setTo($listContactos)->setSubject('Finalizacion de ticket');
                    $message->setFrom('soporte.rrff@redsalud.gov.cl', 'Mantencion');
                   // $message->setBcc(['ricardo.soto.g@redsalud.gov.cl'=> 'Ricardo Soto Gomez']);
                });

        return true;

    }

}
