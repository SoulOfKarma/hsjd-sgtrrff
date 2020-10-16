<?php

namespace App\Http\Controllers;

use App\GestionSolicitudes;
use App\Trabajadores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\App;
use DB;
use Svg\Tag\Rect;
use Spatie\Browsershot\Browsershot;

class PdfController extends Controller
{
    public function imprimir()
    {
        $data = GestionSolicitudes::select(
            'gestion_solicitudes.*',
            'edificios.descripcionEdificio',
            'servicios.descripcionServicio',
            'users.nombre',
            'unidad_esps.descripcionUnidadEsp',
            'estado_solicituds.descripcionEstado',
            'tipo_reparacions.descripcionTipoReparacion',
            DB::raw("CONCAT(trabajadores.tra_nombre,' ',trabajadores.tra_apellido) as tra_nombre_apellido"),
            DB::raw("CONCAT(supervisores.sup_nombre,' ',supervisores.sup_apellido) as sup_nombre_apellido"),
            DB::raw("CONCAT(DATE_FORMAT(solicitud_tickets.created_at, '%d%m%Y'),'-',solicitud_tickets.id,'-',solicitud_tickets.id_user) as nticket"),
            DB::raw("DATE_FORMAT(solicitud_tickets.created_at, '%d/%m/%Y') as nfechaS"),
            DB::raw("DATE_FORMAT(gestion_solicitudes.fechaInicio, '%d/%m/%Y') as nfechaI"),
            DB::raw("fnStripTags(solicitud_tickets.descripcionP) as desFormat")

        )
            ->join('trabajadores', 'gestion_solicitudes.id_trabajador', '=', 'trabajadores.id')
            ->join('supervisores', 'gestion_solicitudes.id_supervisor', '=', 'supervisores.id')
            ->join('solicitud_tickets', 'gestion_solicitudes.id_solicitud', '=', 'solicitud_tickets.id')
            ->join('edificios', 'solicitud_tickets.id_edificio', '=', 'edificios.id')
            ->join('servicios', 'solicitud_tickets.id_servicio', '=', 'servicios.id')
            ->join('unidad_esps', 'solicitud_tickets.id_ubicacionEx', '=', 'unidad_esps.id')
            ->join('estado_solicituds', 'solicitud_tickets.id_estado', '=', 'estado_solicituds.id')
            ->join('tipo_reparacions', 'solicitud_tickets.id_tipoReparacion', '=', 'tipo_reparacions.id')
            ->join('users', 'solicitud_tickets.id_user', '=', 'users.id')
            ->where('gestion_solicitudes.id_solicitud', 1)
            ->first();

        $idApoyo1 = $data->idApoyo1;
        $idApoyo2 = $data->idApoyo2;
        $idApoyo3 = $data->idApoyo3;

        $apoyo1 = Trabajadores::firstWhere('id', $idApoyo1);
        $apoyo2 = Trabajadores::firstWhere('id', $idApoyo2);
        $apoyo3 = Trabajadores::firstWhere('id', $idApoyo3);

        $nom1 = $apoyo1->tra_nombre;
        $ape1 = $apoyo1->tra_apellido;

        $nom2 = $apoyo2->tra_nombre;
        $ape2 = $apoyo2->tra_apellido;

        $nom3 = $apoyo3->tra_nombre;
        $ape3 = $apoyo3->tra_apellido;

        $idSol = $data->nticket;
        $nombreTra = $data->tra_nombre_apellido;
        $nombreSup = $data->sup_nombre_apellido;
        $desEdificio = $data->descripcionEdificio;
        $desServicio = $data->descripcionServicio;
        $desUnidadEsp = $data->descripcionUnidadEsp;
        $desEstado = $data->descripcionEstado;
        $desTipoRep = $data->descripcionTipoReparacion;
        $fechaS = $data->nfechaS;
        $fechaI = $data->nfechaI;
        $horasEjecucion = $data->horasEjecucion;
        $diasEjecucion = $data->diasEjecucion;
        $nomApoyo1 = $nom1 + $ape1;
        $nomApoyo2 = $nom2 + $ape2;
        $nomApoyo3 = $nom3 + $ape3;
        $descripcionPro = $data->desFormat;
        $nombreUsuario = $data->nombre;



        $data = [
            'nombreTra' =>  $nombreTra,
            'idSolicitud' => $idSol,
            'nombreSup' => $nombreSup,
            'desEdificio' => $desEdificio,
            'desServicio' => $desServicio,
            'desUnidadEsp' => $desUnidadEsp,
            'desEstado' => $desEstado,
            'desTipoRep' => $desTipoRep,
            'fechaS' => $fechaS,
            'fechaI' => $fechaI,
            'horasEjecucion' => $horasEjecucion,
            'diasEjecucion' => $diasEjecucion,
            'nomApoyo1' => $nomApoyo1,
            'nomApoyo2' => $nomApoyo2,
            'nomApoyo3' => $nomApoyo3,
            'descripcionPro' => $descripcionPro,
            'nombreUsuario' => $nombreUsuario
        ];

        $pdf = App::make("dompdf.wrapper");
        $pdf->loadView('TicketEM', $data);
        $pdf->setOptions(['isJavascriptEnabled' => true]);
        $pdf->setOptions(['isRemoteEnabled' => true]);

        return $pdf->stream("TicketEM.pdf", array("Attachment" => 0));
    }

