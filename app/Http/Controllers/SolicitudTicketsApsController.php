<?php

namespace App\Http\Controllers;

use App\SolicitudTicketsAps;
use App\Users;
use App\seguimientoAPSolicitudes;
use App\EstadoSolicituds;
use Uuid;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\TicketEquipamientoApoyoClinicos;
use App\EquipamientoApoyoClinicos;

class SolicitudTicketsApsController extends Controller
{
    public function traerUltimoT(){
        try {
            $get_all = SolicitudTicketsAps::latest('id')->first();
            return $get_all;
        } catch (\Throwable $th) {
            log::info($th);
        }
    }

    public function GetSolicitudCreada(Request $request)
    {
        try {
            $get_all = SolicitudTicketsAps::find($request->id);
            return  $get_all;
        } catch (\Throwable $th) {
            log::info($th);
        }
    }

    public function ModificarSolicitud(Request $request)
    {
        try {
            $response2 = SolicitudTicketsAps::where('uuid', $request->uuid)
            ->where('id', $request->id)
            ->update([
                'id_edificio' => $request->id_edificio, 'id_servicio' => $request->id_servicio,
                'id_ubicacionEx' => $request->id_ubicacionEx, 'id_tipoReparacion' => $request->id_tipoReparacion,
                'id_estado' => $request->id_estado, 'descripcionP' => $request->descripcionP, 'tituloP' => $request->tituloP
            ]);

         $response = seguimientoAPSolicitudes::create($request->all());

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
            $users = DB::table('seguimiento_a_p_solicitudes')
                ->join('users', 'seguimiento_a_p_solicitudes.id_user', '=', 'users.id')
                ->select('seguimiento_a_p_solicitudes.*', 'users.nombre')
                ->where('seguimiento_a_p_solicitudes.uuid', '=', $uuid)
                ->get();
            return $users;

       } catch (\Throwable $th) {
           log::info($th);
           return false;
       }
        
    }

    public function indexEspecifico($id)
    {
        $get_all = SolicitudTicketsAps::select('solicitud_tickets_aps.*',DB::raw("CONCAT(DATE_FORMAT(solicitud_tickets_aps.created_at, '%d%m%Y'),'-',solicitud_tickets_aps.id,'-',solicitud_tickets_aps.id_user) as nticket"))
            ->where('solicitud_tickets_aps.id', '=', $id)
            ->get();
  
        return  $get_all;
    }

