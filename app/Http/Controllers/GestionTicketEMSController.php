<?php

namespace App\Http\Controllers;

use App\GestionTicketEMS;
use Illuminate\Http\Request;
use App\Mail\TicketAsignado;
use App\seguimientoEMSolicitudes;
use App\SolicitudTicketsEM;
use App\Mail\AutoRespuesta;
use App\Supervisores;
use App\Trabajadores;
use App\Users;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;
use App\DetalleSolicitudEMs;
use DB;

class GestionTicketEMSController extends Controller
{
    public function ValidarTicketAsignadoMod($id)
    {
        $users = GestionTicketEMS::firstWhere('id_solicitud', $id);
        if ($users === null) {
            return 1;
        } else {
            return 2;
        }
    }

    public function ValidarTicketAsignado($id)
    {
        $users = GestionTicketEMS::firstWhere('id_solicitud', $id);
        if ($users === null) {
            return 1;
        } else {
            return 2;
        }
    }

    public function ticketsCategoriaEM()
    {
        $estadoEliminado = 7;
        $users = GestionTicketEMS::select('gestion_ticket_e_m_s.id', 'gestion_ticket_e_m_s.id_trabajador', 'trabajadores.tra_nombre','trabajadores.tra_apellido', 'gestion_ticket_e_m_s.id_solicitud')
            ->join('trabajadores', 'gestion_ticket_e_m_s.id_trabajador', '=', 'trabajadores.id')
            ->join('solicitud_tickets_e_m_s', 'gestion_ticket_e_m_s.id_solicitud', '=', 'solicitud_tickets_e_m_s.id')
            ->where('solicitud_tickets_e_m_s.id_categoria', 2)
            ->where('solicitud_tickets_e_m_s.id_estado', '!=', $estadoEliminado)
            ->get();
        return $users;
    }