    public function imprimirPorTicketINFRA($id)
    {
        $data = GestionSolicitudes::select(
            'gestion_solicitudes.*',
            'edificios.descripcionEdificio',
            'servicios.descripcionServicio',
            'unidad_esps.descripcionUnidadEsp',
            'estado_solicituds.descripcionEstado',
            'tipo_reparacions.descripcionTipoReparacion',
            'turnos.descripcionTurno',
            DB::raw("CONCAT(users.nombre,' ',users.apellido) as nombre"),
            DB::raw("CONCAT(trabajadores.tra_nombre,' ',trabajadores.tra_apellido) as tra_nombre_apellido"),
            DB::raw("CONCAT(supervisores.sup_nombre,' ',supervisores.sup_apellido) as sup_nombre_apellido"),
            DB::raw("CONCAT(DATE_FORMAT(solicitud_tickets.created_at, '%d%m%Y'),'-',solicitud_tickets.id,'-',solicitud_tickets.id_user) as nticket"),
            DB::raw("DATE_FORMAT(solicitud_tickets.created_at, '%d/%m/%Y') as nfechaS"),
            DB::raw("DATE_FORMAT(gestion_solicitudes.fechaInicio, '%d/%m/%Y') as nfechaI"),
            DB::raw("fnStripTags(solicitud_tickets.descripcionP) as desFormat")

        )
            ->join('trabajadores', 'gestion_solicitudes.id_trabajador', '=', 'trabajadores.id')
            ->join('supervisores', 'gestion_solicitudes.id_supervisor', '=', 'supervisores.id')
            ->join('solicitud_tickets', 'gestion_solicitudes.id_solicitud', '=', 'solicitud_tickets.id')
            ->join('edificios', 'solicitud_tickets.id_edificio', '=', 'edificios.id')
            ->join('servicios', 'solicitud_tickets.id_servicio', '=', 'servicios.id')
            ->join('unidad_esps', 'solicitud_tickets.id_ubicacionEx', '=', 'unidad_esps.id')
            ->join('estado_solicituds', 'solicitud_tickets.id_estado', '=', 'estado_solicituds.id')
            ->join('tipo_reparacions', 'solicitud_tickets.id_tipoReparacion', '=', 'tipo_reparacions.id')
            ->join('turnos', 'gestion_solicitudes.idTurno', '=', 'turnos.id')
            ->join('users', 'solicitud_tickets.id_user', '=', 'users.id')
            ->where('gestion_solicitudes.id_solicitud', $id)
            ->first();

        $idApoyo1 = $data->idApoyo1;
        $idApoyo2 = $data->idApoyo2;
        $idApoyo3 = $data->idApoyo3;

        $apoyo1 = Trabajadores::firstWhere('id', $idApoyo1);
        $apoyo2 = Trabajadores::firstWhere('id', $idApoyo2);
        $apoyo3 = Trabajadores::firstWhere('id', $idApoyo3);


        $nom1 = $apoyo1->tra_nombre;
        $ape1 = $apoyo1->tra_apellido;

        $nom2 = $apoyo2->tra_nombre;
        $ape2 = $apoyo2->tra_apellido;

        $nom3 = $apoyo3->tra_nombre;
        $ape3 = $apoyo3->tra_apellido;

        $idSol = $data->nticket;
        $nombreTra = $data->tra_nombre_apellido;
        $nombreSup = $data->sup_nombre_apellido;
        $desEdificio = $data->descripcionEdificio;
        $desServicio = $data->descripcionServicio;
        $desUnidadEsp = $data->descripcionUnidadEsp;
        $desEstado = $data->descripcionEstado;
        $desTipoRep = $data->descripcionTipoReparacion;
        $fechaS = $data->nfechaS;
        $fechaI = $data->nfechaI;
        $horasEjecucion = $data->horasEjecucion;
        $diasEjecucion = $data->diasEjecucion;
        $descripcionPro = $data->desFormat;
        $nombreUsuario = $data->nombre;
        $turno = $data->descripcionTurno;


        $data = [
            'nombreTra' =>  $nombreTra,
            'idSolicitud' => $idSol,
            'nombreSup' => $nombreSup,
            'desEdificio' => $desEdificio,
            'desServicio' => $desServicio,
            'desUnidadEsp' => $desUnidadEsp,
            'desEstado' => $desEstado,
            'desTipoRep' => $desTipoRep,
            'fechaS' => $fechaS,
            'fechaI' => $fechaI,
            'horasEjecucion' => $horasEjecucion,
            'diasEjecucion' => $diasEjecucion,
            'nomApoyo1' => $nom1,
            'apeApoyo1' => $ape1,
            'nomApoyo2' => $nom2,
            'apeApoyo2' => $ape2,
            'nomApoyo3' => $nom3,
            'apeApoyo3' => $ape3,
            'descripcionPro' => $descripcionPro,
            'nombreUsuario' => $nombreUsuario,
            'descripcionTurno' =>$turno
        ];

        $pdf = App::make("dompdf.wrapper");
        $pdf->loadView('TicketInfra', $data);
        $pdf->setOptions(['isJavascriptEnabled' => true]);
        $pdf->setOptions(['isRemoteEnabled' => true]);

        return $pdf->stream("TicketInfra.pdf", array("Attachment" => 0));
    }

