<?php

namespace App\Http\Controllers;

use App\SeguimientoSolicitudes;
use App\Mail\AutoRespuesta;
use App\SolicitudTickets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use DB;
use Illuminate\Support\Facades\Log;


class SeguimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request, $uuid)
    {
        SeguimientoSolicitudes::create($request->all());
        $descripcionSeguimiento = $request->descripcionCorreo;
        $id_solicitud = $request->id;
        $nombre = $request->nombre;

        Mail::send('/Mails/TicketGeneradoUsuario', ['nombre' => $nombre, 'id_solicitud' => $id_solicitud, 'descripcionSeguimiento' => $descripcionSeguimiento], function ($message) {
            $message->to('knightwalker.zero5@gmail.com', 'Ricardo Soto Gomez')->subject('Actualizacion de ticket');
            $message->from('knightwalker.zero5@gmail.com', 'Ricardo Soto Gomez');
        });
    }

    public function guardarSeguimientoT(Request $request, $uuid)
    {
        SeguimientoSolicitudes::create($request->all());
        $descripcionSeguimiento = $request->descripcionCorreo;
        $id_solicitud = $request->id;
        $nombre = $request->nombre;

        SolicitudTickets::where('id', $id_solicitud)
            ->where('uuid', $uuid)
            ->update(['id_estado' => 5]);

        Mail::send('/Mails/TicketResuelto', ['nombre' => $nombre, 'id_solicitud' => $id_solicitud, 'descripcionSeguimiento' => $descripcionSeguimiento], function ($message) {
            $message->to('knightwalker.zero5@gmail.com', 'Ricardo Soto Gomez')->subject('Actualizacion de ticket');
            $message->from('knightwalker.zero5@gmail.com', 'Ricardo Soto Gomez');
        });
    }

    public function indexSeguimiento($uuid)
    {
        $users = SeguimientoSolicitudes::select('seguimiento_solicitudes')
            ->join('users', 'seguimiento_solicitudes.id_user', '=', 'users.id')
            ->select('seguimiento_solicitudes.*', 'users.nombre', 'users.apellido')
            ->where('seguimiento_solicitudes.uuid', '=', $uuid)
            ->orderBy('seguimiento_solicitudes.id', 'desc')
            ->get();

        return  $users;
    }

    public function indexEspecifico($id)
    {

        $users = DB::table('solicitud_tickets')
            ->join('users', 'solicitud_tickets.id_user', '=', 'users.id')
            ->join('edificios', 'solicitud_tickets.id_edificio', '=', 'edificios.id')
            ->join('servicios', 'solicitud_tickets.id_servicio', '=', 'servicios.id')
            ->join('unidad_esps', 'solicitud_tickets.id_ubicacionEx', '=', 'unidad_esps.id')
            ->select('solicitud_tickets.*', 'users.nombre','users.apellido', 'edificios.descripcionEdificio', 'servicios.descripcionServicio', 'unidad_esps.descripcionUnidadEsp')
            ->where('solicitud_tickets.uuid', '=', $id)
            ->get();

        return  $users;
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
        //
    }
}