    public function GetTicketAsignado($id)
    {
        try {
            $users = GestionTicketEMS::select('gestion_ticket_e_m_s.*','solicitud_tickets_e_m_s.*',)
        ->join('solicitud_tickets_e_m_s','gestion_ticket_e_m_s.id_solicitud','=','solicitud_tickets_e_m_s.id')
        ->where('gestion_ticket_e_m_s.id_solicitud',$id)
        ->get();
        return $users;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
        
    }

    public function getTicketCreado($id)
    {
        return  SolicitudTicketsEM::where('id', $id)->get();
    }

    public function AsignarTicketEM(Request $request)
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

            seguimientoEMSolicitudes::create($request->all());
            //Insertando Ticket
            $response2 = SolicitudTicketsEM::where('id', $request->id_solicitud)
                ->update(['id_edificio' => $request->id_edificio, 'id_servicio' => $request->id_servicio,
                 'id_ubicacionEx' => $request->id_ubicacionEx, 'id_tipoReparacion' => $request->id_tipoReparacion,
                  'id_estado' => $request->id_estado,'id_prioridad' => $request->id_prioridad,'descripcionP' => $request->descripcionP]);

            DetalleSolicitudEMs::updateOrCreate([
                'id_solicitud' => $request->id_solicitud,
            //],[
                'desresolucionresultados' => $request->desresolucionresultados,
                'desobservaciones' => $request->desobservaciones,
                'id_danoEQ' => $request->id_danoEQ
            ]);  

            $response = GestionTicketEMS::create($request->all());

            $validador = true;

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
            

            $listContactos = [$userMail->email];
            $i = 0;
            $count = count($listContactos);
            /* foreach ($userMail as $key) {
                $listContactos[$i] = $key->email;
                $i++;
            } */

            if($validador == true){
                if($count == 0){
                    return true;
                }else{
                    Mail::send('/Mails/TicketAsignado', ['Apoyo1' => $desApoyo1, 'Apoyo2' => $desApoyo2, 'Apoyo3' => $desApoyo3, 'estado' => $desEstado, 'fechaCreacion' => $fechacreacion, 'nombre' => $nombre, 'id' => $id_solicitud, 'descripcionTicket' => $descripcionP, 'titulo' => $tituloP, 'fecha' => $fecha, 'tra_nombre' => $nombreTrabajador, 'sup_nombre' => $nombreSupervisor], function ($message) use($listContactos){
                        $message->setTo($listContactos)->setSubject('Asignacion de ticket');
                        $message->setFrom('soporte.rrff@redsalud.gov.cl', 'Mantencion');
                        //$message->setBcc(['ricardo.soto.g@redsalud.gov.cl'=> 'Ricardo Soto Gomez']);
                    });
                    return true;
                }
              }else{
                  log::info("Error al Enviar Correo");
                  return false;
              }
            
        } catch (\Throwable $th) {
            if($validador == true){
                log::info($th);
                return true;
              }else{
                  log::info($th);
              return false;
              }
        }
    }

    public function getSolicitudUsuariosJoinEM()
    {
        try {
            $ticket = SolicitudTicketsEM::select('solicitud_tickets_e_m_s.id','solicitud_tickets_e_m_s.id_categoria','solicitud_tickets_e_m_s.uuid',DB::raw("CONCAT(users.nombre,' ',users.apellido) as nombre"),
            'servicios.descripcionServicio','tipo_reparacions.descripcionTipoReparacion','solicitud_tickets_e_m_s.descripcionP','solicitud_tickets_e_m_s.id_estado',
            'estado_solicituds.descripcionEstado', DB::raw('TIMESTAMPDIFF(HOUR,solicitud_tickets_e_m_s.created_at,NOW()) AS Horas'),
            DB::raw("CONCAT(solicitud_tickets_e_m_s.id) as nticket"),
            DB::raw("fnStripTags(solicitud_tickets_e_m_s.descripcionP) as desFormat"),
            DB::raw("(CASE WHEN solicitud_tickets_e_m_s.created_at IS NULL THEN 'PENDIENTE'
            ELSE DATE_FORMAT(solicitud_tickets_e_m_s.created_at,'%d/%m/%Y') END) AS fechaSolicitud"),
            DB::raw("'PENDIENTE' AS nombreTra"))
            ->join('users', 'solicitud_tickets_e_m_s.id_user', '=', 'users.id')
            ->join('estado_solicituds', 'solicitud_tickets_e_m_s.id_estado', '=', 'estado_solicituds.id')
            ->join('tipo_reparacions','solicitud_tickets_e_m_s.id_tipoReparacion','=','tipo_reparacions.id')
            ->join('servicios','solicitud_tickets_e_m_s.id_servicio','=','servicios.id')
            ->where('solicitud_tickets_e_m_s.id_categoria', 2)
            ->where('solicitud_tickets_e_m_s.id_estado', 1)
            ->orWhere('solicitud_tickets_e_m_s.id_estado', 9)
            ->orWhere('solicitud_tickets_e_m_s.id_estado', 7);

            $uticket = SolicitudTicketsEM::select('solicitud_tickets_e_m_s.id','solicitud_tickets_e_m_s.id_categoria','solicitud_tickets_e_m_s.uuid',DB::raw("CONCAT(users.nombre,' ',users.apellido) as nombre"),
            'servicios.descripcionServicio','tipo_reparacions.descripcionTipoReparacion','solicitud_tickets_e_m_s.descripcionP','solicitud_tickets_e_m_s.id_estado',
            'estado_solicituds.descripcionEstado', DB::raw('TIMESTAMPDIFF(HOUR,solicitud_tickets_e_m_s.created_at,NOW()) AS Horas'),
            DB::raw("CONCAT(solicitud_tickets_e_m_s.id) as nticket"),
            DB::raw("fnStripTags(solicitud_tickets_e_m_s.descripcionP) as desFormat"),
            DB::raw("(CASE WHEN gestion_ticket_e_m_s.fechaInicio IS NULL THEN 'PENDIENTE'
            ELSE DATE_FORMAT(gestion_ticket_e_m_s.fechaInicio,'%d/%m/%Y') END) AS fechaSolicitud"),
            DB::raw("(CASE WHEN gestion_ticket_e_m_s.id_trabajador IS NULL THEN 'PENDIENTE'
             ELSE CONCAT(trabajadores.tra_nombre,' ',trabajadores.tra_apellido) END) AS nombreTra"))
            ->join('users', 'solicitud_tickets_e_m_s.id_user', '=', 'users.id')
            ->join('estado_solicituds', 'solicitud_tickets_e_m_s.id_estado', '=', 'estado_solicituds.id')
            ->join('tipo_reparacions','solicitud_tickets_e_m_s.id_tipoReparacion','=','tipo_reparacions.id')
            ->join('servicios','solicitud_tickets_e_m_s.id_servicio','=','servicios.id')
            ->join('gestion_ticket_e_m_s', 'solicitud_tickets_e_m_s.id', '=', 'gestion_ticket_e_m_s.id_solicitud')
            ->join('trabajadores', 'gestion_ticket_e_m_s.id_trabajador', '=', 'trabajadores.id')
            ->where('solicitud_tickets_e_m_s.id_categoria', 2)
            ->where('solicitud_tickets_e_m_s.id_estado','!=', 7)
            ->union($ticket)
            ->where('solicitud_tickets_e_m_s.created_at','>',DB::raw('DATE_SUB(now(), INTERVAL 6 MONTH)'))
            ->orderBy('id','desc')
            ->get();
            return $uticket;
        } catch (\Throwable $th) {
           log::info($th);
           return false;
        }
    }

    public function getSolicitudUsuariosJoinEMH()
    {
        try {
            $ticket = SolicitudTicketsEM::select('solicitud_tickets_e_m_s.id','solicitud_tickets_e_m_s.id_categoria','solicitud_tickets_e_m_s.uuid',DB::raw("CONCAT(users.nombre,' ',users.apellido) as nombre"),
            'servicios.descripcionServicio','tipo_reparacions.descripcionTipoReparacion','solicitud_tickets_e_m_s.descripcionP','solicitud_tickets_e_m_s.id_estado',
            'estado_solicituds.descripcionEstado', DB::raw('TIMESTAMPDIFF(HOUR,solicitud_tickets_e_m_s.created_at,NOW()) AS Horas'),
            DB::raw("CONCAT(solicitud_tickets_e_m_s.id) as nticket"),
            DB::raw("fnStripTags(solicitud_tickets_e_m_s.descripcionP) as desFormat"),
            DB::raw("(CASE WHEN solicitud_tickets_e_m_s.created_at IS NULL THEN 'PENDIENTE'
            ELSE DATE_FORMAT(solicitud_tickets_e_m_s.created_at,'%d/%m/%Y') END) AS fechaSolicitud"),
            DB::raw("'PENDIENTE' AS nombreTra"))
            ->join('users', 'solicitud_tickets_e_m_s.id_user', '=', 'users.id')
            ->join('estado_solicituds', 'solicitud_tickets_e_m_s.id_estado', '=', 'estado_solicituds.id')
            ->join('tipo_reparacions','solicitud_tickets_e_m_s.id_tipoReparacion','=','tipo_reparacions.id')
            ->join('servicios','solicitud_tickets_e_m_s.id_servicio','=','servicios.id')
            ->where('solicitud_tickets_e_m_s.id_categoria', 2)
            ->where('solicitud_tickets_e_m_s.id_estado', 1)
            ->orWhere('solicitud_tickets_e_m_s.id_estado', 9)
            ->orWhere('solicitud_tickets_e_m_s.id_estado', 7);

            $uticket = SolicitudTicketsEM::select('solicitud_tickets_e_m_s.id','solicitud_tickets_e_m_s.id_categoria','solicitud_tickets_e_m_s.uuid',DB::raw("CONCAT(users.nombre,' ',users.apellido) as nombre"),
            'servicios.descripcionServicio','tipo_reparacions.descripcionTipoReparacion','solicitud_tickets_e_m_s.descripcionP','solicitud_tickets_e_m_s.id_estado',
            'estado_solicituds.descripcionEstado', DB::raw('TIMESTAMPDIFF(HOUR,solicitud_tickets_e_m_s.created_at,NOW()) AS Horas'),
            DB::raw("CONCAT(solicitud_tickets_e_m_s.id) as nticket"),
            DB::raw("fnStripTags(solicitud_tickets_e_m_s.descripcionP) as desFormat"),
            DB::raw("(CASE WHEN gestion_ticket_e_m_s.fechaInicio IS NULL THEN 'PENDIENTE'
            ELSE DATE_FORMAT(gestion_ticket_e_m_s.fechaInicio,'%d/%m/%Y') END) AS fechaSolicitud"),
            DB::raw("(CASE WHEN gestion_ticket_e_m_s.id_trabajador IS NULL THEN 'PENDIENTE'
             ELSE CONCAT(trabajadores.tra_nombre,' ',trabajadores.tra_apellido) END) AS nombreTra"))
            ->join('users', 'solicitud_tickets_e_m_s.id_user', '=', 'users.id')
            ->join('estado_solicituds', 'solicitud_tickets_e_m_s.id_estado', '=', 'estado_solicituds.id')
            ->join('tipo_reparacions','solicitud_tickets_e_m_s.id_tipoReparacion','=','tipo_reparacions.id')
            ->join('servicios','solicitud_tickets_e_m_s.id_servicio','=','servicios.id')
            ->join('gestion_ticket_e_m_s', 'solicitud_tickets_e_m_s.id', '=', 'gestion_ticket_e_m_s.id_solicitud')
            ->join('trabajadores', 'gestion_ticket_e_m_s.id_trabajador', '=', 'trabajadores.id')
            ->where('solicitud_tickets_e_m_s.id_categoria', 2)
            ->where('solicitud_tickets_e_m_s.id_estado','!=', 7)
            ->union($ticket)
            ->orderBy('id','desc')
            ->get();
            return $uticket;
        } catch (\Throwable $th) {
           log::info($th);
           return false;
        }
    }

    public function NuevoTicketEM(Request $request)
    {
        $validador = false;
        //Insertando Ticket
        try {
            $uuid = Uuid::uuid4();
        $id = SolicitudTicketsEM::create(array_merge($request->all(), ['uuid' => $uuid]))->id;

        $response = GestionTicketEMS::create(array_merge($request->all(), ['uuid' => $uuid, 'id_solicitud' => $id]));

        DetalleSolicitudEMs::updateOrCreate([
            'id_solicitud' => $id,
        ],[
            'desresolucionresultados' => $request->desresolucionresultados,
            'desobservaciones' => $request->desobservaciones,
            'id_danoEQ' => $request->id_danoEQ
        ]);


        $nombre = $request->nombre;
        $descripcionP = $request->descripcionCorreo;
        $id_solicitud = $id;
        $fecha = $request->fechaInicio;
        $tituloP = $request->tituloP;
        $id_user = $request->id_user;

        $validador = true;

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

        seguimientoEMSolicitudes::create(array_merge($request->all(), ['uuid' => $uuid, 'id_solicitud' => $id_solicitud, 'descripcionSeguimiento' => $descripcionSeguimiento]));

        Mail::send('/Mails/TicketGeneradoAgente', ['nombre' => $nombre, 'id' => $id_solicitud, 'descripcionTicket' => $descripcionP, 'titulo' => $tituloP, 'fecha' => $fecha, 'tra_nombre' => $nombreTrabajador, 'sup_nombre' => $nombreSupervisor], function ($message) use($listContactos){
            $message->setTo($listContactos)->setSubject('Nueva Creacion de ticket');
            $message->setFrom('soporte.rrff@redsalud.gov.cl', 'Mantencion');
               // $message->setBcc(['ricardo.soto.g@redsalud.gov.cl'=> 'Ricardo Soto Gomez']);
        });

        return $response;
        } catch (\Throwable $th) {
            if($validador == true){
                log::info($th);
                return true;
              }else{
                  log::info($th);
              return false;
              }
        }
        
    }

    public function modificarTicketEM(Request $request)
    {
        $validador = false;
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
            $id_busqueda_solicitante = $request->id_user;
            $descripcionSeguimiento = $request->descripcionSeguimiento;
            $razoncambio = $request->razoncambio;

            seguimientoEMSolicitudes::create($request->all());


            $response2 = SolicitudTicketsEM::where('uuid', $request->uuid)
                ->where('id', $request->id_solicitud)
                ->update([
                    'id_edificio' => $request->id_edificio, 'id_servicio' => $request->id_servicio,
                    'id_ubicacionEx' => $request->id_ubicacionEx, 'id_tipoReparacion' => $request->id_tipoReparacion,
                    'id_estado' => $request->id_estado,'id_prioridad' => $request->id_prioridad
                ]);
            $response = GestionTicketEMS::where('uuid', $request->uuid)
                ->where('id_solicitud', $request->id_solicitud)
                ->update([
                    'id_supervisor' => $request->id_supervisor, 'id_trabajador' => $request->id_trabajador,
                    'idApoyo1' => $request->idApoyo1, 'idApoyo2' => $request->idApoyo2,
                    'idApoyo3' => $request->idApoyo3, 'idTurno' => $request->idTurno,
                    'horaCambiada' => $request->horaCambiada,
                    'fechaCambiada' => $request->fechaCambiada, 'horaTermino' => $request->horaTermino,
                    'fechaTermino' => $request->fechaTermino
                ]);


            DetalleSolicitudEMs::updateOrCreate([
                'id_solicitud' => $request->id_solicitud,
            ],[
                'desresolucionresultados' => $request->desresolucionresultados,
                'desobservaciones' => $request->desobservaciones,
                'id_danoEQ' => $request->idDanio
            ]);

            $validador = true;

                $userSearch = Users::where('id',$id_user)->first();
                $ValidarCargo = [];
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
                    //$message->setBcc(['ricardo.soto.g@redsalud.gov.cl'=> 'Ricardo Soto Gomez']);
                });
                
                return $response;
        } catch (\Throwable $th) {
            if($validador == true){
                log::info($th);
                return true;
              }else{
                  log::info($th);
              return false;
              }
        } 
    }

    public function PostCierreTicket(Request $request){
        try {
                $res = GestionTicketEMS::where('id_solicitud',$request->id_solicitud)
                 ->update(['horasEjecucion' => $request->horasEjecucion,'horaTermino' => $request->horaTermino,'fechaTermino' => $request->fechaTermino]);
                 $res2 = SolicitudTicketsEM::where('id',$request->id_solicitud)
                 ->update(['id_estado' => $request->id_estado]);
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function destroy(Request $request)
    {
        $validador = false;
        try {
            /* GestionSolicitudes::where('id_solicitud', $id)->delete();
            SolicitudTickets::where('id', $id)->delete(); */
            $id = $request->id_solicitud;
            $nombre = $request->nombre;
            $razon = $request->razonEliminacion;
            $descripcionSeguimiento = $request->descripcionSeguimiento;
            $seguimientoRazon = seguimientoEMSolicitudes::create($request->all());
            $estadoEliminado = 7;
            $ticket = SolicitudTicketsEM::find($id);
            $idUser = $ticket->id_user;
            $ticket->id_estado = $estadoEliminado;
            $ticket->save();

            $validador = true;

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
        } catch (\Throwable $th) {
            if($validador == true){
                log::info($th);
                return true;
              }else{
                  log::info($th);
              return false;
              }
        }
        
    }

    public function FinalizarTicket(Request $request){
        $validador = false;
        try {
        $id = $request->id_solicitud;
        $nombre = $request->nombre;
        $descripcionSeguimiento = $request->descripcionSeguimiento;
        $seguimientoRazon = SeguimientoSolicitudes::create($request->all());
        $estadoFinalizado = 6;
        $ticket = SolicitudTicketsEM::find($id);
        $idUser = $ticket->id_user;
        $ticket->id_estado = $estadoFinalizado;
        $ticket->save();

        $validador = true;

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
        } catch (\Throwable $th) {
            if($validador == true){
                log::info($th);
                return true;
              }else{
                  log::info($th);
              return false;
              }
        }

        

    }

    public function PostMensajeCorreo(Request $request){
        try {
                $solicitud = SolicitudTicketsEM::where('id',$request->idSolicitud)
                ->first();    

                $userSearch = Users::where('id',$solicitud->id_user)->first();

                $Contacto = [$userSearch->email];

                $mensaje = $request->mensajeCorreo;
    
                /* foreach ($userMail as $key) {
                    $listContactos[$i] = $key->email;
                    $i++;
                } */

                Mail::send('/Mails/MensajeUsuarioEM', ['nombre' => $userSearch->nombre, 'id_solicitud' => $request->idSolicitud, 'mensaje' => $mensaje], function ($message) use($Contacto) {
                    $message->setTo($Contacto)->setSubject('Nuevo Mensaje');
                    $message->setFrom('soporte.rrff@redsalud.gov.cl', 'Mantencion');
                   // $message->setBcc(['ricardo.soto.g@redsalud.gov.cl'=> 'Ricardo Soto Gomez']);
                });
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PutFechas(Request $request){
        try {
            SolicitudTicketsEM::where('id',$request->idSolicitud)
            ->update([
                'created_at' => $request->fechaSolicitud
            ]);

            GestionTicketEMS::where('id_solicitud',$request->idSolicitud)
            ->update([
                'fechaInicio' => $request->fechaAsignacion,
                'fechaTermino' => $request->fechaTermino
            ]);

            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
}