    public function imprimirPorTicketEM($id)
    {
        $data = GestionSolicitudes::select(
            'gestion_solicitudes.*',
            'edificios.descripcionEdificio',
            'servicios.descripcionServicio',
            'unidad_esps.descripcionUnidadEsp',
            'estado_solicituds.descripcionEstado',
            'tipo_reparacions.descripcionTipoReparacion',
            DB::raw("CONCAT(users.nombre,' ',users.apellido) as nombre"),
            DB::raw("CONCAT(trabajadores.tra_nombre,' ',trabajadores.tra_apellido) as tra_nombre_apellido"),
            DB::raw("CONCAT(supervisores.sup_nombre,' ',supervisores.sup_apellido) as sup_nombre_apellido"),
            DB::raw("CONCAT(DATE_FORMAT(solicitud_tickets.created_at, '%d%m%Y'),'-',solicitud_tickets.id,'-',solicitud_tickets.id_user) as nticket"),
            DB::raw("DATE_FORMAT(solicitud_tickets.created_at, '%d/%m/%Y') as nfechaS"),
            DB::raw("DATE_FORMAT(gestion_solicitudes.fechaInicio, '%d/%m/%Y') as nfechaI"),
            DB::raw("fnStripTags(solicitud_tickets.descripcionP) as desFormat")

        )
            ->join('trabajadores', 'gestion_solicitudes.id_trabajador', '=', 'trabajadores.id')
            ->join('supervisores', 'gestion_solicitudes.id_supervisor', '=', 'supervisores.id')
            ->join('solicitud_tickets', 'gestion_solicitudes.id_solicitud', '=', 'solicitud_tickets.id')
            ->join('edificios', 'solicitud_tickets.id_edificio', '=', 'edificios.id')
            ->join('servicios', 'solicitud_tickets.id_servicio', '=', 'servicios.id')
            ->join('unidad_esps', 'solicitud_tickets.id_ubicacionEx', '=', 'unidad_esps.id')
            ->join('estado_solicituds', 'solicitud_tickets.id_estado', '=', 'estado_solicituds.id')
            ->join('tipo_reparacions', 'solicitud_tickets.id_tipoReparacion', '=', 'tipo_reparacions.id')
            ->join('users', 'solicitud_tickets.id_user', '=', 'users.id')
            ->where('gestion_solicitudes.id_solicitud', $id)
            ->first();

        $idApoyo1 = $data->idApoyo1;
        $idApoyo2 = $data->idApoyo2;
        $idApoyo3 = $data->idApoyo3;

        $apoyo1 = Trabajadores::firstWhere('id', $idApoyo1);
        $apoyo2 = Trabajadores::firstWhere('id', $idApoyo2);
        $apoyo3 = Trabajadores::firstWhere('id', $idApoyo3);



        $nom1 = $apoyo1->tra_nombre;
        $ape1 = $apoyo1->tra_apellido;

        $nom2 = $apoyo2->tra_nombre;
        $ape2 = $apoyo2->tra_apellido;

        $nom3 = $apoyo3->tra_nombre;
        $ape3 = $apoyo3->tra_apellido;

        $idSol = $data->nticket;
        $nombreTra = $data->tra_nombre_apellido;
        $nombreSup = $data->sup_nombre_apellido;
        $desEdificio = $data->descripcionEdificio;
        $desServicio = $data->descripcionServicio;
        $desUnidadEsp = $data->descripcionUnidadEsp;
        $desEstado = $data->descripcionEstado;
        $desTipoRep = $data->descripcionTipoReparacion;
        $fechaS = $data->nfechaS;
        $fechaI = $data->nfechaI;
        $horasEjecucion = $data->horasEjecucion;
        $diasEjecucion = $data->diasEjecucion;
        $descripcionPro = $data->desFormat;
        $nombreUsuario = $data->nombre;
        $turno = $data->descripcionTurno;


        $data = [
            'nombreTra' =>  $nombreTra,
            'idSolicitud' => $idSol,
            'nombreSup' => $nombreSup,
            'desEdificio' => $desEdificio,
            'desServicio' => $desServicio,
            'desUnidadEsp' => $desUnidadEsp,
            'desEstado' => $desEstado,
            'desTipoRep' => $desTipoRep,
            'fechaS' => $fechaS,
            'fechaI' => $fechaI,
            'horasEjecucion' => $horasEjecucion,
            'diasEjecucion' => $diasEjecucion,
            'nomApoyo1' => $nom1,
            'apeApoyo1' => $ape1,
            'nomApoyo2' => $nom2,
            'apeApoyo2' => $ape2,
            'nomApoyo3' => $nom3,
            'apeApoyo3' => $ape3,
            'descripcionPro' => $descripcionPro,
            'nombreUsuario' => $nombreUsuario,
            'descripcionTurno' =>$turno
        ];

        $pdf = App::make("dompdf.wrapper");
        $pdf->loadView('TicketEM', $data);
        $pdf->setOptions(['isJavascriptEnabled' => true]);
        $pdf->setOptions(['isRemoteEnabled' => true]);

        return $pdf->stream("TicketEM.pdf", array("Attachment" => 0));
    }

