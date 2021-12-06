<?php

namespace App\Http\Controllers;

use App\GestionSolicitudes;
use App\GestionTicketEMS;
use App\GestionTicketsAps;
use App\GestionTicketsINDs;
use App\Entregacilindros;
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
            'duracion_solicitudes.descripcion_duracion',
            DB::raw("CONCAT(trabajadores.tra_nombre,' ',trabajadores.tra_apellido) as tra_nombre_apellido"),
            DB::raw("CONCAT(supervisores.sup_nombre,' ',supervisores.sup_apellido) as sup_nombre_apellido"),
            DB::raw("CONCAT(DATE_FORMAT(solicitud_tickets.id) as nticket"),
            DB::raw("DATE_FORMAT(solicitud_tickets.created_at, '%d/%m/%Y') as nfechaS"),
            DB::raw("IF (gestion_solicitudes.fechaCambiada IS NULL ,gestion_solicitudes.fechaInicio, gestion_solicitudes.fechaCambiada) as nfechaI"),
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
            ->join('duracion_solicitudes', 'gestion_solicitudes.idDuracion', '=', 'duracion_solicitudes.id')
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
        $duracionSolicitudes = $data->descripcion_duracion;



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
            'nombreUsuario' => $nombreUsuario,
            'duracionSolicitudes' => $duracionSolicitudes
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
            'users.anexo',
            'duracion_solicitudes.descripcion_duracion',
            DB::raw("CONCAT(users.nombre,' ',users.apellido) as nombre"),
            DB::raw("CONCAT(trabajadores.tra_nombre,' ',trabajadores.tra_apellido) as tra_nombre_apellido"),
            DB::raw("CONCAT(supervisores.sup_nombre,' ',supervisores.sup_apellido) as sup_nombre_apellido"),
            DB::raw("CONCAT(solicitud_tickets.id) as nticket"),
            DB::raw("DATE_FORMAT(solicitud_tickets.created_at, '%d/%m/%Y') as nfechaS"),
            DB::raw("IF (gestion_solicitudes.fechaCambiada IS NULL ,DATE_FORMAT(gestion_solicitudes.fechaInicio, '%d/%m/%Y'), DATE_FORMAT(gestion_solicitudes.fechaCambiada, '%d/%m/%Y')) as nfechaI"),
            //DB::raw("fnStripTags(solicitud_tickets.descripcionP) as desFormat")
            DB::raw("CONCAT(solicitud_tickets.descripcionP) as desFormat")

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
            ->join('duracion_solicitudes', 'gestion_solicitudes.idDuracion', '=', 'duracion_solicitudes.id')
            ->where('gestion_solicitudes.id_solicitud', $id)
            ->first();

        $idApoyo1 = $data->idApoyo1;
        $idApoyo2 = $data->idApoyo2;
        $idApoyo3 = $data->idApoyo3;

        $apoyo1 = Trabajadores::firstWhere('id', $idApoyo1);
        $apoyo2 = Trabajadores::firstWhere('id', $idApoyo2);
        $apoyo3 = Trabajadores::firstWhere('id', $idApoyo3);

        $nom1 = "";
        $ape1 = "";
        $nom2 = "";
        $ape2 = "";
        $nom3 = "";
        $ape3 = "";


        if($idApoyo1 == 1){
            $nom1 = "-";
            $ape1 = "-";
        }else{
            $nom1 = $apoyo1->tra_nombre;
                $ape1 = $apoyo1->tra_apellido;
        }

        if($idApoyo2 == 1){
            $nom2 = "-";
            $ape2 = "-";
        }else{
            $nom2 = $apoyo2->tra_nombre;
                $ape2 = $apoyo2->tra_apellido;
        }

        if($idApoyo3 == 1){
            $nom3 = "-";
            $ape3 = "-";
        }else{
            $nom3 = $apoyo3->tra_nombre;
            $ape3 = $apoyo3->tra_apellido;
        }

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
        $anexo = $data->anexo;
        $duracionSolicitudes = $data->descripcion_duracion;

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
            'descripcionTurno' =>$turno,
            'anexo' => $anexo,
            'duracionSolicitudes' => $duracionSolicitudes
        ];

        $pdf = App::make("dompdf.wrapper");
        $pdf->loadView('TicketInfra', $data);
        $pdf->setOptions(['isJavascriptEnabled' => true]);
        $pdf->setOptions(['isRemoteEnabled' => true]);

        return $pdf->stream("TicketInfra.pdf", array("Attachment" => 0));
    }

    public function imprimirPorTicketEM($id)
    {
        try {
            $data = GestionTicketEMS::select(
                'gestion_ticket_e_m_s.*',
                'edificios.descripcionEdificio',
                'servicios.descripcionServicio',
                'unidad_esps.descripcionUnidadEsp',
                'estado_solicituds.descripcionEstado',
                'tipo_reparacions.descripcionTipoReparacion',
                'turnos.descripcionTurno',
                'users.anexo',
                DB::raw("IF (users.email IS NULL ,CONCAT('PENDIENTE'), users.email) as email"),
                'duracion_solicitudes.descripcion_duracion',
                DB::raw("CONCAT(users.nombre,' ',users.apellido) as nombre"),
                DB::raw("CONCAT(trabajadores.tra_nombre,' ',trabajadores.tra_apellido) as tra_nombre_apellido"),
                DB::raw("CONCAT(supervisores.sup_nombre,' ',supervisores.sup_apellido) as sup_nombre_apellido"),
                DB::raw("CONCAT(solicitud_tickets_e_m_s.id) as nticket"),
                DB::raw("DATE_FORMAT(solicitud_tickets_e_m_s.created_at, '%d/%m/%Y') as nfechaS"),
                DB::raw("IF (gestion_ticket_e_m_s.fechaCambiada IS NULL ,DATE_FORMAT(gestion_ticket_e_m_s.fechaInicio, '%d/%m/%Y'), DATE_FORMAT(gestion_ticket_e_m_s.fechaCambiada, '%d/%m/%Y')) as nfechaI"),
                DB::raw("CONCAT(solicitud_tickets_e_m_s.descripcionP) as desFormat")
    
            )
                ->join('trabajadores', 'gestion_ticket_e_m_s.id_trabajador', '=', 'trabajadores.id')
                ->join('supervisores', 'gestion_ticket_e_m_s.id_supervisor', '=', 'supervisores.id')
                ->join('solicitud_tickets_e_m_s', 'gestion_ticket_e_m_s.id_solicitud', '=', 'solicitud_tickets_e_m_s.id')
                ->join('edificios', 'solicitud_tickets_e_m_s.id_edificio', '=', 'edificios.id')
                ->join('servicios', 'solicitud_tickets_e_m_s.id_servicio', '=', 'servicios.id')
                ->join('unidad_esps', 'solicitud_tickets_e_m_s.id_ubicacionEx', '=', 'unidad_esps.id')
                ->join('estado_solicituds', 'solicitud_tickets_e_m_s.id_estado', '=', 'estado_solicituds.id')
                ->join('tipo_reparacions', 'solicitud_tickets_e_m_s.id_tipoReparacion', '=', 'tipo_reparacions.id')
                ->join('users', 'solicitud_tickets_e_m_s.id_user', '=', 'users.id')
                ->join('turnos', 'gestion_ticket_e_m_s.idTurno', '=', 'turnos.id')
                ->join('duracion_solicitudes', 'gestion_ticket_e_m_s.idDuracion', '=', 'duracion_solicitudes.id')
                ->where('gestion_ticket_e_m_s.id_solicitud', $id)
                ->first();
    
            $equipomedico = GestionTicketEMS::select(DB::raw("IF (equipamiento_medicos.equipo IS NULL ,CONCAT('PENDIENTE'), equipamiento_medicos.equipo) as equipo"),
            DB::raw("IF (equipamiento_medicos.marca IS NULL ,CONCAT('PENDIENTE'), equipamiento_medicos.marca) as marca"),
            DB::raw("IF (equipamiento_medicos.modelo IS NULL ,CONCAT('PENDIENTE'), equipamiento_medicos.modelo) as modelo"),
            DB::raw("IF (equipamiento_medicos.serie IS NULL ,CONCAT('PENDIENTE'), equipamiento_medicos.serie) as serie"),
            DB::raw("IF (equipamiento_medicos.ninventario IS NULL ,CONCAT('PENDIENTE'), equipamiento_medicos.ninventario) as ninventario")) 
            ->join('tbl_ticket_equipamiento_medicos', 'gestion_ticket_e_m_s.id_solicitud', '=', 'tbl_ticket_equipamiento_medicos.id_solicitud')
            ->join('equipamiento_medicos', 'tbl_ticket_equipamiento_medicos.id_equipamiento_medico', '=', 'equipamiento_medicos.id')
            ->where('gestion_ticket_e_m_s.id_solicitud', $id)
            ->first();
    
            if($equipomedico == ""){
              $equipomedico = [
                  'equipo' => 'PENDIENTE',
                  'marca' => 'PENDIENTE',
                  'modelo' => 'PENDIENTE',
                  'serie' => 'PENDIENTE',
                  'ninventario' => 'PENDIENTE'
              ];
    
              $equipomedico = json_encode($equipomedico);
            }
    
            $listEquipoMedico = $equipomedico;  
    
            $idApoyo1 = $data->idApoyo1;
            $idApoyo2 = $data->idApoyo2;
            $idApoyo3 = $data->idApoyo3;
    
            $apoyo1 = Trabajadores::firstWhere('id', $idApoyo1);
            $apoyo2 = Trabajadores::firstWhere('id', $idApoyo2);
            $apoyo3 = Trabajadores::firstWhere('id', $idApoyo3);
    
    
    
            $nom1 = "";
            $ape1 = "";
            $nom2 = "";
            $ape2 = "";
            $nom3 = "";
            $ape3 = "";
    
    
            if($idApoyo1 == 1){
                $nom1 = "-";
                $ape1 = "-";
            }else{
                $nom1 = $apoyo1->tra_nombre;
                    $ape1 = $apoyo1->tra_apellido;
            }
    
            if($idApoyo2 == 1){
                $nom2 = "-";
                $ape2 = "-";
            }else{
                $nom2 = $apoyo2->tra_nombre;
                    $ape2 = $apoyo2->tra_apellido;
            }
    
            if($idApoyo3 == 1){
                $nom3 = "-";
                $ape3 = "-";
            }else{
                $nom3 = $apoyo3->tra_nombre;
                $ape3 = $apoyo3->tra_apellido;
            }
    
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
            $anexo = $data->anexo;
            $email = $data->email;
            $equipo = 'PENDIENTE';//$listEquipoMedico->equipo;
            $marca = $listEquipoMedico->marca;
            $modelo = $listEquipoMedico->modelo;
            $serie = $listEquipoMedico->serie;
            $ninventario = $listEquipoMedico->ninventario;
            $duracionSolicitudes = $data->descripcion_duracion;
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
                'descripcionTurno' =>$turno,
                'anexo' => $anexo,
                'duracionSolicitudes' => $duracionSolicitudes,
                'email' => $email,
                'equipo' => $equipo,
                'marca' => $marca,
                'modelo' => $modelo,
                'serie' => $serie,
                'ninventario' => $ninventario
                
            ];
    
            $pdf = App::make("dompdf.wrapper");
            $pdf->loadView('TicketEM', $data);
            $pdf->setOptions(['isJavascriptEnabled' => true]);
            $pdf->setOptions(['isRemoteEnabled' => true]);
    
            return $pdf->stream("TicketEM.pdf", array("Attachment" => 0));
        } catch (\Throwable $th) {
            log::info($th);
        }
        
    }

    public function imprimirPorTicketIND($id)
    {
        $data = GestionTicketsINDs::select(
            'gestion_tickets_i_n_ds.*',
            'edificios.descripcionEdificio',
            'servicios.descripcionServicio',
            'unidad_esps.descripcionUnidadEsp',
            'estado_solicituds.descripcionEstado',
            'tipo_reparacions.descripcionTipoReparacion',
            'turnos.descripcionTurno',
            'users.anexo',
            'duracion_solicitudes.descripcion_duracion',
            DB::raw("CONCAT(users.nombre,' ',users.apellido) as nombre"),
            DB::raw("CONCAT(trabajadores.tra_nombre,' ',trabajadores.tra_apellido) as tra_nombre_apellido"),
            DB::raw("CONCAT(supervisores.sup_nombre,' ',supervisores.sup_apellido) as sup_nombre_apellido"),
            DB::raw("CONCAT(solicitud_ticket_i_n_ds.id) as nticket"),
            DB::raw("DATE_FORMAT(solicitud_ticket_i_n_ds.created_at, '%d/%m/%Y') as nfechaS"),
            DB::raw("IF (gestion_tickets_i_n_ds.fechaCambiada IS NULL ,DATE_FORMAT(gestion_tickets_i_n_ds.fechaInicio, '%d/%m/%Y'), DATE_FORMAT(gestion_tickets_i_n_ds.fechaCambiada, '%d/%m/%Y')) as nfechaI"),
            DB::raw("CONCAT(solicitud_ticket_i_n_ds.descripcionP) as desFormat")

        )
            ->join('trabajadores', 'gestion_tickets_i_n_ds.id_trabajador', '=', 'trabajadores.id')
            ->join('supervisores', 'gestion_tickets_i_n_ds.id_supervisor', '=', 'supervisores.id')
            ->join('solicitud_ticket_i_n_ds', 'gestion_tickets_i_n_ds.id_solicitud', '=', 'solicitud_ticket_i_n_ds.id')
            ->join('edificios', 'solicitud_ticket_i_n_ds.id_edificio', '=', 'edificios.id')
            ->join('servicios', 'solicitud_ticket_i_n_ds.id_servicio', '=', 'servicios.id')
            ->join('unidad_esps', 'solicitud_ticket_i_n_ds.id_ubicacionEx', '=', 'unidad_esps.id')
            ->join('estado_solicituds', 'solicitud_ticket_i_n_ds.id_estado', '=', 'estado_solicituds.id')
            ->join('tipo_reparacions', 'solicitud_ticket_i_n_ds.id_tipoReparacion', '=', 'tipo_reparacions.id')
            ->join('users', 'solicitud_ticket_i_n_ds.id_user', '=', 'users.id')
            ->join('turnos', 'gestion_tickets_i_n_ds.idTurno', '=', 'turnos.id')
            ->join('duracion_solicitudes', 'gestion_tickets_i_n_ds.idDuracion', '=', 'duracion_solicitudes.id')
            ->where('gestion_tickets_i_n_ds.id_solicitud', $id)
            ->first();

        $idApoyo1 = $data->idApoyo1;
        $idApoyo2 = $data->idApoyo2;
        $idApoyo3 = $data->idApoyo3;

        $apoyo1 = Trabajadores::firstWhere('id', $idApoyo1);
        $apoyo2 = Trabajadores::firstWhere('id', $idApoyo2);
        $apoyo3 = Trabajadores::firstWhere('id', $idApoyo3);



        $nom1 = "";
        $ape1 = "";
        $nom2 = "";
        $ape2 = "";
        $nom3 = "";
        $ape3 = "";


        if($idApoyo1 == 1){
            $nom1 = "-";
            $ape1 = "-";
        }else{
            $nom1 = $apoyo1->tra_nombre;
                $ape1 = $apoyo1->tra_apellido;
        }

        if($idApoyo2 == 1){
            $nom2 = "-";
            $ape2 = "-";
        }else{
            $nom2 = $apoyo2->tra_nombre;
                $ape2 = $apoyo2->tra_apellido;
        }

        if($idApoyo3 == 1){
            $nom3 = "-";
            $ape3 = "-";
        }else{
            $nom3 = $apoyo3->tra_nombre;
            $ape3 = $apoyo3->tra_apellido;
        }

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
        $anexo = $data->anexo;
        $duracionSolicitudes = $data->descripcion_duracion;

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
            'descripcionTurno' =>$turno,
            'anexo' => $anexo,
            'duracionSolicitudes' => $duracionSolicitudes
        ];

        $pdf = App::make("dompdf.wrapper");
        $pdf->loadView('TicketIND', $data);
        $pdf->setOptions(['isJavascriptEnabled' => true]);
        $pdf->setOptions(['isRemoteEnabled' => true]);

        return $pdf->stream("TicketIND.pdf", array("Attachment" => 0));
    }

    public function imprimirPorTicketCA($id)
    {
        $data = GestionTicketsAps::select(
            'gestion_tickets_aps.*',
            'edificios.descripcionEdificio',
            'servicios.descripcionServicio',
            'unidad_esps.descripcionUnidadEsp',
            'estado_solicituds.descripcionEstado',
            'tipo_reparacions.descripcionTipoReparacion',
            'turnos.descripcionTurno',
            'users.anexo',
            'duracion_solicitudes.descripcion_duracion',
            DB::raw("CONCAT(users.nombre,' ',users.apellido) as nombre"),
            DB::raw("CONCAT(trabajadores.tra_nombre,' ',trabajadores.tra_apellido) as tra_nombre_apellido"),
            DB::raw("CONCAT(supervisores.sup_nombre,' ',supervisores.sup_apellido) as sup_nombre_apellido"),
            DB::raw("CONCAT(solicitud_tickets_aps.id) as nticket"),
            DB::raw("DATE_FORMAT(solicitud_tickets_aps.created_at, '%d/%m/%Y') as nfechaS"),
            DB::raw("IF (gestion_tickets_aps.fechaCambiada IS NULL ,DATE_FORMAT(gestion_tickets_aps.fechaInicio, '%d/%m/%Y'), DATE_FORMAT(gestion_tickets_aps.fechaCambiada, '%d/%m/%Y')) as nfechaI"),
            DB::raw("CONCAT(solicitud_tickets_aps.descripcionP) as desFormat")

        )
            ->join('trabajadores', 'gestion_tickets_aps.id_trabajador', '=', 'trabajadores.id')
            ->join('supervisores', 'gestion_tickets_aps.id_supervisor', '=', 'supervisores.id')
            ->join('solicitud_tickets_aps', 'gestion_tickets_aps.id_solicitud', '=', 'solicitud_tickets_aps.id')
            ->join('edificios', 'solicitud_tickets_aps.id_edificio', '=', 'edificios.id')
            ->join('servicios', 'solicitud_tickets_aps.id_servicio', '=', 'servicios.id')
            ->join('unidad_esps', 'solicitud_tickets_aps.id_ubicacionEx', '=', 'unidad_esps.id')
            ->join('estado_solicituds', 'solicitud_tickets_aps.id_estado', '=', 'estado_solicituds.id')
            ->join('tipo_reparacions', 'solicitud_tickets_aps.id_tipoReparacion', '=', 'tipo_reparacions.id')
            ->join('users', 'solicitud_tickets_aps.id_user', '=', 'users.id')
            ->join('turnos', 'gestion_tickets_aps.idTurno', '=', 'turnos.id')
            ->join('duracion_solicitudes', 'gestion_tickets_aps.idDuracion', '=', 'duracion_solicitudes.id')
            ->where('gestion_tickets_aps.id_solicitud', $id)
            ->first();

        $idApoyo1 = $data->idApoyo1;
        $idApoyo2 = $data->idApoyo2;
        $idApoyo3 = $data->idApoyo3;

        $apoyo1 = Trabajadores::firstWhere('id', $idApoyo1);
        $apoyo2 = Trabajadores::firstWhere('id', $idApoyo2);
        $apoyo3 = Trabajadores::firstWhere('id', $idApoyo3);

        $nom1 = "";
        $ape1 = "";
        $nom2 = "";
        $ape2 = "";
        $nom3 = "";
        $ape3 = "";


        if($idApoyo1 == 1){
            $nom1 = "-";
            $ape1 = "-";
        }else{
            $nom1 = $apoyo1->tra_nombre;
                $ape1 = $apoyo1->tra_apellido;
        }

        if($idApoyo2 == 1){
            $nom2 = "-";
            $ape2 = "-";
        }else{
            $nom2 = $apoyo2->tra_nombre;
                $ape2 = $apoyo2->tra_apellido;
        }

        if($idApoyo3 == 1){
            $nom3 = "-";
            $ape3 = "-";
        }else{
            $nom3 = $apoyo3->tra_nombre;
            $ape3 = $apoyo3->tra_apellido;
        }

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
        $anexo = $data->anexo;
        $duracionSolicitudes = $data->descripcion_duracion;
        $descripcionTraRealizado = $data->descripcionTraRealizado;

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
            'descripcionTraRealizado' => $descripcionTraRealizado,
            'nombreUsuario' => $nombreUsuario,
            'descripcionTurno' =>$turno,
            'anexo' => $anexo,
            'duracionSolicitudes' => $duracionSolicitudes
        ];

        $pdf = App::make("dompdf.wrapper");
        $pdf->loadView('TicketCA', $data);
        $pdf->setOptions(['isJavascriptEnabled' => true]);
        $pdf->setOptions(['isRemoteEnabled' => true]);

        return $pdf->stream("TicketCA.pdf", array("Attachment" => 0));
    }

    public function imprimirCilindroIND($id)
    {
        $data = Entregacilindros::select(
            DB::raw("CONCAT(trabajadores.tra_nombre,' ',trabajadores.tra_apellido) AS trabajador"),
            'gestion_tickets_i_n_ds.fechaInicio',
            'servicios.descripcionServicio',
            DB::raw("CONCAT(users.nombre,' ',users.apellido) AS usuario"),
            'users.run',
            'entregacilindros.idCilindro',
            'entregacilindros.cantRecepcion',
            'entregacilindros.cantEntrega',
            'entregacilindros.idTicket'
        )
            ->join('solicitud_ticket_i_n_ds', 'entregacilindros.idTicket', '=', 'solicitud_ticket_i_n_ds.id')
            ->join('gestion_tickets_i_n_ds', 'entregacilindros.idTicket', '=', 'gestion_tickets_i_n_ds.id_solicitud')
            ->join('trabajadores', 'gestion_tickets_i_n_ds.id_trabajador', '=', 'trabajadores.id')
            ->join('servicios', 'solicitud_ticket_i_n_ds.id_servicio', '=', 'servicios.id')
            ->join('users', 'solicitud_ticket_i_n_ds.id_user', '=', 'users.id')
            ->where('entregacilindros.idTicket', $id)
            ->get();

        $pdf = App::make("dompdf.wrapper");
        $pdf->loadView('ActCilindros', compact ('data'));
        $pdf->setOptions(['isJavascriptEnabled' => true]);
        $pdf->setOptions(['isRemoteEnabled' => true]);

        return $pdf->stream("ActCilindros.pdf", array("Attachment" => 0));
    }

    public function ExportarDataPDF(Request $request){
      try {
        if($request->idCategoria == 1){
            $data = GestionSolicitudes::select(
                'gestion_solicitudes.*',
                'edificios.descripcionEdificio',
                'servicios.descripcionServicio',
                'unidad_esps.descripcionUnidadEsp',
                'estado_solicituds.descripcionEstado',
                'tipo_reparacions.descripcionTipoReparacion',
                'turnos.descripcionTurno',
                'users.anexo',
                'duracion_solicitudes.descripcion_duracion',
                DB::raw("CONCAT(users.nombre,' ',users.apellido) as nombre"),
                DB::raw("CONCAT(trabajadores.tra_nombre,' ',trabajadores.tra_apellido) as tra_nombre_apellido"),
                DB::raw("CONCAT(supervisores.sup_nombre,' ',supervisores.sup_apellido) as sup_nombre_apellido"),
                DB::raw("CONCAT(solicitud_tickets.id) as nticket"),
                DB::raw("DATE_FORMAT(solicitud_tickets.created_at, '%d/%m/%Y') as nfechaS"),
                DB::raw("IF (gestion_solicitudes.fechaCambiada IS NULL ,DATE_FORMAT(gestion_solicitudes.fechaInicio, '%d/%m/%Y'), DATE_FORMAT(gestion_solicitudes.fechaCambiada, '%d/%m/%Y')) as nfechaI"),
                //DB::raw("fnStripTags(solicitud_tickets.descripcionP) as desFormat")
                DB::raw("CONCAT(solicitud_tickets.descripcionP) as desFormat")
    
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
                ->join('duracion_solicitudes', 'gestion_solicitudes.idDuracion', '=', 'duracion_solicitudes.id')
                ->where('gestion_solicitudes.id_solicitud', $request->idSolicitud)
                ->first();

            return $data;    
        }else if($request->idCategoria == 2){
            $data = GestionTicketEMS::select(
                'gestion_ticket_e_m_s.*',
                'edificios.descripcionEdificio',
                'servicios.descripcionServicio',
                'unidad_esps.descripcionUnidadEsp',
                'estado_solicituds.descripcionEstado',
                'tipo_reparacions.descripcionTipoReparacion',
                'turnos.descripcionTurno',
                'users.anexo',
                'duracion_solicitudes.descripcion_duracion',
                DB::raw("CONCAT(users.nombre,' ',users.apellido) as nombre"),
                DB::raw("CONCAT(trabajadores.tra_nombre,' ',trabajadores.tra_apellido) as tra_nombre_apellido"),
                DB::raw("CONCAT(supervisores.sup_nombre,' ',supervisores.sup_apellido) as sup_nombre_apellido"),
                DB::raw("CONCAT(solicitud_tickets_e_m_s.id) as nticket"),
                DB::raw("DATE_FORMAT(solicitud_tickets_e_m_s.created_at, '%d/%m/%Y') as nfechaS"),
                DB::raw("IF (gestion_ticket_e_m_s.fechaCambiada IS NULL ,DATE_FORMAT(gestion_ticket_e_m_s.fechaInicio, '%d/%m/%Y'), DATE_FORMAT(gestion_ticket_e_m_s.fechaCambiada, '%d/%m/%Y')) as nfechaI"),
                DB::raw("CONCAT(solicitud_tickets_e_m_s.descripcionP) as desFormat")
    
            )
                ->join('trabajadores', 'gestion_ticket_e_m_s.id_trabajador', '=', 'trabajadores.id')
                ->join('supervisores', 'gestion_ticket_e_m_s.id_supervisor', '=', 'supervisores.id')
                ->join('solicitud_tickets_e_m_s', 'gestion_ticket_e_m_s.id_solicitud', '=', 'solicitud_tickets_e_m_s.id')
                ->join('edificios', 'solicitud_tickets_e_m_s.id_edificio', '=', 'edificios.id')
                ->join('servicios', 'solicitud_tickets_e_m_s.id_servicio', '=', 'servicios.id')
                ->join('unidad_esps', 'solicitud_tickets_e_m_s.id_ubicacionEx', '=', 'unidad_esps.id')
                ->join('estado_solicituds', 'solicitud_tickets_e_m_s.id_estado', '=', 'estado_solicituds.id')
                ->join('tipo_reparacions', 'solicitud_tickets_e_m_s.id_tipoReparacion', '=', 'tipo_reparacions.id')
                ->join('users', 'solicitud_tickets_e_m_s.id_user', '=', 'users.id')
                ->join('turnos', 'gestion_ticket_e_m_s.idTurno', '=', 'turnos.id')
                ->join('duracion_solicitudes', 'gestion_ticket_e_m_s.idDuracion', '=', 'duracion_solicitudes.id')
                ->where('gestion_ticket_e_m_s.id_solicitud', $request->idSolicitud)
                ->first();
            return $data;    
        }else if($request->idCategoria == 3){
            $data = GestionTicketsINDs::select(
                'gestion_tickets_i_n_ds.*',
                'edificios.descripcionEdificio',
                'servicios.descripcionServicio',
                'unidad_esps.descripcionUnidadEsp',
                'estado_solicituds.descripcionEstado',
                'tipo_reparacions.descripcionTipoReparacion',
                'turnos.descripcionTurno',
                'users.anexo',
                'duracion_solicitudes.descripcion_duracion',
                DB::raw("CONCAT(users.nombre,' ',users.apellido) as nombre"),
                DB::raw("CONCAT(trabajadores.tra_nombre,' ',trabajadores.tra_apellido) as tra_nombre_apellido"),
                DB::raw("CONCAT(supervisores.sup_nombre,' ',supervisores.sup_apellido) as sup_nombre_apellido"),
                DB::raw("CONCAT(solicitud_ticket_i_n_ds.id) as nticket"),
                DB::raw("DATE_FORMAT(solicitud_ticket_i_n_ds.created_at, '%d/%m/%Y') as nfechaS"),
                DB::raw("IF (gestion_tickets_i_n_ds.fechaCambiada IS NULL ,DATE_FORMAT(gestion_tickets_i_n_ds.fechaInicio, '%d/%m/%Y'), DATE_FORMAT(gestion_tickets_i_n_ds.fechaCambiada, '%d/%m/%Y')) as nfechaI"),
                DB::raw("CONCAT(solicitud_ticket_i_n_ds.descripcionP) as desFormat")
    
            )
                ->join('trabajadores', 'gestion_tickets_i_n_ds.id_trabajador', '=', 'trabajadores.id')
                ->join('supervisores', 'gestion_tickets_i_n_ds.id_supervisor', '=', 'supervisores.id')
                ->join('solicitud_ticket_i_n_ds', 'gestion_tickets_i_n_ds.id_solicitud', '=', 'solicitud_ticket_i_n_ds.id')
                ->join('edificios', 'solicitud_ticket_i_n_ds.id_edificio', '=', 'edificios.id')
                ->join('servicios', 'solicitud_ticket_i_n_ds.id_servicio', '=', 'servicios.id')
                ->join('unidad_esps', 'solicitud_ticket_i_n_ds.id_ubicacionEx', '=', 'unidad_esps.id')
                ->join('estado_solicituds', 'solicitud_ticket_i_n_ds.id_estado', '=', 'estado_solicituds.id')
                ->join('tipo_reparacions', 'solicitud_ticket_i_n_ds.id_tipoReparacion', '=', 'tipo_reparacions.id')
                ->join('users', 'solicitud_ticket_i_n_ds.id_user', '=', 'users.id')
                ->join('turnos', 'gestion_tickets_i_n_ds.idTurno', '=', 'turnos.id')
                ->join('duracion_solicitudes', 'gestion_tickets_i_n_ds.idDuracion', '=', 'duracion_solicitudes.id')
                ->where('gestion_tickets_i_n_ds.id_solicitud', $request->idSolicitud)
                ->first();
            return $data;    
        }else if($request->idCategoria == 4){
            $data = GestionTicketsAps::select(
                'gestion_tickets_aps.*',
                'edificios.descripcionEdificio',
                'servicios.descripcionServicio',
                'unidad_esps.descripcionUnidadEsp',
                'estado_solicituds.descripcionEstado',
                'tipo_reparacions.descripcionTipoReparacion',
                'turnos.descripcionTurno',
                'users.anexo',
                'duracion_solicitudes.descripcion_duracion',
                DB::raw("CONCAT(users.nombre,' ',users.apellido) as nombre"),
                DB::raw("CONCAT(trabajadores.tra_nombre,' ',trabajadores.tra_apellido) as tra_nombre_apellido"),
                DB::raw("CONCAT(supervisores.sup_nombre,' ',supervisores.sup_apellido) as sup_nombre_apellido"),
                DB::raw("CONCAT(solicitud_tickets_aps.id) as nticket"),
                DB::raw("DATE_FORMAT(solicitud_tickets_aps.created_at, '%d/%m/%Y') as nfechaS"),
                DB::raw("IF (gestion_tickets_aps.fechaCambiada IS NULL ,DATE_FORMAT(gestion_tickets_aps.fechaInicio, '%d/%m/%Y'), DATE_FORMAT(gestion_tickets_aps.fechaCambiada, '%d/%m/%Y')) as nfechaI"),
                DB::raw("CONCAT(solicitud_tickets_aps.descripcionP) as desFormat")
    
            )
                ->join('trabajadores', 'gestion_tickets_aps.id_trabajador', '=', 'trabajadores.id')
                ->join('supervisores', 'gestion_tickets_aps.id_supervisor', '=', 'supervisores.id')
                ->join('solicitud_tickets_aps', 'gestion_tickets_aps.id_solicitud', '=', 'solicitud_tickets_aps.id')
                ->join('edificios', 'solicitud_tickets_aps.id_edificio', '=', 'edificios.id')
                ->join('servicios', 'solicitud_tickets_aps.id_servicio', '=', 'servicios.id')
                ->join('unidad_esps', 'solicitud_tickets_aps.id_ubicacionEx', '=', 'unidad_esps.id')
                ->join('estado_solicituds', 'solicitud_tickets_aps.id_estado', '=', 'estado_solicituds.id')
                ->join('tipo_reparacions', 'solicitud_tickets_aps.id_tipoReparacion', '=', 'tipo_reparacions.id')
                ->join('users', 'solicitud_tickets_aps.id_user', '=', 'users.id')
                ->join('turnos', 'gestion_tickets_aps.idTurno', '=', 'turnos.id')
                ->join('duracion_solicitudes', 'gestion_tickets_aps.idDuracion', '=', 'duracion_solicitudes.id')
                ->where('gestion_tickets_aps.id_solicitud', $request->idSolicitud)
                ->first();
            return $data;    
        }
          
      } catch (\Throwable $th) {
          log::info($th);
          return false;
      }
    }
}
