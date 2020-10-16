<?php

namespace App\Http\Controllers;

use App\Mail\TicketGenerado;
use App\SolicitudTickets;
use App\Users;
use App\SeguimientoSolicitudes;
use Uuid;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

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

    public function GetSolicitudCreada($id)
    {
        $get_all = SolicitudTickets::find($id);
        return  $get_all;
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

        $ticket = SolicitudTickets::select('solicitud_tickets.*', DB::raw("DATE_FORMAT(solicitud_tickets.created_at, '%d/%m/%Y') as fechaCreacion"), DB::raw("DATE_FORMAT(gestion_solicitudes.fechaInicio, '%d/%m/%Y') as fechaAsignacion"), 'gestion_solicitudes.*', 'supervisores.sup_nombre_apellido', 'trabajadores.tra_nombre_apellido', 'users.nombre', 'estado_solicituds.descripcionEstado', DB::raw("CONCAT(DATE_FORMAT(solicitud_tickets.created_at, '%d%m%Y'),'-',solicitud_tickets.id,'-',solicitud_tickets.id_user) as nticket"))
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


        return $response2;
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

        $get_all = SolicitudTickets::find($id);
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
        $uuid = Uuid::generate()->string;
        $response = SolicitudTickets::create(array_merge($request->all(), ['uuid' => $uuid]));
        SeguimientoSolicitudes::create(array_merge($request->all(), ['uuid' => $uuid, 'id_solicitud' => $response->id, 'descripcionSeguimiento' => 'Ticket creado']));



        $nombre = $request->nombre;
        $descripcionP = $request->descripcionCorreo;
        $id_solicitud = $response->id;
        $titulo = $request->tituloP;
        //log::info($descripcionP);
        $receivers = 'gomez.soto.ricardo@gmail.com';
        Mail::send('/Mails/TicketGenerado', ['nombre' => $nombre, 'id' => $id_solicitud, 'descripcionTicket' => $descripcionP, 'titulo' => $titulo], function ($message) {
            $message->to('gomez.soto.ricardo@gmail.com', 'Ricardo Soto Gomez')->subject('Nuevo Ticket Generado');
            $message->from('knightwalker.zero5@gmail.com', 'Ricardo Soto Gomez');
        });

        return true;
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