    public function imprimirPorTicketIND($id)
    {
        $data = GestionSolicitudes::select(
            'gestion_solicitudes.*',
            'edificios.descripcionEdificio',
            'servicios.descripcionServicio',
            'unidad_esps.descripcionUnidadEsp',
            'estado_solicituds.descripcionEstado',
            'tipo_reparacions.descripcionTipoReparacion',
            DB::raw("CONCAT(users.nombre,' ',users.apellido) as nombre"),
            DB::raw("CONCAT(trabajadores.tra_nombre,' ',trabajadores.tra_apellido) as tra_nombre_apellido"),
            DB::raw("CONCAT(supervisores.sup_nombre,' ',supervisores.sup_apellido) as sup_nombre_apellido"),
            DB::raw("CONCAT(DATE_FORMAT(solicitud_tickets.created_at, '%d%m%Y'),'-',solicitud_tickets.id,'-',solicitud_tickets.id_user) as nticket"),
            DB::raw("DATE_FORMAT(solicitud_tickets.created_at, '%d/%m/%Y') as nfechaS"),
            DB::raw("DATE_FORMAT(gestion_solicitudes.fechaInicio, '%d/%m/%Y') as nfechaI"),
            DB::raw("fnStripTags(solicitud_tickets.descripcionP) as desFormat")

        )
            ->join('trabajadores', 'gestion_solicitudes.id_trabajador', '=', 'trabajadores.id')
            ->join('supervisores', 'gestion_solicitudes.id_supervisor', '=', 'supervisores.id')
            ->join('solicitud_tickets', 'gestion_solicitudes.id_solicitud', '=', 'solicitud_tickets.id')
            ->join('edificios', 'solicitud_tickets.id_edificio', '=', 'edificios.id')
            ->join('servicios', 'solicitud_tickets.id_servicio', '=', 'servicios.id')
            ->join('unidad_esps', 'solicitud_tickets.id_ubicacionEx', '=', 'unidad_esps.id')
            ->join('estado_solicituds', 'solicitud_tickets.id_estado', '=', 'estado_solicituds.id')
            ->join('tipo_reparacions', 'solicitud_tickets.id_tipoReparacion', '=', 'tipo_reparacions.id')
            ->join('users', 'solicitud_tickets.id_user', '=', 'users.id')
            ->where('gestion_solicitudes.id_solicitud', $id)
            ->first();

        $idApoyo1 = $data->idApoyo1;
        $idApoyo2 = $data->idApoyo2;
        $idApoyo3 = $data->idApoyo3;

        $apoyo1 = Trabajadores::firstWhere('id', $idApoyo1);
        $apoyo2 = Trabajadores::firstWhere('id', $idApoyo2);
        $apoyo3 = Trabajadores::firstWhere('id', $idApoyo3);



        $nom1 = $apoyo1->tra_nombre;
        $ape1 = $apoyo1->tra_apellido;

        $nom2 = $apoyo2->tra_nombre;
        $ape2 = $apoyo2->tra_apellido;

        $nom3 = $apoyo3->tra_nombre;
        $ape3 = $apoyo3->tra_apellido;

        $idSol = $data->nticket;
        $nombreTra = $data->tra_nombre_apellido;
        $nombreSup = $data->sup_nombre_apellido;
        $desEdificio = $data->descripcionEdificio;
        $desServicio = $data->descripcionServicio;
        $desUnidadEsp = $data->descripcionUnidadEsp;
        $desEstado = $data->descripcionEstado;
        $desTipoRep = $data->descripcionTipoReparacion;
        $fechaS = $data->nfechaS;
        $fechaI = $data->nfechaI;
        $horasEjecucion = $data->horasEjecucion;
        $diasEjecucion = $data->diasEjecucion;
        $descripcionPro = $data->desFormat;
        $nombreUsuario = $data->nombre;
        $turno = $data->descripcionTurno;


        $data = [
            'nombreTra' =>  $nombreTra,
            'idSolicitud' => $idSol,
            'nombreSup' => $nombreSup,
            'desEdificio' => $desEdificio,
            'desServicio' => $desServicio,
            'desUnidadEsp' => $desUnidadEsp,
            'desEstado' => $desEstado,
            'desTipoRep' => $desTipoRep,
            'fechaS' => $fechaS,
            'fechaI' => $fechaI,
            'horasEjecucion' => $horasEjecucion,
            'diasEjecucion' => $diasEjecucion,
            'nomApoyo1' => $nom1,
            'apeApoyo1' => $ape1,
            'nomApoyo2' => $nom2,
            'apeApoyo2' => $ape2,
            'nomApoyo3' => $nom3,
            'apeApoyo3' => $ape3,
            'descripcionPro' => $descripcionPro,
            'nombreUsuario' => $nombreUsuario,
            'descripcionTurno' =>$turno
        ];

        $pdf = App::make("dompdf.wrapper");
        $pdf->loadView('TicketIND', $data);
        $pdf->setOptions(['isJavascriptEnabled' => true]);
        $pdf->setOptions(['isRemoteEnabled' => true]);

        return $pdf->stream("TicketIND.pdf", array("Attachment" => 0));
    }

