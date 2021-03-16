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

class SolicitudUsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    

    public function createTicketInformatica(Request $request){
        $response = Http::withToken($request->token)->asForm()->post('http://10.4.237.33:80/ticket/public/api/v1/helpdesk/create?apikey=PZe1Mv3VhuLnTXNSEE1si1R0e53DRp8C', [
            'api_key' => $request->api_key,
            'user_id' => $request->user_id,
            'subject' => $request->subject,
            'body' => $request->body,
            'helptopic' => $request->helptopic,
            'sla' => $request->sla,
            'dept' => $request->dept,
            'token' => $request->token,
           'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'code' => $request->code,
            'mobile' => $request->mobile,
            'duedate' => $request->duedate,
            'email' => $request->email
            
        ]);
        log::info($response);
        
        if($response->successful()){
            return true;
        }else if($response->clientError()){
            return "No pesco 1";
        }else if($response->serverError()){
            return "No pesco 2";
        }
        
       
    }
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

    public function GetSolicitudCreada($id)
    {
        $get_all = SolicitudTickets::find($id);
        return  $get_all;
    }

    public function getSolicitudUsuariosByID(Request $request)
    {
        $estadoEliminado = [7];

        $ticket = SolicitudTickets::select('solicitud_tickets.*', 'users.nombre','users.apellido', 'estado_solicituds.descripcionEstado', DB::raw('TIMESTAMPDIFF(HOUR,solicitud_tickets.created_at,NOW()) AS Horas'), DB::raw("CONCAT(DATE_FORMAT(solicitud_tickets.created_at, '%d%m%Y'),'-',solicitud_tickets.id,'-',solicitud_tickets.id_user) as nticket"))
            ->join('users', 'solicitud_tickets.id_user', '=', 'users.id')
            ->join('estado_solicituds', 'solicitud_tickets.id_estado', '=', 'estado_solicituds.id')
            ->whereNotIn('solicitud_tickets.id_estado',$estadoEliminado)
            ->where('solicitud_tickets.id_servicio', $request->idServicio)
            ->orWhere('solicitud_tickets.id_user',$request->idUser)
            ->whereNotIn('solicitud_tickets.id_estado',$estadoEliminado)
            ->orderBy('solicitud_tickets.id', 'desc')
            ->get(); 
        return  $ticket;
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

    public function getTicketsAsignadosJoin($id)
    {

        $ticket = SolicitudTickets::select('solicitud_tickets.*', DB::raw("DATE_FORMAT(solicitud_tickets.created_at, '%d/%m/%Y') as fechaCreacion"), DB::raw("DATE_FORMAT(gestion_solicitudes.fechaInicio, '%d/%m/%Y') as fechaAsignacion"), 'gestion_solicitudes.*', DB::raw("CONCAT(supervisores.sup_nombre,' ',supervisores.sup_apellido) as sup_nombre_apellido"),DB::raw("CONCAT(trabajadores.tra_nombre,' ',trabajadores.tra_apellido) as tra_nombre_apellido"), DB::raw("CONCAT(users.nombre,' ',users.apellido) as nombre_solicitante"), 'estado_solicituds.descripcionEstado', DB::raw("CONCAT(DATE_FORMAT(solicitud_tickets.created_at, '%d%m%Y'),'-',solicitud_tickets.id,'-',solicitud_tickets.id_user) as nticket"))
            ->join('users', 'solicitud_tickets.id_user', '=', 'users.id')
            ->join('estado_solicituds', 'solicitud_tickets.id_estado', '=', 'estado_solicituds.id')
            ->join('gestion_solicitudes', 'solicitud_tickets.id', '=', 'gestion_solicitudes.id_solicitud')
            ->join('supervisores', 'gestion_solicitudes.id_supervisor', '=', 'supervisores.id')
            ->join('trabajadores', 'gestion_solicitudes.id_trabajador', '=', 'trabajadores.id')
            ->where('gestion_solicitudes.id_trabajador', $id)
            ->get();



        return  $ticket;
    }

    public function ModificarSolicitud(Request $request)
    {
       
            $response2 = SolicitudTickets::where('uuid', $request->uuid)
            ->where('id', $request->id)
            ->update([
                'id_edificio' => $request->id_edificio, 'id_servicio' => $request->id_servicio,
                'id_ubicacionEx' => $request->id_ubicacionEx, 'id_tipoReparacion' => $request->id_tipoReparacion,
                'id_estado' => $request->id_estado, 'descripcionP' => $request->descripcionP, 'tituloP' => $request->tituloP
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

            $listContactos = [];
            $i = 0;

            foreach ($userMail as $key) {
                $listContactos[$i] = $key->email;
                $i++;
            }
            
            Mail::send('/Mails/SolicitudModificadaUsuario',['nombre' => $nombre, 'id' => $id, 'titulo' => $titulo, 'descripcionTicket' => $descripcionProblema, 'estado' => $desEstado, 'razon' => $razon], function ($message) use($listContactos){
                $message->setTo($listContactos)->setSubject('Modificacion de ticket');
                $message->setFrom('mantencion.hsjd@redsalud.gov.cl', 'Mantencion');
                $message->setBcc(['ricardo.soto.g@redsalud.gov.cl'=> 'Ricardo Soto Gomez']);
            });
            return "ok";

       
        
    }

    public function indexSeguimiento($uuid)
    {

        $users = DB::table('seguimiento_solicitudes')
            ->join('users', 'seguimiento_solicitudes.id_user', '=', 'users.id')
            ->select('seguimiento_solicitudes.*', 'users.nombre')
            ->where('seguimiento_solicitudes.uuid', '=', $uuid)
            ->get();

        return  $users;
    }

    public function indexEspecifico($id)
    {
        $get_all = SolicitudTickets::select('solicitud_tickets.*',DB::raw("CONCAT(DATE_FORMAT(solicitud_tickets.created_at, '%d%m%Y'),'-',solicitud_tickets.id,'-',solicitud_tickets.id_user) as nticket"))
            ->where('solicitud_tickets.id', '=', $id)
            ->get();

        log::info($get_all);    
        return  $get_all;
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
    
                $listContactos = [];
                $i = 0;
    
                foreach ($userMail as $key) {
                    $listContactos[$i] = $key->email;
                    $i++;
                }
    
               $nombre = $request->nombre;
               $descripcionP = $request->descripcionCorreo;
               $id_solicitud = $response->id;
               $titulo = $request->tituloP;
                Mail::send('/Mails/TicketGenerado', ['nombre' => $nombre, 'id' => $id_solicitud, 'descripcionTicket' => $descripcionP, 'titulo' => $titulo], function ($message) use($listContactos) {
                  $message->setTo($listContactos)->setSubject('Nuevo Ticket Generado');
                  $message->setFrom('mantencion.hsjd@redsalud.gov.cl', 'Mantencion');
                  $message->setBcc(['ricardo.soto.g@redsalud.gov.cl'=> 'Ricardo Soto Gomez']);
                 
                });
                return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
        
        
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $estadoEliminado = 7;
        $ticket = SolicitudTickets::find($id);
        $ticket->id_estado = $estadoEliminado;
        $ticket->save();

        return true;
    }
}
