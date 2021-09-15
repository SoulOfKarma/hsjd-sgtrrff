<?php

namespace App\Http\Controllers;

use App\seguimientoEMSolicitudes;
use App\SolicitudTicketsEM;
use App\Users;
use App\Mail\TicketGenerado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use DB;
use Illuminate\Support\Facades\Log;

class SeguimientoEMSolicitudesController extends Controller
{
    public function store(Request $request, $uuid)
    {
        seguimientoEMSolicitudes::create($request->all());
        $descripcionSeguimiento = $request->descripcionCorreo;
        $id_solicitud = $request->id;
        $nombre = $request->nombre;
        $id_user = $request->id_user;
        $id_usuarioEspecifico = $request->id_usuarioEspecifico;

        $userSearch = Users::where('id',$id_usuarioEspecifico)->first();
            $ValidarCargo = $userSearch->id_cargo_asociado;     
            $userMail = [];

            if($ValidarCargo == null || $ValidarCargo == 0){
                $userMail = Users::select('email')
                ->Where('id',$id_usuarioEspecifico)
                ->orWhere('id_cargo_asociado',$id_usuarioEspecifico)
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


        Mail::send('/Mails/TicketGeneradoUsuario', ['nombre' => $nombre, 'id_solicitud' => $id_solicitud, 'descripcionSeguimiento' => $descripcionSeguimiento], function ($message) use($listContactos) {
            $message->setTo($listContactos)->setSubject('Seguimiento de ticket');
            $message->setFrom('mantencion.hsjd@redsalud.gov.cl', 'Mantencion');
            $message->setBcc(['ricardo.soto.g@redsalud.gov.cl'=> 'Ricardo Soto Gomez']);
        });
    }

    public function seguimientoExternoBodega(Request $request)
    {
        try {
            seguimientoEMSolicitudes::create($request->all());
            return true;
        } catch (\Throwable $th) {
            return false;
        }
        
    }

    public function seguimientoTrabajador(Request $request, $uuid)
    {
        seguimientoEMSolicitudes::create($request->all());
        $descripcionSeguimiento = $request->descripcionCorreo;
        $id_solicitud = $request->id;
        $nombre = $request->nombre;
        $id_user = $request->id_user;
        $id_usuarioEspecifico = $request->id_usuarioEspecifico;

        $userSearch = Users::where('id',$id_user)->first();
            $ValidarCargo = $userSearch->id_cargo_asociado;     
            $userMail = [];

            if($ValidarCargo == null || $ValidarCargo == 0){
                $userMail = Users::select('email')
                ->Where('id',$id_usuarioEspecifico)
                ->orWhere('id_cargo_asociado',$id_usuarioEspecifico)
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


        Mail::send('/Mails/TicketGeneradoUsuario', ['nombre' => $nombre, 'id_solicitud' => $id_solicitud, 'descripcionSeguimiento' => $descripcionSeguimiento], function ($message) use($listContactos) {
            $message->setTo($listContactos)->setSubject('Seguimiento de ticket');
            $message->setFrom('mantencion.hsjd@redsalud.gov.cl', 'Mantencion');
            $message->setBcc(['ricardo.soto.g@redsalud.gov.cl'=> 'Ricardo Soto Gomez']);
        });
    }

    public function guardarSeguimientoT(Request $request, $uuid)
    {
        try {
            //Creando Seguimiento Final y Cambiando estado a Resuelto
            seguimientoEMSolicitudes::create($request->all());
            $descripcionSeguimiento = $request->descripcionCorreo;
            $id_solicitud = $request->id_solicitud;
            $nombre = $request->nombre;
            $id_user = $request->id_user;

            $idEstado = 5;

            SolicitudTicketsEM::where('id',$id_solicitud)
            ->where('uuid',$uuid)
            ->update(['id_estado'=> $idEstado,]);

            //Envio de correo
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


            SolicitudTicketsEM::where('id', $id_solicitud)
            ->where('uuid', $uuid)
            ->update(['id_estado' => 5]);

            Mail::send('/Mails/TicketResuelto', ['nombre' => $nombre, 'id_solicitud' => $id_solicitud, 'descripcionSeguimiento' => $descripcionSeguimiento], function ($message) use($listContactos) {
            $message->setTo($listContactos)->setSubject('Seguimiento de ticket');
            $message->setFrom('mantencion.hsjd@redsalud.gov.cl', 'Mantencion');
            $message->setBcc(['ricardo.soto.g@redsalud.gov.cl'=> 'Ricardo Soto Gomez']);
            });

            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
       
    }

    public function indexSeguimiento($uuid)
    {
        $users = seguimientoEMSolicitudes::select('seguimiento_e_m_solicitudes.*', 'users.nombre', 'users.apellido')
            ->join('users', 'seguimiento_e_m_solicitudes.id_user', '=', 'users.id')
            ->where('seguimiento_e_m_solicitudes.uuid', '=', $uuid)
            ->orderBy('seguimiento_e_m_solicitudes.id', 'desc')
            ->get();

        return  $users;
    }

    public function indexEspecifico($id)
    {

        $users = DB::table('solicitud_tickets_e_m_s')
            ->join('users', 'solicitud_tickets_e_m_s.id_user', '=', 'users.id')
            ->join('edificios', 'solicitud_tickets_e_m_s.id_edificio', '=', 'edificios.id')
            ->join('servicios', 'solicitud_tickets_e_m_s.id_servicio', '=', 'servicios.id')
            ->join('unidad_esps', 'solicitud_tickets_e_m_s.id_ubicacionEx', '=', 'unidad_esps.id')
            ->select('solicitud_tickets_e_m_s.*', 'users.nombre','users.apellido', 'edificios.descripcionEdificio', 'servicios.descripcionServicio', 'unidad_esps.descripcionUnidadEsp',DB::raw("CONCAT(DATE_FORMAT(solicitud_tickets_e_m_s.created_at, '%d%m%Y'),'-',solicitud_tickets_e_m_s.id,'-',solicitud_tickets_e_m_s.id_user) as nticket"))
            ->where('solicitud_tickets_e_m_s.uuid', '=', $id)
            ->get();

        return  $users;
    }
}