    public function imprimirPorTicketCA($id)
    {
        $data = GestionSolicitudes::select(
            'gestion_solicitudes.*',
            'edificios.descripcionEdificio',
            'servicios.descripcionServicio',
            'unidad_esps.descripcionUnidadEsp',
            'estado_solicituds.descripcionEstado',
            'tipo_reparacions.descripcionTipoReparacion',
            DB::raw("CONCAT(users.nombre,' ',users.apellido) as nombre"),
            DB::raw("CONCAT(trabajadores.tra_nombre,' ',trabajadores.tra_apellido) as tra_nombre_apellido"),
            DB::raw("CONCAT(supervisores.sup_nombre,' ',supervisores.sup_apellido) as sup_nombre_apellido"),
            DB::raw("CONCAT(DATE_FORMAT(solicitud_tickets.created_at, '%d%m%Y'),'-',solicitud_tickets.id,'-',solicitud_tickets.id_user) as nticket"),
            DB::raw("DATE_FORMAT(solicitud_tickets.created_at, '%d/%m/%Y') as nfechaS"),
            DB::raw("DATE_FORMAT(gestion_solicitudes.fechaInicio, '%d/%m/%Y') as nfechaI"),
            DB::raw("fnStripTags(solicitud_tickets.descripcionP) as desFormat")

        )
            ->join('trabajadores', 'gestion_solicitudes.id_trabajador', '=', 'trabajadores.id')
            ->join('supervisores', 'gestion_solicitudes.id_supervisor', '=', 'supervisores.id')
            ->join('solicitud_tickets', 'gestion_solicitudes.id_solicitud', '=', 'solicitud_tickets.id')
            ->join('edificios', 'solicitud_tickets.id_edificio', '=', 'edificios.id')
            ->join('servicios', 'solicitud_tickets.id_servicio', '=', 'servicios.id')
            ->join('unidad_esps', 'solicitud_tickets.id_ubicacionEx', '=', 'unidad_esps.id')
            ->join('estado_solicituds', 'solicitud_tickets.id_estado', '=', 'estado_solicituds.id')
            ->join('tipo_reparacions', 'solicitud_tickets.id_tipoReparacion', '=', 'tipo_reparacions.id')
            ->join('users', 'solicitud_tickets.id_user', '=', 'users.id')
            ->where('gestion_solicitudes.id_solicitud', $id)
            ->first();

        $idApoyo1 = $data->idApoyo1;
        $idApoyo2 = $data->idApoyo2;
        $idApoyo3 = $data->idApoyo3;

        $apoyo1 = Trabajadores::firstWhere('id', $idApoyo1);
        $apoyo2 = Trabajadores::firstWhere('id', $idApoyo2);
        $apoyo3 = Trabajadores::firstWhere('id', $idApoyo3);



        $nom1 = $apoyo1->tra_nombre;
        $ape1 = $apoyo1->tra_apellido;

        $nom2 = $apoyo2->tra_nombre;
        $ape2 = $apoyo2->tra_apellido;

        $nom3 = $apoyo3->tra_nombre;
        $ape3 = $apoyo3->tra_apellido;

        $idSol = $data->nticket;
        $nombreTra = $data->tra_nombre_apellido;
        $nombreSup = $data->sup_nombre_apellido;
        $desEdificio = $data->descripcionEdificio;
        $desServicio = $data->descripcionServicio;
        $desUnidadEsp = $data->descripcionUnidadEsp;
        $desEstado = $data->descripcionEstado;
        $desTipoRep = $data->descripcionTipoReparacion;
        $fechaS = $data->nfechaS;
        $fechaI = $data->nfechaI;
        $horasEjecucion = $data->horasEjecucion;
        $diasEjecucion = $data->diasEjecucion;
        $descripcionPro = $data->desFormat;
        $nombreUsuario = $data->nombre;
        $turno = $data->descripcionTurno;


        $data = [
            'nombreTra' =>  $nombreTra,
            'idSolicitud' => $idSol,
            'nombreSup' => $nombreSup,
            'desEdificio' => $desEdificio,
            'desServicio' => $desServicio,
            'desUnidadEsp' => $desUnidadEsp,
            'desEstado' => $desEstado,
            'desTipoRep' => $desTipoRep,
            'fechaS' => $fechaS,
            'fechaI' => $fechaI,
            'horasEjecucion' => $horasEjecucion,
            'diasEjecucion' => $diasEjecucion,
            'nomApoyo1' => $nom1,
            'apeApoyo1' => $ape1,
            'nomApoyo2' => $nom2,
            'apeApoyo2' => $ape2,
            'nomApoyo3' => $nom3,
            'apeApoyo3' => $ape3,
            'descripcionPro' => $descripcionPro,
            'nombreUsuario' => $nombreUsuario,
            'descripcionTurno' =>$turno
        ];

        $pdf = App::make("dompdf.wrapper");
        $pdf->loadView('TicketCA', $data);
        $pdf->setOptions(['isJavascriptEnabled' => true]);
        $pdf->setOptions(['isRemoteEnabled' => true]);

        return $pdf->stream("TicketCA.pdf", array("Attachment" => 0));
    }
}