    public function store(Request $request)
    {
        $validarTicket = 0;
        try {
            $uuid = Uuid::generate()->string;
            $response = SolicitudTicketsAps::create(array_merge($request->all(), ['uuid' => $uuid]));
            seguimientoAPSolicitudes::create(array_merge($request->all(), ['uuid' => $uuid, 'id_solicitud' => $response->id, 'descripcionSeguimiento' => 'Ticket creado']));
            if($request->id_equipamiento_apoyoclinico > 0){
                TicketEquipamientoApoyoClinicos::create(['id_solicitud' => $response->id,'id_equipamiento_apoyoclinico' => $request->id_equipamiento_apoyoclinico]);
            }else{
                $resp = EquipamientoApoyoClinicos::create(['equipo' => $request->equipo,'marca' => $request->marca,'modelo' => $request->modelo,'serie' => $request->serie,'ninventario' => $request->ninventario]);
                TicketEquipamientoApoyoClinicos::create(['id_solicitud' => $response->id,'id_equipamiento_apoyoclinico' => $resp->id]);
            }
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
        $ticket = SolicitudTicketsAps::find($id);
        $ticket->id_estado = $estadoEliminado;
        $ticket->save();

        return true;
    }

    public function getTicketsKPITotal(){
        try {
            $get_all = SolicitudTicketsAps::select(DB::raw("COUNT(solicitud_tickets_aps.id) AS openTickets"),
            DB::raw("(SELECT COUNT(solicitud_tickets_aps.id_estado) FROM solicitud_tickets_aps WHERE solicitud_tickets_aps.id_estado = 1) AS NewTickets"),
            DB::raw("(SELECT COUNT(solicitud_tickets_aps.id_estado) FROM solicitud_tickets_aps WHERE solicitud_tickets_aps.id_estado BETWEEN 2 AND 4) AS OpenTickets"),
            DB::raw("(SELECT COUNT(solicitud_tickets_aps.id_estado) FROM solicitud_tickets_aps WHERE solicitud_tickets_aps.id_estado BETWEEN 5 AND 9) AS FinalTicket"),
            DB::raw("ROUND(((SELECT COUNT(id_estado) FROM solicitud_tickets_aps WHERE id_estado BETWEEN 5 AND 9)*100)/(SELECT COUNT(id_estado) FROM solicitud_tickets_aps),2) AS Porcentaje"))
            ->join('estado_solicituds','solicitud_tickets_aps.id_estado','=','estado_solicituds.id')
            ->get();
            return $get_all;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    //Inicio KPI
    public function getTicketsKPI(){
        try {
            $get_all = SolicitudTicketsAps::select('estado_solicituds.descripcionEstado as orderType',
            DB::raw("(CASE WHEN solicitud_tickets_aps.id_estado = 1 THEN COUNT(solicitud_tickets_aps.id_estado)
                          WHEN solicitud_tickets_aps.id_estado BETWEEN 2 AND 4 THEN (select COUNT(solicitud_tickets_aps.id_estado) from solicitud_tickets_aps where solicitud_tickets_aps.id_estado BETWEEN 2 AND 4)
                          WHEN solicitud_tickets_aps.id_estado BETWEEN 5 AND 9 THEN (select COUNT(solicitud_tickets_aps.id_estado) from solicitud_tickets_aps where solicitud_tickets_aps.id_estado BETWEEN 5 AND 9)
                          END) AS counts"),
            DB::raw("(CASE WHEN solicitud_tickets_aps.id_estado = 1 THEN 'primary'
                          WHEN solicitud_tickets_aps.id_estado BETWEEN 2 AND 4 THEN 'warning'
                          WHEN solicitud_tickets_aps.id_estado BETWEEN 5 AND 9 THEN 'success'
                          END) AS color"),
            DB::raw("(CASE WHEN solicitud_tickets_aps.id_estado = 1 THEN '#7961F9'
                          WHEN solicitud_tickets_aps.id_estado BETWEEN 2 AND 4 THEN '#FF9F43'
                          WHEN solicitud_tickets_aps.id_estado BETWEEN 5 AND 9 THEN '#1fcd39'
                          END) AS codcolor"),        
            DB::raw("(CASE WHEN solicitud_tickets_aps.id_estado = 1 THEN '#9c8cfc'
                          WHEN solicitud_tickets_aps.id_estado BETWEEN 2 AND 4 THEN '#FFC085'
                          WHEN solicitud_tickets_aps.id_estado BETWEEN 5 AND 9 THEN '#1fcd39'
                          END) AS gradcolor"),                    
            DB::raw("(CASE WHEN solicitud_tickets_aps.id_estado = 1 THEN COALESCE(ROUND(((SELECT COUNT(id_estado) FROM solicitud_tickets_aps WHERE id_estado = 1)*100)/(SELECT COUNT(id_estado) FROM solicitud_tickets_aps),1),0)
            WHEN solicitud_tickets_aps.id_estado BETWEEN 2 AND 4 THEN COALESCE(ROUND(((SELECT COUNT(id_estado) FROM solicitud_tickets_aps WHERE id_estado BETWEEN 2 AND 4)*100)/(SELECT COUNT(id_estado) FROM solicitud_tickets_aps),1),0)
            WHEN solicitud_tickets_aps.id_estado BETWEEN 5 AND 9 THEN ROUND(((SELECT COUNT(id_estado) FROM solicitud_tickets_aps WHERE id_estado BETWEEN 5 AND 9)*100)/(SELECT COUNT(id_estado) FROM solicitud_tickets),1)
            END) AS porcentaje"))
            ->join('estado_solicituds','solicitud_tickets_aps.id_estado','=','estado_solicituds.id')
            ->where('estado_solicituds.id','=','1')
            ->orWhere('estado_solicituds.id','=','2')
            ->orWhere('estado_solicituds.id','=','6')
            ->groupby('estado_solicituds.id')
            ->get();
            //log::info($get_all);
            return $get_all;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function getKPIServicio(){
        try {
            $get_all = SolicitudTicketsAps::select("servicios.descripcionServicio",DB::raw("COUNT(servicios.descripcionServicio) AS serviciomassolicitado"))
            ->join("servicios",'solicitud_tickets_aps.id_servicio','=','servicios.id')
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
            $get_all = SolicitudTicketsAps::select("users.id",DB::raw("CONCAT(users.nombre,' ',users.apellido) AS usuariosolicitante"),
            DB::raw("COUNT(solicitud_tickets_aps.id_user) massolicitante"))
            ->join("users",'solicitud_tickets_aps.id_user','=','users.id')
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
            $get_all = SolicitudTicketsAps::select("categorias.des_categoria",DB::raw("COUNT(solicitud_tickets_aps.id_categoria) AS categoriamassol"))
            ->join("categorias",'solicitud_tickets_aps.id_categoria','=','categorias.id')
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
            $get_all = SolicitudTicketsAps::select("tipo_reparacions.descripcionTipoReparacion",DB::raw("COUNT(solicitud_tickets_aps.id_tipoReparacion) AS tipomassol"))
            ->join("tipo_reparacions",'solicitud_tickets_aps.id_tipoReparacion','=','tipo_reparacions.id')
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
            $get_all = SolicitudTicketsAps::select(DB::raw("fnStripTags(solicitud_tickets_aps.descripcionP) as msg"),'solicitud_tickets_aps.id',
            'solicitud_tickets_aps.uuid','solicitud_tickets_aps.id_user','tipo_reparacions.descripcionTipoReparacion')
            ->join("tipo_reparacions",'solicitud_tickets_aps.id_tipoReparacion','=','tipo_reparacions.id')
            ->where("solicitud_tickets_aps.id_estado","=",2)
            ->limit(5)
            ->orderBy('solicitud_tickets_aps.id', 'desc')
            ->get();
            return $get_all;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function getNotificacionesN(){
        try {
            $get_all = SolicitudTicketsAps::select(DB::raw("fnStripTags(solicitud_tickets_aps.descripcionP) as msg"),'solicitud_tickets_aps.id',
            'solicitud_tickets_aps.uuid','solicitud_tickets_aps.id_user','tipo_reparacions.descripcionTipoReparacion')
            ->join("tipo_reparacions",'solicitud_tickets_aps.id_tipoReparacion','=','tipo_reparacions.id')
            ->where("solicitud_tickets_aps.id_estado","=",1)
            ->limit(5)
            ->orderBy('solicitud_tickets_aps.id', 'desc')
            ->get();
            return $get_all;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
}
