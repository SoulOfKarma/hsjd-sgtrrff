<?php

namespace App\Http\Controllers;

use App\GestionSolicitudes;
use App\Mail\TicketAsignado;
use App\SeguimientoSolicitudes;
use App\SolicitudTickets;
use App\Mail\AutoRespuesta;
use App\Supervisores;
use App\Trabajadores;
use App\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;
use DB;

class GestionTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function ticketsAll()
    {
        $ticket = SolicitudTickets::select('solicitud_tickets.*', 'users.nombre', 'users.apellido', 'estado_solicituds.descripcionEstado', DB::raw('TIMESTAMPDIFF(HOUR,solicitud_tickets.created_at,NOW()) AS Horas'), DB::raw("CONCAT(DATE_FORMAT(solicitud_tickets.created_at, '%d%m%Y'),'-',solicitud_tickets.id,'-',solicitud_tickets.id_user) as nticket"))
            ->join('users', 'solicitud_tickets.id_user', '=', 'users.id')
            ->join('estado_solicituds', 'solicitud_tickets.id_estado', '=', 'estado_solicituds.id')
            ->orderBy('solicitud_tickets.id', 'desc')
            ->get();
        return  $ticket;
    }

    public function ticketsCategoriaInfra()
    {
        $estadoEliminado = 7;
        $users = GestionSolicitudes::select('gestion_solicitudes.id', 'gestion_solicitudes.id_trabajador', 'trabajadores.tra_nombre','trabajadores.tra_apellido', 'gestion_solicitudes.id_solicitud','gestion_solicitudes.idTurno')
            ->join('trabajadores', 'gestion_solicitudes.id_trabajador', '=', 'trabajadores.id')
            ->join('solicitud_tickets', 'gestion_solicitudes.id_solicitud', '=', 'solicitud_tickets.id')
            ->where('solicitud_tickets.id_categoria', 1)
            ->where('solicitud_tickets.id_estado', '!=', $estadoEliminado)
            ->get();
        return $users;
    }

    public function ticketsCategoriaEM()
    {
        $estadoEliminado = 7;
        $users = GestionSolicitudes::select('gestion_solicitudes.id', 'gestion_solicitudes.id_trabajador', 'trabajadores.tra_nombre','trabajadores.tra_apellido', 'gestion_solicitudes.id_solicitud')
            ->join('trabajadores', 'gestion_solicitudes.id_trabajador', '=', 'trabajadores.id')
            ->join('solicitud_tickets', 'gestion_solicitudes.id_solicitud', '=', 'solicitud_tickets.id')
            ->where('solicitud_tickets.id_categoria', 2)
            ->where('solicitud_tickets.id_estado', '!=', $estadoEliminado)
            ->get();
        return $users;
    }

    public function ticketsCategoriaIND()
    {
        $estadoEliminado = 7;
        $users = GestionSolicitudes::select('gestion_solicitudes.id', 'gestion_solicitudes.id_trabajador', 'trabajadores.tra_nombre','trabajadores.tra_apellido', 'gestion_solicitudes.id_solicitud')
            ->join('trabajadores', 'gestion_solicitudes.id_trabajador', '=', 'trabajadores.id')
            ->join('solicitud_tickets', 'gestion_solicitudes.id_solicitud', '=', 'solicitud_tickets.id')
            ->where('solicitud_tickets.id_categoria', 3)
            ->where('solicitud_tickets.id_estado', '!=', $estadoEliminado)
            ->get();
        return $users;
    }

    public function ticketsCategoriaCA()
    {
        $estadoEliminado = 7;
        $users = GestionSolicitudes::select('gestion_solicitudes.id', 'gestion_solicitudes.id_trabajador', 'trabajadores.tra_nombre','trabajadores.tra_apellido', 'gestion_solicitudes.id_solicitud')
            ->join('trabajadores', 'gestion_solicitudes.id_trabajador', '=', 'trabajadores.id')
            ->join('solicitud_tickets', 'gestion_solicitudes.id_solicitud', '=', 'solicitud_tickets.id')
            ->where('solicitud_tickets.id_categoria', 4)
            ->where('solicitud_tickets.id_estado', '!=', $estadoEliminado)
            ->get();
        return $users;
    }

    public function getTicketCreado($id)
    {
        return  SolicitudTickets::where('id', $id)->get();
    }

    public function getUsuarios()
    {
        //Traer a todos los usuarios
        $users = Users::select('id',DB::raw("CONCAT(nombre,' ',apellido) as nombre"))
        ->get();
        return  $users;
    }


    public function ValidarTicketAsignadoMod($id)
    {
        $users = GestionSolicitudes::firstWhere('id_solicitud', $id);
        if ($users === null) {
            return 1;
        } else {
            return 2;
        }
    }

    public function ValidarTicketAsignado($id)
    {
        $users = GestionSolicitudes::firstWhere('id_solicitud', $id);
        if ($users === null) {
            return 1;
        } else {
            return 2;
        }
    }

    public function GetTicketAsignado($id)
    {
        $users = GestionSolicitudes::firstWhere('id_solicitud', $id);
        return $users;
    }

    public function GetDatoCalendario()
    {
        $estadoEliminado = 7;
        $estadoEliminado2 = 1;
        $users = SolicitudTickets::select('solicitud_tickets.id','edificios.descripcionEdificio','servicios.descripcionServicio','unidad_esps.descripcionUnidadEsp',DB::raw("CONCAT(users.nombre,' ',users.apellido) as nombrecompleto"),DB::raw("CONCAT(DATE_FORMAT(solicitud_tickets.created_at, '%d%m%Y'),'-',solicitud_tickets.id,'-',solicitud_tickets.id_user) as nticket"), 'solicitud_tickets.uuid', 'solicitud_tickets.descripcionP', 'solicitud_tickets.tituloP', 'solicitud_tickets.created_at', 'gestion_solicitudes.id_trabajador', 'trabajadores.tra_nombre','trabajadores.tra_apellido', 'gestion_solicitudes.horaInicio', 'gestion_solicitudes.fechaInicio', 'gestion_solicitudes.horaTermino', 'gestion_solicitudes.fechaTermino')
            ->join('gestion_solicitudes', 'solicitud_tickets.id', '=', 'gestion_solicitudes.id_solicitud')
            ->join('trabajadores', 'gestion_solicitudes.id_trabajador', '=', 'trabajadores.id')
            ->join('users','solicitud_tickets.id_user','=','users.id')
            ->join('edificios','solicitud_tickets.id_edificio','=','edificios.id')
            ->join('servicios','solicitud_tickets.id_servicio','=','servicios.id')
            ->join('unidad_esps','solicitud_tickets.id_ubicacionEx','=','unidad_esps.id')
            ->where('solicitud_tickets.id_categoria', 1)
            ->where('solicitud_tickets.id_estado', '!=', $estadoEliminado)
            ->where('solicitud_tickets.id_estado', '!=', $estadoEliminado2)

            ->get();
        return  $users;
    }

    public function GetDatoCalendarioEM()
    {
        $estadoEliminado = 7;
        $estadoEliminado2 = 1;
        $users = SolicitudTickets::select('solicitud_tickets.id', 'edificios.descripcionEdificio','servicios.descripcionServicio','unidad_esps.descripcionUnidadEsp',DB::raw("CONCAT(users.nombre,' ',users.apellido) as nombrecompleto"),DB::raw("CONCAT(DATE_FORMAT(solicitud_tickets.created_at, '%d%m%Y'),'-',solicitud_tickets.id,'-',solicitud_tickets.id_user) as nticket"), 'solicitud_tickets.uuid', 'solicitud_tickets.descripcionP', 'solicitud_tickets.tituloP', 'solicitud_tickets.created_at', 'gestion_solicitudes.id_trabajador', 'trabajadores.tra_nombre','trabajadores.tra_apellido', 'gestion_solicitudes.horaInicio', 'gestion_solicitudes.fechaInicio', 'gestion_solicitudes.horaTermino', 'gestion_solicitudes.fechaTermino')
        ->join('gestion_solicitudes', 'solicitud_tickets.id', '=', 'gestion_solicitudes.id_solicitud')
        ->join('trabajadores', 'gestion_solicitudes.id_trabajador', '=', 'trabajadores.id')
        ->join('users','solicitud_tickets.id_user','=','users.id')
        ->join('edificios','solicitud_tickets.id_edificio','=','edificios.id')
        ->join('servicios','solicitud_tickets.id_servicio','=','servicios.id')
        ->join('unidad_esps','solicitud_tickets.id_ubicacionEx','=','unidad_esps.id')
            ->where('solicitud_tickets.id_categoria', 2)
            ->where('solicitud_tickets.id_estado', '!=', $estadoEliminado)
            ->where('solicitud_tickets.id_estado', '!=', $estadoEliminado2)
            ->get();
        return  $users;
    }

    public function GetDatoCalendarioIND()
    {
        $estadoEliminado = 7;
        $estadoEliminado2 = 1;
        $users = SolicitudTickets::select('solicitud_tickets.id','edificios.descripcionEdificio','servicios.descripcionServicio','unidad_esps.descripcionUnidadEsp',DB::raw("CONCAT(users.nombre,' ',users.apellido) as nombrecompleto"), DB::raw("CONCAT(DATE_FORMAT(solicitud_tickets.created_at, '%d%m%Y'),'-',solicitud_tickets.id,'-',solicitud_tickets.id_user) as nticket"), 'solicitud_tickets.uuid', 'solicitud_tickets.descripcionP', 'solicitud_tickets.tituloP', 'solicitud_tickets.created_at', 'gestion_solicitudes.id_trabajador', 'trabajadores.tra_nombre','trabajadores.tra_apellido', 'gestion_solicitudes.horaInicio', 'gestion_solicitudes.fechaInicio', 'gestion_solicitudes.horaTermino', 'gestion_solicitudes.fechaTermino')
        ->join('gestion_solicitudes', 'solicitud_tickets.id', '=', 'gestion_solicitudes.id_solicitud')
        ->join('trabajadores', 'gestion_solicitudes.id_trabajador', '=', 'trabajadores.id')
        ->join('users','solicitud_tickets.id_user','=','users.id')
        ->join('edificios','solicitud_tickets.id_edificio','=','edificios.id')
        ->join('servicios','solicitud_tickets.id_servicio','=','servicios.id')
        ->join('unidad_esps','solicitud_tickets.id_ubicacionEx','=','unidad_esps.id')
            ->where('solicitud_tickets.id_categoria', 3)
            ->where('solicitud_tickets.id_estado', '!=', $estadoEliminado)
            ->where('solicitud_tickets.id_estado', '!=', $estadoEliminado2)
            ->get();
        return  $users;
    }

    public function GetDatoCalendarioCA()
    {
        $estadoEliminado = 7;
        $estadoEliminado2 = 1;
        $users = SolicitudTickets::select('solicitud_tickets.id','edificios.descripcionEdificio','servicios.descripcionServicio','unidad_esps.descripcionUnidadEsp',DB::raw("CONCAT(users.nombre,' ',users.apellido) as nombrecompleto"), DB::raw("CONCAT(DATE_FORMAT(solicitud_tickets.created_at, '%d%m%Y'),'-',solicitud_tickets.id,'-',solicitud_tickets.id_user) as nticket"), 'solicitud_tickets.uuid', 'solicitud_tickets.descripcionP', 'solicitud_tickets.tituloP', 'solicitud_tickets.created_at', 'gestion_solicitudes.id_trabajador', 'trabajadores.tra_nombre','trabajadores.tra_apellido', 'gestion_solicitudes.horaInicio', 'gestion_solicitudes.fechaInicio', 'gestion_solicitudes.horaTermino', 'gestion_solicitudes.fechaTermino')
        ->join('gestion_solicitudes', 'solicitud_tickets.id', '=', 'gestion_solicitudes.id_solicitud')
        ->join('trabajadores', 'gestion_solicitudes.id_trabajador', '=', 'trabajadores.id')
        ->join('users','solicitud_tickets.id_user','=','users.id')
        ->join('edificios','solicitud_tickets.id_edificio','=','edificios.id')
        ->join('servicios','solicitud_tickets.id_servicio','=','servicios.id')
        ->join('unidad_esps','solicitud_tickets.id_ubicacionEx','=','unidad_esps.id')
            ->where('solicitud_tickets.id_categoria', 4)
            ->where('solicitud_tickets.id_estado', '!=', $estadoEliminado)
            ->where('solicitud_tickets.id_estado', '!=', $estadoEliminado2)
            ->get();
        return  $users;
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
                ->get();
            }else{
               
            $userMail = Users::select('email')
            ->where('id_cargo_asociado',$ValidarCargo)
            ->orWhere('id',$ValidarCargo)
            ->get();
            }

            $listContactos = [];
            $i = 0;

            foreach ($userMail as $key) {
                $listContactos[$i] = $key->email;
                $i++;
            }


            SeguimientoSolicitudes::create($request->all());
            //Insertando Ticket
            $response2 = SolicitudTickets::where('id', $request->id_solicitud)
                ->update(['id_edificio' => $request->id_edificio, 'id_servicio' => $request->id_servicio, 'id_ubicacionEx' => $request->id_ubicacionEx, 'id_tipoReparacion' => $request->id_tipoReparacion, 'id_estado' => $request->id_estado]);

            $response = GestionSolicitudes::create($request->all());

        } catch (\Throwable $th) {
            log::info($th);
        } finally {
            Mail::send('/Mails/TicketAsignado', ['Apoyo1' => $desApoyo1, 'Apoyo2' => $desApoyo2, 'Apoyo3' => $desApoyo3, 'estado' => $desEstado, 'fechaCreacion' => $fechacreacion, 'nombre' => $nombre, 'id' => $id_solicitud, 'descripcionTicket' => $descripcionP, 'titulo' => $tituloP, 'fecha' => $fecha, 'tra_nombre' => $nombreTrabajador, 'sup_nombre' => $nombreSupervisor], function ($message) use($listContactos){
                $message->setTo($listContactos)->setSubject('Asignacion de ticket');
                $message->setFrom('ricardo.soto.g@redsalud.gov.cl', 'Ricardo Soto Gomez');
                $message->setBcc(['ricardo.soto.g@redsalud.gov.cl'=> 'Mantencion']);
            });
            return $response = "Ok";
        }
    }

    public function AsignarTicketEM(Request $request)
    {
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
                ->get();
            }else{
               
            $userMail = Users::select('email')
            ->where('id_cargo_asociado',$ValidarCargo)
            ->orWhere('id',$ValidarCargo)
            ->get();
            }

            $listContactos = [];
            $i = 0;

            foreach ($userMail as $key) {
                $listContactos[$i] = $key->email;
                $i++;
            }


            SeguimientoSolicitudes::create($request->all());
            //Insertando Ticket
            $response2 = SolicitudTickets::where('id', $request->id_solicitud)
                ->update(['id_edificio' => $request->id_edificio, 'id_servicio' => $request->id_servicio, 'id_ubicacionEx' => $request->id_ubicacionEx, 'id_tipoReparacion' => $request->id_tipoReparacion, 'id_estado' => $request->id_estado]);

            $response = GestionSolicitudes::create($request->all());
        } catch (\Throwable $th) {
            log::info($th);
        } finally {
            Mail::send('/Mails/TicketAsignado', ['Apoyo1' => $desApoyo1, 'Apoyo2' => $desApoyo2, 'Apoyo3' => $desApoyo3, 'estado' => $desEstado, 'fechaCreacion' => $fechacreacion, 'nombre' => $nombre, 'id' => $id_solicitud, 'descripcionTicket' => $descripcionP, 'titulo' => $tituloP, 'fecha' => $fecha, 'tra_nombre' => $nombreTrabajador, 'sup_nombre' => $nombreSupervisor], function ($message) use($listContactos){
                $message->setTo($listContactos)->setSubject('Asignacion de ticket');
                $message->setFrom('ricardo.soto.g@redsalud.gov.cl', 'Ricardo Soto Gomez');
                $message->setBcc(['ricardo.soto.g@redsalud.gov.cl'=> 'Mantencion']);
            });
            return $response = "Ok";
        }
    }

    public function AsignarTicketIND(Request $request)
    {
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

        $userSearch = Users::where('id',$id_user)->first();
            $ValidarCargo = $userSearch->id_cargo_asociado;     
            $userMail = [];

            if($ValidarCargo == null || $ValidarCargo == 0){
                $userMail = Users::select('email')
                ->Where('id',$id_usuarioSolicitante)
                ->orWhere('id_cargo_asociado',$id_usuarioSolicitante)
                ->get();
            }else{
               
            $userMail = Users::select('email')
            ->where('id_cargo_asociado',$ValidarCargo)
            ->orWhere('id',$ValidarCargo)
            ->get();
            }

            $listContactos = [];
            $i = 0;

            foreach ($userMail as $key) {
                $listContactos[$i] = $key->email;
                $i++;
            }



            SeguimientoSolicitudes::create($request->all());
            //Insertando Ticket
            $response2 = SolicitudTickets::where('id', $request->id_solicitud)
                ->update(['id_edificio' => $request->id_edificio, 'id_servicio' => $request->id_servicio, 'id_ubicacionEx' => $request->id_ubicacionEx, 'id_tipoReparacion' => $request->id_tipoReparacion, 'id_estado' => $request->id_estado]);

            $response = GestionSolicitudes::create($request->all());
        } catch (\Throwable $th) {
            log::info($th);
        } finally {
            Mail::send('/Mails/TicketAsignado', ['Apoyo1' => $desApoyo1, 'Apoyo2' => $desApoyo2, 'Apoyo3' => $desApoyo3, 'estado' => $desEstado, 'fechaCreacion' => $fechacreacion, 'nombre' => $nombre, 'id' => $id_solicitud, 'descripcionTicket' => $descripcionP, 'titulo' => $tituloP, 'fecha' => $fecha, 'tra_nombre' => $nombreTrabajador, 'sup_nombre' => $nombreSupervisor], function ($message) use($listContactos){
                $message->setTo($listContactos)->setSubject('Asignacion de ticket');
                $message->setFrom('ricardo.soto.g@redsalud.gov.cl', 'Ricardo Soto Gomez');
                $message->setBcc(['ricardo.soto.g@redsalud.gov.cl'=> 'Mantencion']);
            });
            return $response = "Ok";
        }
    }

    public function AsignarTicketCA(Request $request)
    {
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
                ->get();
            }else{
               
            $userMail = Users::select('email')
            ->where('id_cargo_asociado',$ValidarCargo)
            ->orWhere('id',$ValidarCargo)
            ->get();
            }

            $listContactos = [];
            $i = 0;

            foreach ($userMail as $key) {
                $listContactos[$i] = $key->email;
                $i++;
            }

            SeguimientoSolicitudes::create($request->all());
            //Insertando Ticket
            $response2 = SolicitudTickets::where('id', $request->id_solicitud)
                ->update(['id_edificio' => $request->id_edificio, 'id_servicio' => $request->id_servicio, 'id_ubicacionEx' => $request->id_ubicacionEx, 'id_tipoReparacion' => $request->id_tipoReparacion, 'id_estado' => $request->id_estado]);

            $response = GestionSolicitudes::create($request->all());
        } catch (\Throwable $th) {
            log::info($th);
        } finally {
            Mail::send('/Mails/TicketAsignado', ['Apoyo1' => $desApoyo1, 'Apoyo2' => $desApoyo2, 'Apoyo3' => $desApoyo3, 'estado' => $desEstado, 'fechaCreacion' => $fechacreacion, 'nombre' => $nombre, 'id' => $id_solicitud, 'descripcionTicket' => $descripcionP, 'titulo' => $tituloP, 'fecha' => $fecha, 'tra_nombre' => $nombreTrabajador, 'sup_nombre' => $nombreSupervisor], function ($message) use($listContactos){
                $message->setTo($listContactos)->setSubject('Asignacion de ticket');
                $message->setFrom('ricardo.soto.g@redsalud.gov.cl', 'Ricardo Soto Gomez');
                $message->setBcc(['ricardo.soto.g@redsalud.gov.cl'=> 'Mantencion']);
            });
            return $response = "Ok";
        }
    }

    public function getSolicitudUsuariosJoin()
    {
        $ticket = SolicitudTickets::select('solicitud_tickets.*', 'users.nombre', 'users.apellido', 'estado_solicituds.descripcionEstado', DB::raw('TIMESTAMPDIFF(HOUR,solicitud_tickets.created_at,NOW()) AS Horas'), DB::raw("CONCAT(DATE_FORMAT(solicitud_tickets.created_at, '%d%m%Y'),'-',solicitud_tickets.id,'-',solicitud_tickets.id_user) as nticket"))
            ->join('users', 'solicitud_tickets.id_user', '=', 'users.id')
            ->join('estado_solicituds', 'solicitud_tickets.id_estado', '=', 'estado_solicituds.id')
            ->where('solicitud_tickets.id_categoria', 1)
            ->orderBy('solicitud_tickets.id', 'desc')
            ->get();
        return  $ticket;
    }

    public function getSolicitudUsuariosJoinEM()
    {
        $ticket = SolicitudTickets::select('solicitud_tickets.*', 'users.nombre', 'users.apellido', 'estado_solicituds.descripcionEstado', DB::raw('TIMESTAMPDIFF(HOUR,solicitud_tickets.created_at,NOW()) AS Horas'), DB::raw("CONCAT(DATE_FORMAT(solicitud_tickets.created_at, '%d%m%Y'),'-',solicitud_tickets.id,'-',solicitud_tickets.id_user) as nticket"))
            ->join('users', 'solicitud_tickets.id_user', '=', 'users.id')
            ->join('estado_solicituds', 'solicitud_tickets.id_estado', '=', 'estado_solicituds.id')
            ->where('solicitud_tickets.id_categoria', 2)
            ->orderBy('solicitud_tickets.id', 'desc')
            ->get();

        
        return  $ticket;
    }

    public function getSolicitudUsuariosJoinIND()
    {
        $ticket = SolicitudTickets::select('solicitud_tickets.*', 'users.nombre', 'users.apellido', 'estado_solicituds.descripcionEstado', DB::raw('TIMESTAMPDIFF(HOUR,solicitud_tickets.created_at,NOW()) AS Horas'), DB::raw("CONCAT(DATE_FORMAT(solicitud_tickets.created_at, '%d%m%Y'),'-',solicitud_tickets.id,'-',solicitud_tickets.id_user) as nticket"))
            ->join('users', 'solicitud_tickets.id_user', '=', 'users.id')
            ->join('estado_solicituds', 'solicitud_tickets.id_estado', '=', 'estado_solicituds.id')
            ->where('solicitud_tickets.id_categoria', 3)
            ->orderBy('solicitud_tickets.id', 'desc')
            ->get();
        return  $ticket;
    }

    public function getSolicitudUsuariosJoinCA()
    {
        $ticket = SolicitudTickets::select('solicitud_tickets.*', 'users.nombre', 'users.apellido', 'estado_solicituds.descripcionEstado', DB::raw('TIMESTAMPDIFF(HOUR,solicitud_tickets.created_at,NOW()) AS Horas'), DB::raw("CONCAT(DATE_FORMAT(solicitud_tickets.created_at, '%d%m%Y'),'-',solicitud_tickets.id,'-',solicitud_tickets.id_user) as nticket"))
            ->join('users', 'solicitud_tickets.id_user', '=', 'users.id')
            ->join('estado_solicituds', 'solicitud_tickets.id_estado', '=', 'estado_solicituds.id')
            ->where('id_categoria', 4)
            ->orderBy('solicitud_tickets.id', 'desc')
            ->get();
        return  $ticket;
    }

    public function NuevoTicket(Request $request)
    {
        //Insertando Ticket

        $uuid = Uuid::uuid4();
        $id = SolicitudTickets::create(array_merge($request->all(), ['uuid' => $uuid]))->id;

        $response = GestionSolicitudes::create(array_merge($request->all(), ['uuid' => $uuid, 'id_solicitud' => $id]));


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
                ->get();
            }else{
               
            $userMail = Users::select('email')
            ->where('id_cargo_asociado',$ValidarCargo)
            ->orWhere('id',$ValidarCargo)
            ->get();
            }

            $listContactos = [];
            $i = 0;

            foreach ($userMail as $key) {
                $listContactos[$i] = $key->email;
                $i++;
            }

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
            $message->setFrom(['ricardo.soto.g@redsalud.gov.cl'=> 'Ricardo Soto Gomez']);
            $message->setBcc(['ricardo.soto.g@redsalud.gov.cl'=> 'Mantencion']);
        });

        return $response;
    }

    public function NuevoTicketEM(Request $request)
    {
        //Insertando Ticket

        $uuid = Uuid::uuid4();
        $id = SolicitudTickets::create(array_merge($request->all(), ['uuid' => $uuid]))->id;

        $response = GestionSolicitudes::create(array_merge($request->all(), ['uuid' => $uuid, 'id_solicitud' => $id]));


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
                ->get();
            }else{
               
            $userMail = Users::select('email')
            ->where('id_cargo_asociado',$ValidarCargo)
            ->orWhere('id',$ValidarCargo)
            ->get();
            }

            $listContactos = [];
            $i = 0;

            foreach ($userMail as $key) {
                $listContactos[$i] = $key->email;
                $i++;
            }

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
            $message->setFrom(['ricardo.soto.g@redsalud.gov.cl'=> 'Ricardo Soto Gomez']);
            $message->setBcc(['ricardo.soto.g@redsalud.gov.cl'=> 'Mantencion']);
        });

        return $response;
    }

    public function NuevoTicketIND(Request $request)
    {
        //Insertando Ticket

        $uuid = Uuid::uuid4();
        $id = SolicitudTickets::create(array_merge($request->all(), ['uuid' => $uuid]))->id;

        $response = GestionSolicitudes::create(array_merge($request->all(), ['uuid' => $uuid, 'id_solicitud' => $id]));


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
                ->get();
            }else{
               
            $userMail = Users::select('email')
            ->where('id_cargo_asociado',$ValidarCargo)
            ->orWhere('id',$ValidarCargo)
            ->get();
            }

            $listContactos = [];
            $i = 0;

            foreach ($userMail as $key) {
                $listContactos[$i] = $key->email;
                $i++;
            }

        $descripcionSeguimiento = "Se a creado el Ticket N°" . $id_solicitud . " por el Usuario: " . $nombre;

        $idTrabajador = $request->id_trabajador;
        $idSupervisor = $request->id_supervisor;

        $trabajador = Trabajadores::where('id', $idTrabajador)->first();
        $supervisor = Supervisores::where('id', $idSupervisor)->first();

        $nombreTrabajador = $trabajador->tra_nombre . " " . $trabajador->tra_apellido;
        $nombreSupervisor = $supervisor->sup_nombre . " " . $supervisor->sup_apellido;

        SeguimientoSolicitudes::create(array_merge($request->all(), ['uuid' => $uuid, 'id_solicitud' => $id_solicitud, 'descripcionSeguimiento' => $descripcionSeguimiento]));

        Mail::send('/Mails/TicketGeneradoAgente', ['nombre' => $nombre, 'id' => $id_solicitud, 'descripcionTicket' => $descripcionP, 'titulo' => $tituloP, 'fecha' => $fecha, 'tra_nombre' => $nombreTrabajador, 'sup_nombre' => $nombreSupervisor], function ($message) use($listContactos){
            $message->setTo($listContactos)->setSubject('Nueva Creacion de ticket');
            $message->setFrom(['ricardo.soto.g@redsalud.gov.cl'=> 'Ricardo Soto Gomez']);
            $message->setBcc(['ricardo.soto.g@redsalud.gov.cl'=> 'Mantencion']);
        });

        return $response;
    }

    public function NuevoTicketCA(Request $request)
    {
        //Insertando Ticket

        $uuid = Uuid::uuid4();
        $id = SolicitudTickets::create(array_merge($request->all(), ['uuid' => $uuid]))->id;

        $response = GestionSolicitudes::create(array_merge($request->all(), ['uuid' => $uuid, 'id_solicitud' => $id]));


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
                ->get();
            }else{
               
            $userMail = Users::select('email')
            ->where('id_cargo_asociado',$ValidarCargo)
            ->orWhere('id',$ValidarCargo)
            ->get();
            }

            $listContactos = [];
            $i = 0;

            foreach ($userMail as $key) {
                $listContactos[$i] = $key->email;
                $i++;
            }

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
            $message->setFrom(['ricardo.soto.g@redsalud.gov.cl'=> 'Ricardo Soto Gomez']);
            $message->setBcc(['ricardo.soto.g@redsalud.gov.cl'=> 'Mantencion']);
        });

        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

    }

    public function ModificarCategoria(Request $request)
    {
        try {
            SolicitudTickets::where('id', $request->idsolicitud)
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

    public function modificarTicket(Request $request)
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


            $response2 = SolicitudTickets::where('uuid', $request->uuid)
                ->where('id', $request->id_solicitud)
                ->update([
                    'id_edificio' => $request->id_edificio, 'id_servicio' => $request->id_servicio,
                    'id_ubicacionEx' => $request->id_ubicacionEx, 'id_tipoReparacion' => $request->id_tipoReparacion,
                    'id_estado' => $request->id_estado
                ]);
            $response = GestionSolicitudes::where('uuid', $request->uuid)
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
                ->get();
            }else{
               
            $userMail = Users::select('email')
            ->where('id_cargo_asociado',$ValidarCargo)
            ->orWhere('id',$ValidarCargo)
            ->get();
            }

            $listContactos = [];
            $i = 0;

            foreach ($userMail as $key) {
                $listContactos[$i] = $key->email;
                $i++;
            }

            

        } catch (\Throwable $th) {
            log::info($th);
        } finally {
            Mail::send('/Mails/TicketModificadoAgente',['Apoyo1' => $desApoyo1, 'Apoyo2' => $desApoyo2, 'Apoyo3' => $desApoyo3, 'estado' => $desEstado, 'fechaCreacion' => $fechacreacion, 'nombre' => $nombre, 'id' => $id_solicitud, 'descripcionTicket' => $descripcionP, 'titulo' => $tituloP, 'fecha' => $fecha, 'tra_nombre' => $nombreTrabajador, 'sup_nombre' => $nombreSupervisor , 'razon' => $razoncambio], function ($message) use($listContactos){
                $message->setTo($listContactos)->setSubject('Modificacion de ticket');
                $message->setFrom(['ricardo.soto.g@redsalud.gov.cl'=> 'Ricardo Soto Gomez']);
                $message->setBcc(['ricardo.soto.g@redsalud.gov.cl'=> 'Mantencion']);
            });
            return "ok";
        }
        //Modificando Ticket



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


            $response2 = SolicitudTickets::where('uuid', $request->uuid)
                ->where('id', $request->id_solicitud)
                ->update([
                    'id_edificio' => $request->id_edificio, 'id_servicio' => $request->id_servicio,
                    'id_ubicacionEx' => $request->id_ubicacionEx, 'id_tipoReparacion' => $request->id_tipoReparacion,
                    'id_estado' => $request->id_estado
                ]);
            $response = GestionSolicitudes::where('uuid', $request->uuid)
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
                    ->get();
                }else{
                   
                $userMail = Users::select('email')
                ->where('id_cargo_asociado',$ValidarCargo)
                ->orWhere('id',$ValidarCargo)
                ->get();
                }
    
                $listContactos = [];
                $i = 0;
    
                foreach ($userMail as $key) {
                    $listContactos[$i] = $key->email;
                    $i++;
                }
    
        } catch (\Throwable $th) {
            log::info($th);
        } finally {
            Mail::send('/Mails/TicketModificadoAgente',['Apoyo1' => $desApoyo1, 'Apoyo2' => $desApoyo2, 'Apoyo3' => $desApoyo3, 'estado' => $desEstado, 'fechaCreacion' => $fechacreacion, 'nombre' => $nombre, 'id' => $id_solicitud, 'descripcionTicket' => $descripcionP, 'titulo' => $tituloP, 'fecha' => $fecha, 'tra_nombre' => $nombreTrabajador, 'sup_nombre' => $nombreSupervisor, 'razon' => $razoncambio], function ($message) use($listContactos){
                $message->setTo($listContactos)->setSubject('Modificacion de ticket');
                $message->setFrom(['ricardo.soto.g@redsalud.gov.cl'=> 'Ricardo Soto Gomez']);
                $message->setBcc(['ricardo.soto.g@redsalud.gov.cl'=> 'Mantencion']);
            });
            return $response;
        }
        //Modificando Ticket



    }

    public function modificarTicketEM(Request $request)
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


            $response2 = SolicitudTickets::where('uuid', $request->uuid)
                ->where('id', $request->id_solicitud)
                ->update([
                    'id_edificio' => $request->id_edificio, 'id_servicio' => $request->id_servicio,
                    'id_ubicacionEx' => $request->id_ubicacionEx, 'id_tipoReparacion' => $request->id_tipoReparacion,
                    'id_estado' => $request->id_estado
                ]);
            $response = GestionSolicitudes::where('uuid', $request->uuid)
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
                    ->get();
                }else{
                   
                $userMail = Users::select('email')
                ->where('id_cargo_asociado',$ValidarCargo)
                ->orWhere('id',$ValidarCargo)
                ->get();
                }
    
                $listContactos = [];
                $i = 0;
    
                foreach ($userMail as $key) {
                    $listContactos[$i] = $key->email;
                    $i++;
                }
    
        } catch (\Throwable $th) {
            log::info($th);
        } finally {
            Mail::send('/Mails/TicketModificadoAgente',['Apoyo1' => $desApoyo1, 'Apoyo2' => $desApoyo2, 'Apoyo3' => $desApoyo3, 'estado' => $desEstado, 'fechaCreacion' => $fechacreacion, 'nombre' => $nombre, 'id' => $id_solicitud, 'descripcionTicket' => $descripcionP, 'titulo' => $tituloP, 'fecha' => $fecha, 'tra_nombre' => $nombreTrabajador, 'sup_nombre' => $nombreSupervisor, 'razon' => $razoncambio], function ($message) use($listContactos){
                $message->setTo($listContactos)->setSubject('Modificacion de ticket');
                $message->setFrom(['ricardo.soto.g@redsalud.gov.cl'=> 'Ricardo Soto Gomez']);
                $message->setBcc(['ricardo.soto.g@redsalud.gov.cl'=> 'Mantencion']);
            });
            return $response;
        }
        //Modificando Ticket



    }

    public function modificarTicketIND(Request $request)
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


            $response2 = SolicitudTickets::where('uuid', $request->uuid)
                ->where('id', $request->id_solicitud)
                ->update([
                    'id_edificio' => $request->id_edificio, 'id_servicio' => $request->id_servicio,
                    'id_ubicacionEx' => $request->id_ubicacionEx, 'id_tipoReparacion' => $request->id_tipoReparacion,
                    'id_estado' => $request->id_estado
                ]);
            $response = GestionSolicitudes::where('uuid', $request->uuid)
                ->where('id_solicitud', $request->id_solicitud)
                ->update([
                    'id_supervisor' => $request->id_supervisor, 'id_trabajador' => $request->id_trabajador,
                    'idApoyo1' => $request->idApoyo1, 'idApoyo2' => $request->idApoyo2,
                    'idApoyo3' => $request->idApoyo3,'idTurno' => $request->idTurno,
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
                    ->get();
                }else{
                   
                $userMail = Users::select('email')
                ->where('id_cargo_asociado',$ValidarCargo)
                ->orWhere('id',$ValidarCargo)
                ->get();
                }
    
                $listContactos = [];
                $i = 0;
    
                foreach ($userMail as $key) {
                    $listContactos[$i] = $key->email;
                    $i++;
                }
    
        } catch (\Throwable $th) {
            log::info($th);
        } finally {
            Mail::send('/Mails/TicketModificadoAgente',['Apoyo1' => $desApoyo1, 'Apoyo2' => $desApoyo2, 'Apoyo3' => $desApoyo3, 'estado' => $desEstado, 'fechaCreacion' => $fechacreacion, 'nombre' => $nombre, 'id' => $id_solicitud, 'descripcionTicket' => $descripcionP, 'titulo' => $tituloP, 'fecha' => $fecha, 'tra_nombre' => $nombreTrabajador, 'sup_nombre' => $nombreSupervisor, 'razon' => $razoncambio], function ($message) use($listContactos){
                $message->setTo($listContactos)->setSubject('Modificacion de ticket');
                $message->setFrom(['ricardo.soto.g@redsalud.gov.cl'=> 'Ricardo Soto Gomez']);
                $message->setBcc(['ricardo.soto.g@redsalud.gov.cl'=> 'Mantencion']);
            });
            return $response;
        }
        //Modificando Ticket



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
        $ticket = SolicitudTickets::find($id);
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
                    ->get();
                }else{
                   
                $userMail = Users::select('email')
                ->where('id_cargo_asociado',$ValidarCargo)
                ->orWhere('id',$ValidarCargo)
                ->get();
                }
    
                $listContactos = [];
                $i = 0;
    
                foreach ($userMail as $key) {
                    $listContactos[$i] = $key->email;
                    $i++;
                }

                Mail::send('/Mails/TicketEliminado', ['nombre' => $nombre, 'id_solicitud' => $id, 'descripcionSeguimiento' => $razon], function ($message) use($listContactos) {
                    $message->setTo($listContactos)->setSubject('Seguimiento de ticket');
                        $message->setFrom(['ricardo.soto.g@redsalud.gov.cl'=> 'Ricardo Soto Gomez']);
                        $message->setBcc(['ricardo.soto.g@redsalud.gov.cl'=> 'Mantencion']);
                });

        return true;
    }

    public function FinalizarTicket(Request $request){

        $id = $request->id_solicitud;
        $nombre = $request->nombre;
        $descripcionSeguimiento = $request->descripcionSeguimiento;
        $seguimientoRazon = SeguimientoSolicitudes::create($request->all());
        $estadoFinalizado = 6;
        $ticket = SolicitudTickets::find($id);
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
                    ->get();
                }else{
                   
                $userMail = Users::select('email')
                ->where('id_cargo_asociado',$ValidarCargo)
                ->orWhere('id',$ValidarCargo)
                ->get();
                }
    
                $listContactos = [];
                $i = 0;
    
                foreach ($userMail as $key) {
                    $listContactos[$i] = $key->email;
                    $i++;
                }

                Mail::send('/Mails/TicketFinalizado', ['nombre' => $nombre, 'id_solicitud' => $id], function ($message) use($listContactos) {
                    $message->setTo($listContactos)->setSubject('Finalizacion de ticket');
                        $message->setFrom(['ricardo.soto.g@redsalud.gov.cl'=> 'Ricardo Soto Gomez']);
                        $message->setBcc(['ricardo.soto.g@redsalud.gov.cl'=> 'Mantencion']);
                });

        return true;

    }
}
