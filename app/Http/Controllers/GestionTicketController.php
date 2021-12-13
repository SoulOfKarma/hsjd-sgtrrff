<?php

namespace App\Http\Controllers;

use App\GestionSolicitudes;
use App\Mail\TicketAsignado;
use App\SeguimientoSolicitudes;
use App\SolicitudTickets;
use App\SolicitudTicketINDs;
use App\SolicitudTicketsEM;
use App\SolicitudTicketsAps;
use App\TicketCadenas;
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
        $filtro = [1,5,6,7];
        $ticket = SolicitudTickets::select('solicitud_tickets.*', 'users.nombre', 'users.apellido','categorias.des_categoria',
            'estado_solicituds.descripcionEstado', DB::raw('TIMESTAMPDIFF(HOUR,solicitud_tickets.created_at,NOW()) AS Horas'),
             DB::raw("CONCAT(solicitud_tickets.id) as nticket"))
            ->join('users', 'solicitud_tickets.id_user', '=', 'users.id')
            ->join('estado_solicituds', 'solicitud_tickets.id_estado', '=', 'estado_solicituds.id')
            ->join('categorias','solicitud_tickets.id_categoria','=','categorias.id')
            ->whereNotIn('solicitud_tickets.id_estado',$filtro);
        $ticketEM = SolicitudTicketsEM::select('solicitud_tickets_e_m_s.*', 'users.nombre', 'users.apellido','categorias.des_categoria',
            'estado_solicituds.descripcionEstado', DB::raw('TIMESTAMPDIFF(HOUR,solicitud_tickets_e_m_s.created_at,NOW()) AS Horas'),
             DB::raw("CONCAT(solicitud_tickets_e_m_s.id) as nticket"))
            ->join('users', 'solicitud_tickets_e_m_s.id_user', '=', 'users.id')
            ->join('estado_solicituds', 'solicitud_tickets_e_m_s.id_estado', '=', 'estado_solicituds.id')
            ->join('categorias','solicitud_tickets_e_m_s.id_categoria','=','categorias.id')
            ->whereNotIn('solicitud_tickets_e_m_s.id_estado',$filtro);
            
        $ticketIND = SolicitudTicketINDs::select('solicitud_ticket_i_n_ds.*', 'users.nombre', 'users.apellido','categorias.des_categoria',
            'estado_solicituds.descripcionEstado', DB::raw('TIMESTAMPDIFF(HOUR,solicitud_ticket_i_n_ds.created_at,NOW()) AS Horas'),
             DB::raw("CONCAT(solicitud_ticket_i_n_ds.id) as nticket"))
            ->join('users', 'solicitud_ticket_i_n_ds.id_user', '=', 'users.id')
            ->join('estado_solicituds', 'solicitud_ticket_i_n_ds.id_estado', '=', 'estado_solicituds.id')
            ->join('categorias','solicitud_ticket_i_n_ds.id_categoria','=','categorias.id')
            ->whereNotIn('solicitud_ticket_i_n_ds.id_estado',$filtro);
            
            
        $ticketAP = SolicitudTicketsAps::select('solicitud_tickets_aps.*', 'users.nombre', 'users.apellido',
            'categorias.des_categoria',
            'estado_solicituds.descripcionEstado', DB::raw('TIMESTAMPDIFF(HOUR,solicitud_tickets_aps.created_at,NOW()) AS Horas'),
             DB::raw("CONCAT(solicitud_tickets_aps.id) as nticket"))
            ->join('users', 'solicitud_tickets_aps.id_user', '=', 'users.id')
            ->join('estado_solicituds', 'solicitud_tickets_aps.id_estado', '=', 'estado_solicituds.id')
            ->join('categorias','solicitud_tickets_aps.id_categoria','=','categorias.id')
            ->whereNotIn('solicitud_tickets_aps.id_estado',$filtro)
            ->union($ticket)
            ->union($ticketEM)
            ->union($ticketIND)
            ->get();    
        return $ticketAP;
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

    public function getTicketCreado($id)
    {
        return  SolicitudTickets::where('id', $id)->get();
    }

    public function getUsuarios()
    {
        //Traer a todos los usuarios
        $users = Users::select('users.id',DB::raw("CONCAT(users.nombre,' ',users.apellido) as nombre"))
        ->leftjoin('tbl_permiso_usuarios','users.run', '=', 'tbl_permiso_usuarios.run_usuario')
        //->whereNotIn('tbl_permiso_usuarios.estado_login',[0])
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
        $users = GestionSolicitudes::select('gestion_solicitudes.*','solicitud_tickets.*',)
        ->join('solicitud_tickets','gestion_solicitudes.id_solicitud','=','solicitud_tickets.id')
        ->where('gestion_solicitudes.id_solicitud',$id)
        ->get();
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
            //log::info($userMail);

            /* foreach ($userMail as $key) {
                $listContactos[$i] = $key->email;
                $i++;
            } */


            SeguimientoSolicitudes::create($request->all());
            //Insertando Ticket
            $response2 = SolicitudTickets::where('id', $request->id_solicitud)
                ->update(['id_edificio' => $request->id_edificio, 'id_servicio' => $request->id_servicio, 
                'id_ubicacionEx' => $request->id_ubicacionEx, 'id_tipoReparacion' => $request->id_tipoReparacion,
                 'id_estado' => $request->id_estado,'id_prioridad' => $request->id_prioridad,'descripcionP' => $request->descripcionP]);

            $response = GestionSolicitudes::create($request->all());

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

    

    

    public function PostCierreTicket(Request $request){
        try {
            $res3 = TicketCadenas::where('ticket_cadenas.idTicketNuevo',$request->id_solicitud)
            ->get();
            $count = $res3->count();
            if($count < 1){
                $res = GestionSolicitudes::where('id_solicitud',$request->id_solicitud)
                 ->update(['horasEjecucion' => $request->horasEjecucion,'horaTermino' => $request->horaTermino,'fechaTermino' => $request->fechaTermino]);
                 $res2 = SolicitudTickets::where('id',$request->id_solicitud)
                 ->update(['id_estado' => $request->id_estado]);
                
            }else{
                $res4 = [];
                foreach ($res3 as $key => $list) {
                $res4 = TicketCadenas::select("ticket_cadenas.*")
                ->where('ticket_cadenas.idTicketPrincipal',$list->idTicketPrincipal)
                ->get();

                $res = GestionSolicitudes::where('id_solicitud',$list->idTicketPrincipal)
                 ->update(['horasEjecucion' => $request->horasEjecucion,'horaTermino' => $request->horaTermino,'fechaTermino' => $request->fechaTermino]);
                 $res2 = SolicitudTickets::where('id',$list->idTicketPrincipal)
                 ->update(['id_estado' => $request->id_estado]);
                }
                foreach ($res4 as $key => $ticketCadena) {
                    GestionSolicitudes::where('id_solicitud',$ticketCadena->idTicketNuevo)
                    ->update(['horasEjecucion' => $request->horasEjecucion,'horaTermino' => $request->horaTermino,'fechaTermino' => $request->fechaTermino]);
                    SolicitudTickets::where('id',$ticketCadena->idTicketNuevo)
                    ->update(['id_estado' => $request->id_estado]);
                }
            }
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    
    public function getSolicitudUsuariosJoin()
    {
        try {
            $ticket = SolicitudTickets::select('solicitud_tickets.id','solicitud_tickets.id_user','solicitud_tickets.id_categoria','solicitud_tickets.uuid',DB::raw("CONCAT(users.nombre,' ',users.apellido) as nombre"),
            'servicios.descripcionServicio','tipo_reparacions.descripcionTipoReparacion','solicitud_tickets.descripcionP','solicitud_tickets.id_estado',
            'estado_solicituds.descripcionEstado', DB::raw('TIMESTAMPDIFF(HOUR,solicitud_tickets.created_at,NOW()) AS Horas'),
            DB::raw("CONCAT(solicitud_tickets.id) as nticket"),
            DB::raw("fnStripTags(solicitud_tickets.descripcionP) as desFormat"),
            DB::raw("(CASE WHEN solicitud_tickets.created_at IS NULL THEN  DATE_FORMAT(solicitud_tickets.created_at,'%d/%m/%Y')
            ELSE DATE_FORMAT(solicitud_tickets.created_at,'%d/%m/%Y') END) AS fechaSolicitud"),
            DB::raw("'PENDIENTE' AS nombreTra"))
            ->join('users', 'solicitud_tickets.id_user', '=', 'users.id')
            ->join('estado_solicituds', 'solicitud_tickets.id_estado', '=', 'estado_solicituds.id')
            ->join('tipo_reparacions','solicitud_tickets.id_tipoReparacion','=','tipo_reparacions.id')
            ->join('servicios','solicitud_tickets.id_servicio','=','servicios.id')
            ->where('solicitud_tickets.id_categoria', 1)
            ->where('solicitud_tickets.id_estado', 1)
            ->orWhere('solicitud_tickets.id_estado', 9);


            //->orderBy('solicitud_tickets.id', 'desc')
            //->get();
            $uticket = SolicitudTickets::select('solicitud_tickets.id','solicitud_tickets.id_user','solicitud_tickets.id_categoria','solicitud_tickets.uuid',DB::raw("CONCAT(users.nombre,' ',users.apellido) as nombre"),
            'servicios.descripcionServicio','tipo_reparacions.descripcionTipoReparacion','solicitud_tickets.descripcionP','solicitud_tickets.id_estado',
            'estado_solicituds.descripcionEstado', DB::raw('TIMESTAMPDIFF(HOUR,solicitud_tickets.created_at,NOW()) AS Horas'),
            DB::raw("CONCAT(solicitud_tickets.id) as nticket"),
            DB::raw("fnStripTags(solicitud_tickets.descripcionP) as desFormat"),
            DB::raw("(CASE WHEN gestion_solicitudes.fechaInicio IS NULL THEN 'PENDIENTE'
            ELSE DATE_FORMAT(gestion_solicitudes.fechaInicio,'%d/%m/%Y') END) AS fechaSolicitud"),
            DB::raw("(CASE WHEN gestion_solicitudes.id_trabajador IS NULL THEN 'PENDIENTE'
             ELSE CONCAT(trabajadores.tra_nombre,' ',trabajadores.tra_apellido) END) AS nombreTra"))
            ->join('users', 'solicitud_tickets.id_user', '=', 'users.id')
            ->join('estado_solicituds', 'solicitud_tickets.id_estado', '=', 'estado_solicituds.id')
            ->join('tipo_reparacions','solicitud_tickets.id_tipoReparacion','=','tipo_reparacions.id')
            ->join('servicios','solicitud_tickets.id_servicio','=','servicios.id')
            ->join('gestion_solicitudes', 'solicitud_tickets.id', '=', 'gestion_solicitudes.id_solicitud')
            ->join('trabajadores', 'gestion_solicitudes.id_trabajador', '=', 'trabajadores.id')
            ->where('solicitud_tickets.id_categoria', 1)
            ->union($ticket)
            ->orderBy('id','desc')
            ->get();
            return $uticket;
        } catch (\Throwable $th) {
           log::info($th);
           return false;
        }
        
    }

    public function GetTicketsTotales()
    {
        try {
            $ticket = SolicitudTickets::select('solicitud_tickets.id','solicitud_tickets.uuid',DB::raw("CONCAT(users.nombre,' ',users.apellido) as nombre"),
            'servicios.descripcionServicio','tipo_reparacions.descripcionTipoReparacion','solicitud_tickets.descripcionP','solicitud_tickets.id_estado',
            'estado_solicituds.descripcionEstado', DB::raw('TIMESTAMPDIFF(HOUR,solicitud_tickets.created_at,NOW()) AS Horas'),
            DB::raw("CONCAT(solicitud_tickets.id) as nticket"),
            DB::raw("fnStripTags(solicitud_tickets.descripcionP) as desFormat"),
            DB::raw("(CASE WHEN solicitud_tickets.created_at IS NULL THEN  DATE_FORMAT(solicitud_tickets.created_at,'%d/%m/%Y')
            ELSE DATE_FORMAT(solicitud_tickets.created_at,'%d/%m/%Y') END) AS fechaSolicitud"),
            DB::raw("'PENDIENTE' AS nombreTra"),'categorias.des_categoria','solicitud_tickets.id_categoria')
            ->join('users', 'solicitud_tickets.id_user', '=', 'users.id')
            ->join('categorias','solicitud_tickets.id_categoria','=','categorias.id')
            ->join('estado_solicituds', 'solicitud_tickets.id_estado', '=', 'estado_solicituds.id')
            ->join('tipo_reparacions','solicitud_tickets.id_tipoReparacion','=','tipo_reparacions.id')
            ->join('servicios','solicitud_tickets.id_servicio','=','servicios.id')
            ->where('solicitud_tickets.id_categoria', 1)
            ->where('solicitud_tickets.id_estado', 1);


            //->orderBy('solicitud_tickets.id', 'desc')
            //->get();
            $uticket = SolicitudTickets::select('solicitud_tickets.id','solicitud_tickets.uuid',DB::raw("CONCAT(users.nombre,' ',users.apellido) as nombre"),
            'servicios.descripcionServicio','tipo_reparacions.descripcionTipoReparacion','solicitud_tickets.descripcionP','solicitud_tickets.id_estado',
            'estado_solicituds.descripcionEstado', DB::raw('TIMESTAMPDIFF(HOUR,solicitud_tickets.created_at,NOW()) AS Horas'),
            DB::raw("CONCAT(solicitud_tickets.id) as nticket"),
            DB::raw("fnStripTags(solicitud_tickets.descripcionP) as desFormat"),
            DB::raw("(CASE WHEN gestion_solicitudes.fechaInicio IS NULL THEN 'PENDIENTE'
            ELSE DATE_FORMAT(gestion_solicitudes.fechaInicio,'%d/%m/%Y') END) AS fechaSolicitud"),
            DB::raw("(CASE WHEN gestion_solicitudes.id_trabajador IS NULL THEN 'PENDIENTE'
             ELSE CONCAT(trabajadores.tra_nombre,' ',trabajadores.tra_apellido) END) AS nombreTra"),'categorias.des_categoria','solicitud_tickets.id_categoria')
            ->join('users', 'solicitud_tickets.id_user', '=', 'users.id')
            ->join('categorias','solicitud_tickets.id_categoria','=','categorias.id')
            ->join('estado_solicituds', 'solicitud_tickets.id_estado', '=', 'estado_solicituds.id')
            ->join('tipo_reparacions','solicitud_tickets.id_tipoReparacion','=','tipo_reparacions.id')
            ->join('servicios','solicitud_tickets.id_servicio','=','servicios.id')
            ->join('gestion_solicitudes', 'solicitud_tickets.id', '=', 'gestion_solicitudes.id_solicitud')
            ->join('trabajadores', 'gestion_solicitudes.id_trabajador', '=', 'trabajadores.id')
            ->where('solicitud_tickets.id_categoria', 1);

            $ticketEM = SolicitudTicketsEM::select('solicitud_tickets_e_m_s.id','solicitud_tickets_e_m_s.uuid',DB::raw("CONCAT(users.nombre,' ',users.apellido) as nombre"),
            'servicios.descripcionServicio','tipo_reparacions.descripcionTipoReparacion','solicitud_tickets_e_m_s.descripcionP','solicitud_tickets_e_m_s.id_estado',
            'estado_solicituds.descripcionEstado', DB::raw('TIMESTAMPDIFF(HOUR,solicitud_tickets_e_m_s.created_at,NOW()) AS Horas'),
            DB::raw("CONCAT(solicitud_tickets_e_m_s.id) as nticket"),
            DB::raw("fnStripTags(solicitud_tickets_e_m_s.descripcionP) as desFormat"),
            DB::raw("(CASE WHEN solicitud_tickets_e_m_s.created_at IS NULL THEN 'PENDIENTE'
            ELSE DATE_FORMAT(solicitud_tickets_e_m_s.created_at,'%d/%m/%Y') END) AS fechaSolicitud"),
            DB::raw("'PENDIENTE'AS nombreTra"),'categorias.des_categoria','solicitud_tickets_e_m_s.id_categoria')
            ->join('users', 'solicitud_tickets_e_m_s.id_user', '=', 'users.id')
            ->join('categorias','solicitud_tickets_e_m_s.id_categoria','=','categorias.id')
            ->join('estado_solicituds', 'solicitud_tickets_e_m_s.id_estado', '=', 'estado_solicituds.id')
            ->join('tipo_reparacions','solicitud_tickets_e_m_s.id_tipoReparacion','=','tipo_reparacions.id')
            ->join('servicios','solicitud_tickets_e_m_s.id_servicio','=','servicios.id')
            ->where('solicitud_tickets_e_m_s.id_categoria', 2)
            ->where('solicitud_tickets_e_m_s.id_estado', 1);

            $uticketEM = SolicitudTicketsEM::select('solicitud_tickets_e_m_s.id','solicitud_tickets_e_m_s.uuid',DB::raw("CONCAT(users.nombre,' ',users.apellido) as nombre"),
            'servicios.descripcionServicio','tipo_reparacions.descripcionTipoReparacion','solicitud_tickets_e_m_s.descripcionP','solicitud_tickets_e_m_s.id_estado',
            'estado_solicituds.descripcionEstado', DB::raw('TIMESTAMPDIFF(HOUR,solicitud_tickets_e_m_s.created_at,NOW()) AS Horas'),
            DB::raw("CONCAT(solicitud_tickets_e_m_s.id) as nticket"),
            DB::raw("fnStripTags(solicitud_tickets_e_m_s.descripcionP) as desFormat"),
            DB::raw("(CASE WHEN gestion_ticket_e_m_s.fechaInicio IS NULL THEN 'PENDIENTE'
            ELSE DATE_FORMAT(gestion_ticket_e_m_s.fechaInicio,'%d/%m/%Y') END) AS fechaSolicitud"),
            DB::raw("(CASE WHEN gestion_ticket_e_m_s.id_trabajador IS NULL THEN 'PENDIENTE'
             ELSE CONCAT(trabajadores.tra_nombre,' ',trabajadores.tra_apellido) END) AS nombreTra"),'categorias.des_categoria','solicitud_tickets_e_m_s.id_categoria')
            ->join('users', 'solicitud_tickets_e_m_s.id_user', '=', 'users.id')
            ->join('categorias','solicitud_tickets_e_m_s.id_categoria','=','categorias.id')
            ->join('estado_solicituds', 'solicitud_tickets_e_m_s.id_estado', '=', 'estado_solicituds.id')
            ->join('tipo_reparacions','solicitud_tickets_e_m_s.id_tipoReparacion','=','tipo_reparacions.id')
            ->join('servicios','solicitud_tickets_e_m_s.id_servicio','=','servicios.id')
            ->join('gestion_ticket_e_m_s', 'solicitud_tickets_e_m_s.id', '=', 'gestion_ticket_e_m_s.id_solicitud')
            ->join('trabajadores', 'gestion_ticket_e_m_s.id_trabajador', '=', 'trabajadores.id')
            ->where('solicitud_tickets_e_m_s.id_categoria', 2);

            $ticketIND = SolicitudTicketINDs::select('solicitud_ticket_i_n_ds.id','solicitud_ticket_i_n_ds.uuid',DB::raw("CONCAT(users.nombre,' ',users.apellido) as nombre"),
            'servicios.descripcionServicio','tipo_reparacions.descripcionTipoReparacion','solicitud_ticket_i_n_ds.descripcionP','solicitud_ticket_i_n_ds.id_estado',
            'estado_solicituds.descripcionEstado', DB::raw('TIMESTAMPDIFF(HOUR,solicitud_ticket_i_n_ds.created_at,NOW()) AS Horas'),
            DB::raw("CONCAT(solicitud_ticket_i_n_ds.id) as nticket"),
            DB::raw("fnStripTags(solicitud_ticket_i_n_ds.descripcionP) as desFormat"),
            DB::raw("(CASE WHEN solicitud_ticket_i_n_ds.created_at IS NULL THEN 'PENDIENTE'
            ELSE DATE_FORMAT(solicitud_ticket_i_n_ds.created_at,'%d/%m/%Y') END) AS fechaSolicitud"),
            DB::raw("'PENDIENTE'AS nombreTra"),'categorias.des_categoria','solicitud_ticket_i_n_ds.id_categoria')
            ->join('users', 'solicitud_ticket_i_n_ds.id_user', '=', 'users.id')
            ->join('categorias','solicitud_ticket_i_n_ds.id_categoria','=','categorias.id')
            ->join('estado_solicituds', 'solicitud_ticket_i_n_ds.id_estado', '=', 'estado_solicituds.id')
            ->join('tipo_reparacions','solicitud_ticket_i_n_ds.id_tipoReparacion','=','tipo_reparacions.id')
            ->join('servicios','solicitud_ticket_i_n_ds.id_servicio','=','servicios.id')
            ->where('solicitud_ticket_i_n_ds.id_categoria', 1)
            ->where('solicitud_ticket_i_n_ds.id_estado', 1);
            //->orderBy('solicitud_tickets.id', 'desc')
            //->get();
            $uticketIND = SolicitudTicketINDs::select('solicitud_ticket_i_n_ds.id','solicitud_ticket_i_n_ds.uuid',DB::raw("CONCAT(users.nombre,' ',users.apellido) as nombre"),
            'servicios.descripcionServicio','tipo_reparacions.descripcionTipoReparacion','solicitud_ticket_i_n_ds.descripcionP','solicitud_ticket_i_n_ds.id_estado',
            'estado_solicituds.descripcionEstado', DB::raw('TIMESTAMPDIFF(HOUR,solicitud_ticket_i_n_ds.created_at,NOW()) AS Horas'),
            DB::raw("CONCAT(solicitud_ticket_i_n_ds.id) as nticket"),
            DB::raw("fnStripTags(solicitud_ticket_i_n_ds.descripcionP) as desFormat"),
            DB::raw("(CASE WHEN gestion_tickets_i_n_ds.fechaInicio IS NULL THEN 'PENDIENTE'
            ELSE DATE_FORMAT(gestion_tickets_i_n_ds.fechaInicio,'%d/%m/%Y') END) AS fechaSolicitud"),
            DB::raw("(CASE WHEN gestion_tickets_i_n_ds.id_trabajador IS NULL THEN 'PENDIENTE'
             ELSE CONCAT(trabajadores.tra_nombre,' ',trabajadores.tra_apellido) END) AS nombreTra"),'categorias.des_categoria','solicitud_ticket_i_n_ds.id_categoria')
            ->join('users', 'solicitud_ticket_i_n_ds.id_user', '=', 'users.id')
            ->join('categorias','solicitud_ticket_i_n_ds.id_categoria','=','categorias.id')
            ->join('estado_solicituds', 'solicitud_ticket_i_n_ds.id_estado', '=', 'estado_solicituds.id')
            ->join('tipo_reparacions','solicitud_ticket_i_n_ds.id_tipoReparacion','=','tipo_reparacions.id')
            ->join('servicios','solicitud_ticket_i_n_ds.id_servicio','=','servicios.id')
            ->join('gestion_tickets_i_n_ds', 'solicitud_ticket_i_n_ds.id', '=', 'gestion_tickets_i_n_ds.id_solicitud')
            ->join('trabajadores', 'gestion_tickets_i_n_ds.id_trabajador', '=', 'trabajadores.id')
            ->where('solicitud_ticket_i_n_ds.id_categoria', 3);

            $ticketAP = SolicitudTicketsAps::select('solicitud_tickets_aps.id','solicitud_tickets_aps.uuid',DB::raw("CONCAT(users.nombre,' ',users.apellido) as nombre"),
            'servicios.descripcionServicio','tipo_reparacions.descripcionTipoReparacion','solicitud_tickets_aps.descripcionP','solicitud_tickets_aps.id_estado',
            'estado_solicituds.descripcionEstado', DB::raw('TIMESTAMPDIFF(HOUR,solicitud_tickets_aps.created_at,NOW()) AS Horas'),
            DB::raw("CONCAT(solicitud_tickets_aps.id) as nticket"),
            DB::raw("fnStripTags(solicitud_tickets_aps.descripcionP) as desFormat"),
            DB::raw("(CASE WHEN solicitud_tickets_aps.created_at IS NULL THEN 'PENDIENTE'
            ELSE DATE_FORMAT(solicitud_tickets_aps.created_at,'%d/%m/%Y') END) AS fechaSolicitud"),
            DB::raw("'PENDIENTE' AS nombreTra"),'categorias.des_categoria','solicitud_tickets_aps.id_categoria')
            ->join('users', 'solicitud_tickets_aps.id_user', '=', 'users.id')
            ->join('categorias','solicitud_tickets_aps.id_categoria','=','categorias.id')
            ->join('estado_solicituds', 'solicitud_tickets_aps.id_estado', '=', 'estado_solicituds.id')
            ->join('tipo_reparacions','solicitud_tickets_aps.id_tipoReparacion','=','tipo_reparacions.id')
            ->join('servicios','solicitud_tickets_aps.id_servicio','=','servicios.id')
            ->where('solicitud_tickets_aps.id_categoria', 4)
            ->where('solicitud_tickets_aps.id_estado', 1);

            $uticketAP = SolicitudTicketsAps::select('solicitud_tickets_aps.id','solicitud_tickets_aps.uuid',DB::raw("CONCAT(users.nombre,' ',users.apellido) as nombre"),
            'servicios.descripcionServicio','tipo_reparacions.descripcionTipoReparacion','solicitud_tickets_aps.descripcionP','solicitud_tickets_aps.id_estado',
            'estado_solicituds.descripcionEstado', DB::raw('TIMESTAMPDIFF(HOUR,solicitud_tickets_aps.created_at,NOW()) AS Horas'),
            DB::raw("CONCAT(solicitud_tickets_aps.id) as nticket"),
            DB::raw("fnStripTags(solicitud_tickets_aps.descripcionP) as desFormat"),
            DB::raw("(CASE WHEN gestion_tickets_aps.fechaInicio IS NULL THEN 'PENDIENTE'
            ELSE DATE_FORMAT(gestion_tickets_aps.fechaInicio,'%d/%m/%Y') END) AS fechaSolicitud"),
            DB::raw("(CASE WHEN gestion_tickets_aps.id_trabajador IS NULL THEN 'PENDIENTE'
             ELSE CONCAT(trabajadores.tra_nombre,' ',trabajadores.tra_apellido) END) AS nombreTra"),'categorias.des_categoria','solicitud_tickets_aps.id_categoria')
            ->join('users', 'solicitud_tickets_aps.id_user', '=', 'users.id')
            ->join('categorias','solicitud_tickets_aps.id_categoria','=','categorias.id')
            ->join('estado_solicituds', 'solicitud_tickets_aps.id_estado', '=', 'estado_solicituds.id')
            ->join('tipo_reparacions','solicitud_tickets_aps.id_tipoReparacion','=','tipo_reparacions.id')
            ->join('servicios','solicitud_tickets_aps.id_servicio','=','servicios.id')
            ->join('gestion_tickets_aps', 'solicitud_tickets_aps.id', '=', 'gestion_tickets_aps.id_solicitud')
            ->join('trabajadores', 'gestion_tickets_aps.id_trabajador', '=', 'trabajadores.id')
            ->where('solicitud_tickets_aps.id_categoria', 4)
            ->union($ticket)
            ->union($uticket)
            ->union($ticketEM)
            ->union($uticketEM)
            ->union($ticketIND)
            ->union($uticketIND)
            ->union($ticketAP)
            ->orderBy('id','desc')
            ->get();

            return $uticketAP;
        } catch (\Throwable $th) {
           log::info($th);
           return false;
        }
        
    }

    public function getSolicitudUsuariosJoinI()
    {
        $ticket = SolicitudTickets::select('solicitud_tickets.*', DB::raw("CONCAT(users.nombre,' ',users.apellido) as nombre"),
        'servicios.descripcionServicio','tipo_reparacions.descripcionTipoReparacion', 
        'estado_solicituds.descripcionEstado', DB::raw('TIMESTAMPDIFF(HOUR,solicitud_tickets.created_at,NOW()) AS Horas'),
         DB::raw("CONCAT(solicitud_tickets.id) as nticket"),
         DB::raw("fnStripTags(solicitud_tickets.descripcionP) as desFormat"),
         DB::raw("DATE_FORMAT(solicitud_tickets.created_at,'%d/%m/%Y') as fechaSolicitud"),
         DB::raw("(CASE WHEN gestion_solicitudes.id_trabajador IS NULL THEN 'SIN ASIGNAR'
             ELSE CONCAT(trabajadores.tra_nombre,' ',trabajadores.tra_apellido) END) AS nombreTra"))
            ->join('users', 'solicitud_tickets.id_user', '=', 'users.id')
            ->join('estado_solicituds', 'solicitud_tickets.id_estado', '=', 'estado_solicituds.id')
            ->join('tipo_reparacions','solicitud_tickets.id_tipoReparacion','=','tipo_reparacions.id')
            ->join('servicios','solicitud_tickets.id_servicio','=','servicios.id')
            ->leftJoin('gestion_solicitudes', 'solicitud_tickets.id', '=', 'gestion_solicitudes.id_solicitud')
            ->leftJoin('trabajadores', 'gestion_solicitudes.id_trabajador', '=', 'trabajadores.id')
            ->where('id_categoria', 5)
            ->orderBy('solicitud_tickets.id', 'desc')
            ->get();
        return  $ticket;
    }

    public function NuevoTicket(Request $request)
    {   
        $validador = false;
        //Insertando Ticket
        try {
            $uuid = Uuid::uuid4();
            $id = SolicitudTickets::create(array_merge($request->all(), ['uuid' => $uuid]))->id;
            $response = GestionSolicitudes::create(array_merge($request->all(), ['uuid' => $uuid, 'id_solicitud' => $id]));
            if($request->esCadena == true){
                TicketCadenas::create(array_merge($request->all(),['idTicketNuevo' => $id]));
            };
    
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
                /* log::info($userMail);
                foreach ($userMail as $key) {
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
                //$message->setBcc(['ricardo.soto.g@redsalud.gov.cl'=> 'Ricardo Soto Gomez']);
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
            $id_busqueda_solicitante = $request->idUsuarioSesion;
            $descripcionSeguimiento = $request->descripcionSeguimiento;
            $razoncambio = $request->razoncambio;
            $descripcionFormat = $request->descripcionPFormat;
            $id_prioridad = $request->id_prioridad;

            SeguimientoSolicitudes::create($request->all());


            $response2 = SolicitudTickets::where('uuid', $request->uuid)
                ->where('id', $request->id_solicitud)
                ->update([
                    'id_edificio' => $request->id_edificio, 'id_servicio' => $request->id_servicio,
                    'id_ubicacionEx' => $request->id_ubicacionEx, 'id_tipoReparacion' => $request->id_tipoReparacion,
                    'id_estado' => $request->id_estado,'id_prioridad' => $request->id_prioridad,'descripcionP' => $descripcionFormat
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

            $validador = true;

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

            
            Mail::send('/Mails/TicketModificadoAgente',['Apoyo1' => $desApoyo1, 'Apoyo2' => $desApoyo2, 'Apoyo3' => $desApoyo3, 'estado' => $desEstado, 'fechaCreacion' => $fechacreacion, 'nombre' => $nombre, 'id' => $id_solicitud, 'descripcionTicket' => $descripcionP, 'titulo' => $tituloP, 'fecha' => $fecha, 'tra_nombre' => $nombreTrabajador, 'sup_nombre' => $nombreSupervisor , 'razon' => $razoncambio], function ($message) use($listContactos){
                $message->setTo($listContactos)->setSubject('Modificacion de ticket');
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
        //Modificando Ticket
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
        $seguimientoRazon = SeguimientoSolicitudes::create($request->all());
        $estadoEliminado = 7;
        $ticket = SolicitudTickets::find($id);
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
        $ticket = SolicitudTickets::find($id);
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
}
