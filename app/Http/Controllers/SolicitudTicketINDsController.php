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

    public function getTicketsKPITotal(){
        try {
            $get_all = SolicitudTicketINDs::select(DB::raw("COUNT(solicitud_ticket_i_n_ds.id) AS openTickets"),
            DB::raw("(SELECT COUNT(solicitud_ticket_i_n_ds.id_estado) FROM solicitud_ticket_i_n_ds WHERE solicitud_ticket_i_n_ds.id_estado = 1) AS NewTickets"),
            DB::raw("(SELECT COUNT(solicitud_ticket_i_n_ds.id_estado) FROM solicitud_ticket_i_n_ds WHERE solicitud_ticket_i_n_ds.id_estado BETWEEN 2 AND 4) AS OpenTickets"),
            DB::raw("(SELECT COUNT(solicitud_ticket_i_n_ds.id_estado) FROM solicitud_ticket_i_n_ds WHERE solicitud_ticket_i_n_ds.id_estado BETWEEN 5 AND 6) AS FinalTicket"),
            DB::raw("ROUND(((SELECT COUNT(id_estado) FROM solicitud_ticket_i_n_ds WHERE id_estado BETWEEN 5 AND 6)*100)/(SELECT COUNT(id_estado) FROM solicitud_ticket_i_n_ds),2) AS Porcentaje"))
            ->join('estado_solicituds','solicitud_ticket_i_n_ds.id_estado','=','estado_solicituds.id')
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
            $get_all = SolicitudTicketINDs::select('estado_solicituds.descripcionEstado as orderType',
            DB::raw("(CASE WHEN solicitud_ticket_i_n_ds.id_estado = 1 THEN COUNT(solicitud_ticket_i_n_ds.id_estado)
                          WHEN solicitud_ticket_i_n_ds.id_estado = 2 THEN COUNT(solicitud_ticket_i_n_ds.id_estado)
                          WHEN solicitud_ticket_i_n_ds.id_estado = 4 THEN COUNT(solicitud_ticket_i_n_ds.id_estado)
                          WHEN solicitud_ticket_i_n_ds.id_estado = 6 THEN (select COUNT(solicitud_ticket_i_n_ds.id_estado) from solicitud_ticket_i_n_ds where solicitud_ticket_i_n_ds.id_estado BETWEEN 5 AND 6)
                          WHEN solicitud_ticket_i_n_ds.id_estado = 7 THEN COUNT(solicitud_ticket_i_n_ds.id_estado)
                          END) AS counts"),
            DB::raw("(CASE WHEN solicitud_ticket_i_n_ds.id_estado = 1 THEN 'primary'
                          WHEN solicitud_ticket_i_n_ds.id_estado = 2 THEN 'warning'
                          WHEN solicitud_ticket_i_n_ds.id_estado = 4 THEN 'danger'
                          WHEN solicitud_ticket_i_n_ds.id_estado = 6 THEN 'success'
                          WHEN solicitud_ticket_i_n_ds.id_estado = 7 THEN 'dark'
                          END) AS color"),
            DB::raw("(CASE WHEN solicitud_ticket_i_n_ds.id_estado = 1 THEN '#7961F9'
                          WHEN solicitud_ticket_i_n_ds.id_estado = 2 THEN '#FF9F43'
                          WHEN solicitud_ticket_i_n_ds.id_estado = 4 THEN '#EA5455'
                          WHEN solicitud_ticket_i_n_ds.id_estado = 6 THEN '#1fcd39'
                          WHEN solicitud_ticket_i_n_ds.id_estado = 7 THEN '#000000'
                          END) AS codcolor"),        
            DB::raw("(CASE WHEN solicitud_ticket_i_n_ds.id_estado = 1 THEN '#9c8cfc'
                          WHEN solicitud_ticket_i_n_ds.id_estado = 2 THEN '#FFC085'
                          WHEN solicitud_ticket_i_n_ds.id_estado = 4 THEN '#f29292'
                          WHEN solicitud_ticket_i_n_ds.id_estado = 6 THEN '#1fcd39'
                          WHEN solicitud_ticket_i_n_ds.id_estado = 7 THEN '#000000'
                          END) AS gradcolor"),                    
            DB::raw("(CASE WHEN solicitud_ticket_i_n_ds.id_estado = 1 THEN COALESCE(ROUND(((SELECT COUNT(id_estado) FROM solicitud_ticket_i_n_ds WHERE id_estado = 1)*100)/(SELECT COUNT(id_estado) FROM solicitud_ticket_i_n_ds),1),0)
            WHEN solicitud_ticket_i_n_ds.id_estado = 2 THEN COALESCE(ROUND(((SELECT COUNT(id_estado) FROM solicitud_ticket_i_n_ds WHERE id_estado = 2)*100)/(SELECT COUNT(id_estado) FROM solicitud_ticket_i_n_ds),1),0)
            WHEN solicitud_ticket_i_n_ds.id_estado = 4 THEN COALESCE(ROUND(((SELECT COUNT(id_estado) FROM solicitud_ticket_i_n_ds WHERE id_estado = 4)*100)/(SELECT COUNT(id_estado) FROM solicitud_ticket_i_n_ds),1),0)
            WHEN solicitud_ticket_i_n_ds.id_estado = 5 || solicitud_ticket_i_n_ds.id_estado = 6 THEN ROUND(((SELECT COUNT(id_estado) FROM solicitud_ticket_i_n_ds WHERE id_estado = 5 || id_estado = 6)*100)/(SELECT COUNT(id_estado) FROM solicitud_tickets),1)
            WHEN solicitud_ticket_i_n_ds.id_estado = 7 THEN COALESCE(ROUND(((SELECT COUNT(id_estado) FROM solicitud_ticket_i_n_ds WHERE id_estado = 7)*100)/(SELECT COUNT(id_estado) FROM solicitud_ticket_i_n_ds),1),0)
            END) AS porcentaje"))
            ->join('estado_solicituds','solicitud_ticket_i_n_ds.id_estado','=','estado_solicituds.id')
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

    public function getKPIServicio(){
        try {
            $get_all = SolicitudTicketINDs::select("servicios.descripcionServicio",DB::raw("COUNT(servicios.descripcionServicio) AS serviciomassolicitado"))
            ->join("servicios",'solicitud_ticket_i_n_ds.id_servicio','=','servicios.id')
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
            $get_all = SolicitudTicketINDs::select("users.id",DB::raw("CONCAT(users.nombre,' ',users.apellido) AS usuariosolicitante"),
            DB::raw("COUNT(solicitud_ticket_i_n_ds.id_user) massolicitante"))
            ->join("users",'solicitud_ticket_i_n_ds.id_user','=','users.id')
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
            $get_all = SolicitudTicketINDs::select("categorias.des_categoria",DB::raw("COUNT(solicitud_ticket_i_n_ds.id_categoria) AS categoriamassol"))
            ->join("categorias",'solicitud_ticket_i_n_ds.id_categoria','=','categorias.id')
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
            $get_all = SolicitudTicketINDs::select("tipo_reparacions.descripcionTipoReparacion",DB::raw("COUNT(solicitud_ticket_i_n_ds.id_tipoReparacion) AS tipomassol"))
            ->join("tipo_reparacions",'solicitud_ticket_i_n_ds.id_tipoReparacion','=','tipo_reparacions.id')
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
            $get_all = solicitudTickets::select(DB::raw("fnStripTags(solicitud_ticket_i_n_ds.descripcionP) as msg"),'solicitud_ticket_i_n_ds.id',
            'solicitud_ticket_i_n_ds.uuid','solicitud_ticket_i_n_ds.id_user','tipo_reparacions.descripcionTipoReparacion')
            ->join("tipo_reparacions",'solicitud_ticket_i_n_ds.id_tipoReparacion','=','tipo_reparacions.id')
            ->where("solicitud_ticket_i_n_ds.id_estado","=",2)
            ->limit(5)
            ->orderBy('solicitud_ticket_i_n_ds.id', 'desc')
            ->get();
            return $get_all;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function getNotificacionesN(){
        try {
            $get_all = solicitudTickets::select(DB::raw("fnStripTags(solicitud_ticket_i_n_ds.descripcionP) as msg"),'solicitud_ticket_i_n_ds.id',
            'solicitud_ticket_i_n_ds.uuid','solicitud_ticket_i_n_ds.id_user','tipo_reparacions.descripcionTipoReparacion')
            ->join("tipo_reparacions",'solicitud_ticket_i_n_ds.id_tipoReparacion','=','tipo_reparacions.id')
            ->where("solicitud_ticket_i_n_ds.id_estado","=",1)
            ->limit(5)
            ->orderBy('solicitud_ticket_i_n_ds.id', 'desc')
            ->get();
            return $get_all;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
}
