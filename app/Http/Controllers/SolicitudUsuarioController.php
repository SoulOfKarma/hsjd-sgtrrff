<?php

namespace App\Http\Controllers;

use App\Mail\TicketGenerado;
use App\SolicitudTickets;
use App\Users;
use App\SeguimientoSolicitudes;
use App\EstadoSolicituds;
use Uuid;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\SolicitudTicketINDs;
use App\SolicitudTicketsEM;
use App\SolicitudTicketsAps;

class SolicitudUsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {

        $get_all = SolicitudTickets::all();

        return  $get_all;
    }

    public function traerUltimoT(){
        try {
            $get_all = SolicitudTickets::latest('id')->first();
            return $get_all;
        } catch (\Throwable $th) {
            log::info($th);
        }
    }

    public function GetSolicitudCreada(Request $request)
    {
        try {
            $get_all = SolicitudTickets::find($request->id);
            return  $get_all;
        } catch (\Throwable $th) {
            log::info($th);
        }
        
    }

    public function getSolicitudUsuariosByID(Request $request)//Listado Usuarios - Agregar MultiTablas
    {
        $estadoEliminado = [7];

        //$ticket = SolicitudTickets::select('solicitud_tickets.*', 'users.nombre','users.apellido', 'estado_solicituds.descripcionEstado', DB::raw('TIMESTAMPDIFF(HOUR,solicitud_tickets.created_at,NOW()) AS Horas'), DB::raw("CONCAT(DATE_FORMAT(solicitud_tickets.created_at, '%d%m%Y'),'-',solicitud_tickets.id,'-',solicitud_tickets.id_user) as nticket"))
        $ticketInfra = SolicitudTickets::select('solicitud_tickets.*', DB::raw("CONCAT(solicitud_tickets.id) as nticket"),
         'estado_solicituds.descripcionEstado',DB::raw("DATE_FORMAT(solicitud_tickets.created_at,'%d/%m/%Y') as fechaSolicitud"),
         'servicios.descripcionServicio',DB::raw("CONCAT(users.nombre,' ',users.apellido) as nombre"),
         DB::raw('TIMESTAMPDIFF(HOUR,solicitud_tickets.created_at,NOW()) AS Horas'),
         DB::raw("CONCAT(DATE_FORMAT(solicitud_tickets.created_at,'%H:%i:%s')) as horaSolicitud"),
         'tipo_reparacions.descripcionTipoReparacion', DB::raw("fnStripTags(solicitud_tickets.descripcionP) as desFormat"))
            ->join('users', 'solicitud_tickets.id_user', '=', 'users.id')
            ->join('tipo_reparacions','solicitud_tickets.id_tipoReparacion','=','tipo_reparacions.id')
            ->join('servicios','solicitud_tickets.id_servicio','=','servicios.id')
            ->join('estado_solicituds', 'solicitud_tickets.id_estado', '=', 'estado_solicituds.id')
            ->whereNotIn('solicitud_tickets.id_estado',$estadoEliminado)
            ->where('solicitud_tickets.id_servicio', $request->idServicio)
            ->orWhere('solicitud_tickets.id_user',$request->idUser)
            ->whereNotIn('solicitud_tickets.id_estado',$estadoEliminado);

        $ticketEM = SolicitudTicketsEM::select('solicitud_tickets_e_m_s.*', DB::raw("CONCAT(solicitud_tickets_e_m_s.id) as nticket"),
            'estado_solicituds.descripcionEstado',DB::raw("DATE_FORMAT(solicitud_tickets_e_m_s.created_at,'%d/%m/%Y') as fechaSolicitud"),
            'servicios.descripcionServicio',DB::raw("CONCAT(users.nombre,' ',users.apellido) as nombre"),
            DB::raw('TIMESTAMPDIFF(HOUR,solicitud_tickets_e_m_s.created_at,NOW()) AS Horas'),
            DB::raw("CONCAT(DATE_FORMAT(solicitud_tickets_e_m_s.created_at,'%H:%i:%s')) as horaSolicitud"),
            'tipo_reparacions.descripcionTipoReparacion', DB::raw("fnStripTags(solicitud_tickets_e_m_s.descripcionP) as desFormat"))
               ->join('users', 'solicitud_tickets_e_m_s.id_user', '=', 'users.id')
               ->join('tipo_reparacions','solicitud_tickets_e_m_s.id_tipoReparacion','=','tipo_reparacions.id')
               ->join('servicios','solicitud_tickets_e_m_s.id_servicio','=','servicios.id')
               ->join('estado_solicituds', 'solicitud_tickets_e_m_s.id_estado', '=', 'estado_solicituds.id')
               ->whereNotIn('solicitud_tickets_e_m_s.id_estado',$estadoEliminado)
               ->where('solicitud_tickets_e_m_s.id_servicio', $request->idServicio)
               ->orWhere('solicitud_tickets_e_m_s.id_user',$request->idUser)
               ->whereNotIn('solicitud_tickets_e_m_s.id_estado',$estadoEliminado);

        $ticketIND = SolicitudTicketINDs::select('solicitud_ticket_i_n_ds.*', DB::raw("CONCAT(solicitud_ticket_i_n_ds.id) as nticket"),
               'estado_solicituds.descripcionEstado',DB::raw("DATE_FORMAT(solicitud_ticket_i_n_ds.created_at,'%d/%m/%Y') as fechaSolicitud"),
               'servicios.descripcionServicio',DB::raw("CONCAT(users.nombre,' ',users.apellido) as nombre"),
               DB::raw('TIMESTAMPDIFF(HOUR,solicitud_ticket_i_n_ds.created_at,NOW()) AS Horas'),
               DB::raw("CONCAT(DATE_FORMAT(solicitud_ticket_i_n_ds.created_at,'%H:%i:%s')) as horaSolicitud"),
               'tipo_reparacions.descripcionTipoReparacion', DB::raw("fnStripTags(solicitud_ticket_i_n_ds.descripcionP) as desFormat"))
                  ->join('users', 'solicitud_ticket_i_n_ds.id_user', '=', 'users.id')
                  ->join('tipo_reparacions','solicitud_ticket_i_n_ds.id_tipoReparacion','=','tipo_reparacions.id')
                  ->join('servicios','solicitud_ticket_i_n_ds.id_servicio','=','servicios.id')
                  ->join('estado_solicituds', 'solicitud_ticket_i_n_ds.id_estado', '=', 'estado_solicituds.id')
                  ->whereNotIn('solicitud_ticket_i_n_ds.id_estado',$estadoEliminado)
                  ->where('solicitud_ticket_i_n_ds.id_servicio', $request->idServicio)
                  ->orWhere('solicitud_ticket_i_n_ds.id_user',$request->idUser)
                  ->whereNotIn('solicitud_ticket_i_n_ds.id_estado',$estadoEliminado);

        $ticketAP = SolicitudTicketsAps::select('solicitud_tickets_aps.*', DB::raw("CONCAT(solicitud_tickets_aps.id) as nticket"),
                  'estado_solicituds.descripcionEstado',DB::raw("DATE_FORMAT(solicitud_tickets_aps.created_at,'%d/%m/%Y') as fechaSolicitud"),
                  'servicios.descripcionServicio',DB::raw("CONCAT(users.nombre,' ',users.apellido) as nombre"),
                  DB::raw('TIMESTAMPDIFF(HOUR,solicitud_tickets_aps.created_at,NOW()) AS Horas'),
                  DB::raw("CONCAT(DATE_FORMAT(solicitud_tickets_aps.created_at,'%H:%i:%s')) as horaSolicitud"),
                  'tipo_reparacions.descripcionTipoReparacion', DB::raw("fnStripTags(solicitud_tickets_aps.descripcionP) as desFormat"))
                     ->join('users', 'solicitud_tickets_aps.id_user', '=', 'users.id')
                     ->join('tipo_reparacions','solicitud_tickets_aps.id_tipoReparacion','=','tipo_reparacions.id')
                     ->join('servicios','solicitud_tickets_aps.id_servicio','=','servicios.id')
                     ->join('estado_solicituds', 'solicitud_tickets_aps.id_estado', '=', 'estado_solicituds.id')
                     ->whereNotIn('solicitud_tickets_aps.id_estado',$estadoEliminado)
                     ->where('solicitud_tickets_aps.id_servicio', $request->idServicio)
                     ->orWhere('solicitud_tickets_aps.id_user',$request->idUser)
                     ->whereNotIn('solicitud_tickets_aps.id_estado',$estadoEliminado)
                     ->union($ticketInfra)
                     ->union($ticketEM)
                     ->union($ticketIND)
                     ->orderBy('created_at', 'desc')
                     ->get(); 
        return  $ticketAP;
    }


    public function getSolicitudUsuariosJoin($idServicio)
    {
        $estadoEliminado = 7;

        $ticket = SolicitudTickets::select('solicitud_tickets.*', 'users.nombre','users.apellido', 'estado_solicituds.descripcionEstado', DB::raw('TIMESTAMPDIFF(HOUR,solicitud_tickets.created_at,NOW()) AS Horas'), DB::raw("CONCAT(DATE_FORMAT(solicitud_tickets.created_at, '%d%m%Y'),'-',solicitud_tickets.id,'-',solicitud_tickets.id_user) as nticket"))
            ->join('users', 'solicitud_tickets.id_user', '=', 'users.id')
            ->join('estado_solicituds', 'solicitud_tickets.id_estado', '=', 'estado_solicituds.id')
            ->where('solicitud_tickets.id_servicio', $idServicio)
            ->where('solicitud_tickets.id_estado', '!=', $estadoEliminado)
            ->get(); 
        return  $ticket;
    }

    public function getTicketsAsignadosJoin($id)//Trabajador.
    {
        $ticket = SolicitudTickets::select('solicitud_tickets.*', 
        DB::raw("DATE_FORMAT(solicitud_tickets.created_at, '%d/%m/%Y') as fechaCreacion"),
         DB::raw("DATE_FORMAT(gestion_solicitudes.fechaInicio, '%d/%m/%Y') as fechaAsignacion"),
          'gestion_solicitudes.*', DB::raw("fnStripTags(solicitud_tickets.descripcionP) as desFormat"),
          DB::raw("CONCAT(supervisores.sup_nombre,' ',supervisores.sup_apellido) as sup_nombre_apellido"),
          DB::raw("CONCAT(trabajadores.tra_nombre,' ',trabajadores.tra_apellido) as tra_nombre_apellido"),
           DB::raw("CONCAT(users.nombre,' ',users.apellido) as nombre_solicitante"), 
           'estado_solicituds.descripcionEstado', 'servicios.descripcionServicio','tipo_reparacions.descripcionTipoReparacion',
           DB::raw("CONCAT(solicitud_tickets.id) as nticket"))
            ->join('users', 'solicitud_tickets.id_user', '=', 'users.id')
            ->join('tipo_reparacions','solicitud_tickets.id_tipoReparacion','=','tipo_reparacions.id')
        ->join('servicios','solicitud_tickets.id_servicio','=','servicios.id')
            ->join('estado_solicituds', 'solicitud_tickets.id_estado', '=', 'estado_solicituds.id')
            ->join('gestion_solicitudes', 'solicitud_tickets.id', '=', 'gestion_solicitudes.id_solicitud')
            ->join('supervisores', 'gestion_solicitudes.id_supervisor', '=', 'supervisores.id')
            ->join('trabajadores', 'gestion_solicitudes.id_trabajador', '=', 'trabajadores.id')
            ->where('gestion_solicitudes.id_trabajador', $id)
            ->orderBy('solicitud_tickets.id', 'desc')
            ->get();



        return  $ticket;
    }

    public function ModificarSolicitud(Request $request)
    {
        try {
            $response2 = SolicitudTickets::where('uuid', $request->uuid)
            ->where('id', $request->id)
            ->update([
                'id_edificio' => $request->id_edificio, 'id_servicio' => $request->id_servicio,
                'id_ubicacionEx' => $request->id_ubicacionEx, 'id_tipoReparacion' => $request->id_tipoReparacion,
                'id_estado' => $request->id_estado, 'id_prioridad' => $request->id_prioridad, 'descripcionP' => $request->descripcionP, 'tituloP' => $request->tituloP
            ]);

         $response = SeguimientoSolicitudes::create($request->all());

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
            return false;
        }
 
    }

    public function indexSeguimiento($uuid)
    {
       try {
            $users = DB::table('seguimiento_solicitudes')
                ->join('users', 'seguimiento_solicitudes.id_user', '=', 'users.id')
                ->select('seguimiento_solicitudes.*', 'users.nombre')
                ->where('seguimiento_solicitudes.uuid', '=', $uuid)
                ->get();
            return $users;

       } catch (\Throwable $th) {
           log::info($th);
           return false;
       }
        
    }

    public function indexEspecifico($id)
    {
        $get_all = SolicitudTickets::select('solicitud_tickets.*',DB::raw("CONCAT(DATE_FORMAT(solicitud_tickets.created_at, '%d%m%Y'),'-',solicitud_tickets.id,'-',solicitud_tickets.id_user) as nticket"))
            ->where('solicitud_tickets.id', '=', $id)
            ->get();
  
        return  $get_all;
    }

    //Inicio KPI
    public function getTicketsKPI(){
        try {
            $get_all = SolicitudTickets::select('estado_solicituds.descripcionEstado as orderType',
            DB::raw("(CASE WHEN solicitud_tickets.id_estado = 1 THEN COUNT(solicitud_tickets.id_estado)
                          WHEN solicitud_tickets.id_estado = 2 THEN COUNT(solicitud_tickets.id_estado)
                          WHEN solicitud_tickets.id_estado = 4 THEN COUNT(solicitud_tickets.id_estado)
                          WHEN solicitud_tickets.id_estado = 6 THEN (select COUNT(solicitud_tickets.id_estado) from solicitud_tickets where solicitud_tickets.id_estado BETWEEN 5 AND 6)
                          WHEN solicitud_tickets.id_estado = 7 THEN COUNT(solicitud_tickets.id_estado)
                          END) AS counts"),
            DB::raw("(CASE WHEN solicitud_tickets.id_estado = 1 THEN 'primary'
                          WHEN solicitud_tickets.id_estado = 2 THEN 'warning'
                          WHEN solicitud_tickets.id_estado = 4 THEN 'danger'
                          WHEN solicitud_tickets.id_estado = 6 THEN 'success'
                          WHEN solicitud_tickets.id_estado = 7 THEN 'dark'
                          END) AS color"),
            DB::raw("(CASE WHEN solicitud_tickets.id_estado = 1 THEN '#7961F9'
                          WHEN solicitud_tickets.id_estado = 2 THEN '#FF9F43'
                          WHEN solicitud_tickets.id_estado = 4 THEN '#EA5455'
                          WHEN solicitud_tickets.id_estado = 6 THEN '#1fcd39'
                          WHEN solicitud_tickets.id_estado = 7 THEN '#000000'
                          END) AS codcolor"),        
            DB::raw("(CASE WHEN solicitud_tickets.id_estado = 1 THEN '#9c8cfc'
                          WHEN solicitud_tickets.id_estado = 2 THEN '#FFC085'
                          WHEN solicitud_tickets.id_estado = 4 THEN '#f29292'
                          WHEN solicitud_tickets.id_estado = 6 THEN '#1fcd39'
                          WHEN solicitud_tickets.id_estado = 7 THEN '#000000'
                          END) AS gradcolor"),                    
            DB::raw("(CASE WHEN solicitud_tickets.id_estado = 1 THEN COALESCE(ROUND(((SELECT COUNT(id_estado) FROM solicitud_tickets WHERE id_estado = 1)*100)/(SELECT COUNT(id_estado) FROM solicitud_tickets),1),0)
            WHEN solicitud_tickets.id_estado = 2 THEN COALESCE(ROUND(((SELECT COUNT(id_estado) FROM solicitud_tickets WHERE id_estado = 2)*100)/(SELECT COUNT(id_estado) FROM solicitud_tickets),1),0)
            WHEN solicitud_tickets.id_estado = 4 THEN COALESCE(ROUND(((SELECT COUNT(id_estado) FROM solicitud_tickets WHERE id_estado = 4)*100)/(SELECT COUNT(id_estado) FROM solicitud_tickets),1),0)
            WHEN solicitud_tickets.id_estado = 5 || solicitud_tickets.id_estado = 6 THEN ROUND(((SELECT COUNT(id_estado) FROM solicitud_tickets WHERE id_estado = 5 || id_estado = 6)*100)/(SELECT COUNT(id_estado) FROM solicitud_tickets),1)
            WHEN solicitud_tickets.id_estado = 7 THEN COALESCE(ROUND(((SELECT COUNT(id_estado) FROM solicitud_tickets WHERE id_estado = 7)*100)/(SELECT COUNT(id_estado) FROM solicitud_tickets),1),0)
            END) AS porcentaje"))
            ->join('estado_solicituds','solicitud_tickets.id_estado','=','estado_solicituds.id')
            ->where('estado_solicituds.id','=','1')
            ->orWhere('estado_solicituds.id','=','2')
            ->orWhere('estado_solicituds.id','=','4')
            ->orWhere('estado_solicituds.id','=','6')
            ->orWhere('estado_solicituds.id','=','7')
            ->groupby('estado_solicituds.id')
            ->get();
            //log::info($get_all);
            return $get_all;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function getTicketsKPITotal(){
        try {
            $get_all = SolicitudTickets::select(DB::raw("COUNT(solicitud_tickets.id) AS openTickets"),
            DB::raw("(SELECT COUNT(solicitud_tickets.id_estado) FROM solicitud_tickets WHERE solicitud_tickets.id_estado = 1) AS NewTickets"),
            DB::raw("(SELECT COUNT(solicitud_tickets.id_estado) FROM solicitud_tickets WHERE solicitud_tickets.id_estado BETWEEN 2 AND 4) AS OpenTickets"),
            DB::raw("(SELECT COUNT(solicitud_tickets.id_estado) FROM solicitud_tickets WHERE solicitud_tickets.id_estado BETWEEN 5 AND 6) AS FinalTicket"),
            DB::raw("ROUND(((SELECT COUNT(id_estado) FROM solicitud_tickets WHERE id_estado BETWEEN 5 AND 6)*100)/(SELECT COUNT(id_estado) FROM solicitud_tickets),2) AS Porcentaje"))
            ->join('estado_solicituds','solicitud_tickets.id_estado','=','estado_solicituds.id')
            ->get();
            return $get_all;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function getKPIServicio(){
        try {
            $get_all = solicitudTickets::select("servicios.descripcionServicio",DB::raw("COUNT(servicios.descripcionServicio) AS serviciomassolicitado"))
            ->join("servicios",'solicitud_tickets.id_servicio','=','servicios.id')
            ->groupby("servicios.id")
            ->orderBy('serviciomassolicitado', 'desc')
            ->limit(1)
            ->get();

            return $get_all;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function getKPIUsuario(){
        try {
            $get_all = solicitudTickets::select("users.id",DB::raw("CONCAT(users.nombre,' ',users.apellido) AS usuariosolicitante"),
            DB::raw("COUNT(solicitud_tickets.id_user) massolicitante"))
            ->join("users",'solicitud_tickets.id_user','=','users.id')
            ->groupby("users.id")
            ->orderBy('massolicitante', 'desc')
            ->limit(1)
            ->get();

            return $get_all;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function getKPICategoria(){
        try {
            $get_all = solicitudTickets::select("categorias.des_categoria",DB::raw("COUNT(solicitud_tickets.id_categoria) AS categoriamassol"))
            ->join("categorias",'solicitud_tickets.id_categoria','=','categorias.id')
            ->groupby("categorias.id")
            ->orderBy('categoriamassol', 'DESC')
            ->limit(1)
            ->get();

            return $get_all;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function getKPITipoMantencion(){
        try {
            $get_all = solicitudTickets::select("tipo_reparacions.descripcionTipoReparacion",DB::raw("COUNT(solicitud_tickets.id_tipoReparacion) AS tipomassol"))
            ->join("tipo_reparacions",'solicitud_tickets.id_categoria','=','tipo_reparacions.id')
            ->groupby("tipo_reparacions.id")
            ->orderBy('tipomassol', 'desc')
            ->limit(1)
            ->get();

            return $get_all;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function getNotificaciones(){
        try {
            $get_all = solicitudTickets::select(DB::raw("fnStripTags(solicitud_tickets.descripcionP) as msg"),'solicitud_tickets.id',
            'solicitud_tickets.uuid','solicitud_tickets.id_user','tipo_reparacions.descripcionTipoReparacion')
            ->join("tipo_reparacions",'solicitud_tickets.id_tipoReparacion','=','tipo_reparacions.id')
            ->where("solicitud_tickets.id_estado","=",2)
            ->limit(5)
            ->orderBy('solicitud_tickets.id', 'desc')
            ->get();
            return $get_all;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function getNotificacionesN(){
        try {
            $get_all = solicitudTickets::select(DB::raw("fnStripTags(solicitud_tickets.descripcionP) as msg"),'solicitud_tickets.id',
            'solicitud_tickets.uuid','solicitud_tickets.id_user','tipo_reparacions.descripcionTipoReparacion')
            ->join("tipo_reparacions",'solicitud_tickets.id_tipoReparacion','=','tipo_reparacions.id')
            ->where("solicitud_tickets.id_estado","=",1)
            ->limit(5)
            ->orderBy('solicitud_tickets.id', 'desc')
            ->get();
            return $get_all;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
    //Fin KPI

    //Store Infraestructura
    public function store(Request $request)
    {
        try {
            $uuid = Uuid::generate()->string;
            $response = SolicitudTickets::create(array_merge($request->all(), ['uuid' => $uuid]));
            SeguimientoSolicitudes::create(array_merge($request->all(), ['uuid' => $uuid, 'id_solicitud' => $response->id, 'descripcionSeguimiento' => 'Ticket creado']));
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
        $ticket = SolicitudTickets::find($id);
        $ticket->id_estado = $estadoEliminado;
        $ticket->save();

        return true;
    }


}
