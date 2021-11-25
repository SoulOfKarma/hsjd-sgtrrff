<?php

namespace App\Http\Controllers;

use App\GestionSolicitudes;
use App\GestionTicketsAps;
use App\GestionTicketEMS;
use App\GestionTicketsINDs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use DB;

//Infraestructura Reporte EXCEL
class GestionExport implements FromCollection, WithHeadings, ShouldAutoSize
{

    use Exportable;

    public function collection()
    {
        $filtro = [1];
        return GestionSolicitudes::select(
            DB::raw("CONCAT(solicitud_tickets.id) as nticket"),
            DB::raw("DATE_FORMAT(solicitud_tickets.created_at, '%d/%m/%Y') as nfechaS"),
            DB::raw("CONCAT(DATE_FORMAT(solicitud_tickets.created_at,'%H:%i:%s')) as horaSolicitud"),
            'servicios.descripcionServicio',
            'edificios.descripcionEdificio',
            'tipo_reparacions.descripcionTipoReparacion',
            DB::raw("CONCAT(trabajadores.tra_nombre,' ',trabajadores.tra_apellido) as tra_nombre_apellido"),
            DB::raw("(select CONCAT(trabajadores.tra_nombre,"."' '".",trabajadores.tra_apellido) from trabajadores where trabajadores.id = gestion_solicitudes.idApoyo1) as apoyo1"),
            DB::raw("(select CONCAT(trabajadores.tra_nombre,"."' '".",trabajadores.tra_apellido) from trabajadores where trabajadores.id = gestion_solicitudes.idApoyo2) as apoyo2"),
            DB::raw("(select CONCAT(trabajadores.tra_nombre,"."' '".",trabajadores.tra_apellido) from trabajadores where trabajadores.id = gestion_solicitudes.idApoyo3) as apoyo3"),
            DB::raw("CONCAT(supervisores.sup_nombre,' ',supervisores.sup_apellido) as sup_nombre_apellido"),
            DB::raw("DATE_FORMAT(gestion_solicitudes.fechaInicio, '%d/%m/%Y') as nfechaI"),
            DB::raw("(CASE WHEN gestion_solicitudes.horasEjecucion IS NULL THEN '0'
             ELSE gestion_solicitudes.horasEjecucion END) AS horasEjecucion"),
            DB::raw("(CASE WHEN gestion_solicitudes.diasEjecucion IS NULL THEN '0'
             ELSE gestion_solicitudes.diasEjecucion END) AS diasEjecucion"),
            'estado_solicituds.descripcionEstado',
            DB::raw("fnStripTags(solicitud_tickets.descripcionP) as desFormat"),
            'turnos.descripcionTurno',
            DB::raw("CONCAT(users.nombre,' ',users.apellido) as nombre"),
            'duracion_solicitudes.descripcion_duracion',
            DB::raw("(CASE WHEN gestion_solicitudes.horaTermino IS NULL THEN '0'
             ELSE gestion_solicitudes.horaTermino END) AS horaTermino")
        )
            ->join('trabajadores', 'gestion_solicitudes.id_trabajador', '=', 'trabajadores.id')
            ->join('supervisores', 'gestion_solicitudes.id_supervisor', '=', 'supervisores.id')
            ->join('solicitud_tickets', 'gestion_solicitudes.id_solicitud', '=', 'solicitud_tickets.id')
            ->join('edificios', 'solicitud_tickets.id_edificio', '=', 'edificios.id')
            ->join('servicios', 'solicitud_tickets.id_servicio', '=', 'servicios.id')
            ->join('estado_solicituds', 'solicitud_tickets.id_estado', '=', 'estado_solicituds.id')
            ->join('tipo_reparacions', 'solicitud_tickets.id_tipoReparacion', '=', 'tipo_reparacions.id')
            ->join('users', 'solicitud_tickets.id_user', '=', 'users.id')
            ->join('turnos','gestion_solicitudes.idTurno', '=', 'turnos.id')
            ->join('duracion_solicitudes','gestion_solicitudes.idDuracion', '=', 'duracion_solicitudes.id')
            ->where('solicitud_tickets.id_categoria',$filtro)
            ->orderBy('solicitud_tickets.id')
            ->get();
    }

    public function headings(): array
    {
        return [
            'N° Ticket',
            'Fecha Solicitud',
            'Hora Solicitud',
            'Servicio',
            'Edificio',
            'Especialidad',
            'Responsable',
            'Apoyo 1',
            'Apoyo 2',
            'Apoyo 3',
            'Supervisor a Cargo',
            'Fecha de Programacion - Visita',
            'Horas de Ejecucion',
            'Dias de Ejecucion',
            'Estado Ticket',
            'Descripcion del Servicio Solicitado ',
            'Turno',
            'Nombre Solicitante',
            'Tipo de Trabajo',
            'Hora Termino',
        ];
    }
}

//Equipos Medicos Reporte EXCEL
class GestionExportEM implements FromCollection, WithHeadings, ShouldAutoSize
{

    use Exportable;

    public function collection()
    {
        $filtro = [2];
        return GestionTicketEMS::select(
            DB::raw("CONCAT(solicitud_tickets_e_m_s.id) as nticket"),
            DB::raw("DATE_FORMAT(solicitud_tickets_e_m_s.created_at, '%d/%m/%Y') as nfechaS"),
            DB::raw("CONCAT(DATE_FORMAT(solicitud_tickets_e_m_s.created_at,'%H:%i:%s')) as horaSolicitud"),
            'servicios.descripcionServicio',
            'edificios.descripcionEdificio',
            'tipo_reparacions.descripcionTipoReparacion',
            DB::raw("CONCAT(trabajadores.tra_nombre,' ',trabajadores.tra_apellido) as tra_nombre_apellido"),
            DB::raw("(select CONCAT(trabajadores.tra_nombre,"."' '".",trabajadores.tra_apellido) from trabajadores where trabajadores.id = gestion_ticket_e_m_s.idApoyo1) as apoyo1"),
            DB::raw("(select CONCAT(trabajadores.tra_nombre,"."' '".",trabajadores.tra_apellido) from trabajadores where trabajadores.id = gestion_ticket_e_m_s.idApoyo2) as apoyo2"),
            DB::raw("(select CONCAT(trabajadores.tra_nombre,"."' '".",trabajadores.tra_apellido) from trabajadores where trabajadores.id = gestion_ticket_e_m_s.idApoyo3) as apoyo3"),
            DB::raw("CONCAT(supervisores.sup_nombre,' ',supervisores.sup_apellido) as sup_nombre_apellido"),
            DB::raw("DATE_FORMAT(gestion_ticket_e_m_s.fechaInicio, '%d/%m/%Y') as nfechaI"),
            DB::raw("(CASE WHEN gestion_ticket_e_m_s.horasEjecucion IS NULL THEN '0'
             ELSE gestion_ticket_e_m_s.horasEjecucion END) AS horasEjecucion"),
            DB::raw("(CASE WHEN gestion_ticket_e_m_s.diasEjecucion IS NULL THEN '0'
             ELSE gestion_ticket_e_m_s.diasEjecucion END) AS diasEjecucion"),
            'estado_solicituds.descripcionEstado',
            DB::raw("fnStripTags(solicitud_tickets_e_m_s.descripcionP) as desFormat"),
            'turnos.descripcionTurno',
            DB::raw("CONCAT(users.nombre,' ',users.apellido) as nombre"),
            'duracion_solicitudes.descripcion_duracion',
            DB::raw("(CASE WHEN gestion_ticket_e_m_s.horaTermino IS NULL THEN '0'
             ELSE gestion_ticket_e_m_s.horaTermino END) AS horaTermino")
        )
            ->join('trabajadores', 'gestion_ticket_e_m_s.id_trabajador', '=', 'trabajadores.id')
            ->join('supervisores', 'gestion_ticket_e_m_s.id_supervisor', '=', 'supervisores.id')
            ->join('solicitud_tickets_e_m_s', 'gestion_ticket_e_m_s.id_solicitud', '=', 'solicitud_tickets_e_m_s.id')
            ->join('edificios', 'solicitud_tickets_e_m_s.id_edificio', '=', 'edificios.id')
            ->join('servicios', 'solicitud_tickets_e_m_s.id_servicio', '=', 'servicios.id')
            ->join('estado_solicituds', 'solicitud_tickets_e_m_s.id_estado', '=', 'estado_solicituds.id')
            ->join('tipo_reparacions', 'solicitud_tickets_e_m_s.id_tipoReparacion', '=', 'tipo_reparacions.id')
            ->join('users', 'solicitud_tickets_e_m_s.id_user', '=', 'users.id')
            ->join('turnos','gestion_ticket_e_m_s.idTurno', '=', 'turnos.id')
            ->join('duracion_solicitudes','gestion_ticket_e_m_s.idDuracion', '=', 'duracion_solicitudes.id')
            ->where('solicitud_tickets_e_m_s.id_categoria',$filtro)
            ->orderBy('solicitud_tickets_e_m_s.id')
            ->get();
    }

    public function headings(): array
    {
        return [
            'N° Ticket',
            'Fecha Solicitud',
            'Hora Solicitud',
            'Servicio',
            'Edificio',
            'Especialidad',
            'Responsable',
            'Apoyo 1',
            'Apoyo 2',
            'Apoyo 3',
            'Supervisor a Cargo',
            'Fecha de Programacion - Visita',
            'Horas de Ejecucion',
            'Dias de Ejecucion',
            'Estado Ticket',
            'Descripcion del Servicio Solicitado ',
            'Turno',
            'Nombre Solicitante',
            'Tipo de Trabajo',
            'Hora Termino',
        ];
    }
}

//Apoyo Clinico Reporte EXCEL

class GestionExportAP implements FromCollection, WithHeadings, ShouldAutoSize
{

    use Exportable;

    public function collection()
    {
        $filtro = [4];
        return GestionTicketsAps::select(
            DB::raw("CONCAT(solicitud_tickets_aps.id) as nticket"),
            DB::raw("DATE_FORMAT(solicitud_tickets_aps.created_at, '%d/%m/%Y') as nfechaS"),
            DB::raw("CONCAT(DATE_FORMAT(solicitud_tickets_aps.created_at,'%H:%i:%s')) as horaSolicitud"),
            'servicios.descripcionServicio',
            'edificios.descripcionEdificio',
            'tipo_reparacions.descripcionTipoReparacion',
            DB::raw("CONCAT(trabajadores.tra_nombre,' ',trabajadores.tra_apellido) as tra_nombre_apellido"),
            DB::raw("(select CONCAT(trabajadores.tra_nombre,"."' '".",trabajadores.tra_apellido) from trabajadores where trabajadores.id = gestion_tickets_aps.idApoyo1) as apoyo1"),
            DB::raw("(select CONCAT(trabajadores.tra_nombre,"."' '".",trabajadores.tra_apellido) from trabajadores where trabajadores.id = gestion_tickets_aps.idApoyo2) as apoyo2"),
            DB::raw("(select CONCAT(trabajadores.tra_nombre,"."' '".",trabajadores.tra_apellido) from trabajadores where trabajadores.id = gestion_tickets_aps.idApoyo3) as apoyo3"),
            DB::raw("CONCAT(supervisores.sup_nombre,' ',supervisores.sup_apellido) as sup_nombre_apellido"),
            DB::raw("DATE_FORMAT(gestion_tickets_aps.fechaInicio, '%d/%m/%Y') as nfechaI"),
            DB::raw("(CASE WHEN gestion_tickets_aps.horasEjecucion IS NULL THEN '0'
             ELSE gestion_tickets_aps.horasEjecucion END) AS horasEjecucion"),
            DB::raw("(CASE WHEN gestion_tickets_aps.diasEjecucion IS NULL THEN '0'
             ELSE gestion_tickets_aps.diasEjecucion END) AS diasEjecucion"),
            'estado_solicituds.descripcionEstado',
            DB::raw("fnStripTags(solicitud_tickets_aps.descripcionP) as desFormat"),
            'turnos.descripcionTurno',
            DB::raw("CONCAT(users.nombre,' ',users.apellido) as nombre"),
            'duracion_solicitudes.descripcion_duracion',
            DB::raw("(CASE WHEN gestion_tickets_aps.horaTermino IS NULL THEN '0'
             ELSE gestion_tickets_aps.horaTermino END) AS horaTermino")
        )
            ->join('trabajadores', 'gestion_tickets_aps.id_trabajador', '=', 'trabajadores.id')
            ->join('supervisores', 'gestion_tickets_aps.id_supervisor', '=', 'supervisores.id')
            ->join('solicitud_tickets_aps', 'gestion_tickets_aps.id_solicitud', '=', 'solicitud_tickets_aps.id')
            ->join('edificios', 'solicitud_tickets_aps.id_edificio', '=', 'edificios.id')
            ->join('servicios', 'solicitud_tickets_aps.id_servicio', '=', 'servicios.id')
            ->join('estado_solicituds', 'solicitud_tickets_aps.id_estado', '=', 'estado_solicituds.id')
            ->join('tipo_reparacions', 'solicitud_tickets_aps.id_tipoReparacion', '=', 'tipo_reparacions.id')
            ->join('users', 'solicitud_tickets_aps.id_user', '=', 'users.id')
            ->join('turnos','gestion_tickets_aps.idTurno', '=', 'turnos.id')
            ->join('duracion_solicitudes','gestion_tickets_aps.idDuracion', '=', 'duracion_solicitudes.id')
            ->where('solicitud_tickets_aps.id_categoria',$filtro)
            ->orderBy('solicitud_tickets_aps.id')
            ->get();
    }

    public function headings(): array
    {
        return [
            'N° Ticket',
            'Fecha Solicitud',
            'Hora Solicitud',
            'Servicio',
            'Edificio',
            'Especialidad',
            'Responsable',
            'Apoyo 1',
            'Apoyo 2',
            'Apoyo 3',
            'Supervisor a Cargo',
            'Fecha de Programacion - Visita',
            'Horas de Ejecucion',
            'Dias de Ejecucion',
            'Estado Ticket',
            'Descripcion del Servicio Solicitado ',
            'Turno',
            'Nombre Solicitante',
            'Tipo de Trabajo',
            'Hora Termino',
        ];
    }
}

//Industrial Reporte EXCEL

class GestionExportI implements FromCollection, WithHeadings, ShouldAutoSize
{

    use Exportable;

    public function collection()
    {
        $filtro = [3];
        return GestionTicketsINDs::select(
            DB::raw("CONCAT(solicitud_ticket_i_n_ds.id) as nticket"),
            DB::raw("DATE_FORMAT(solicitud_ticket_i_n_ds.created_at, '%d/%m/%Y') as nfechaS"),
            DB::raw("CONCAT(DATE_FORMAT(solicitud_ticket_i_n_ds.created_at,'%H:%i:%s')) as horaSolicitud"),
            'servicios.descripcionServicio',
            'edificios.descripcionEdificio',
            'tipo_reparacions.descripcionTipoReparacion',
            DB::raw("CONCAT(trabajadores.tra_nombre,' ',trabajadores.tra_apellido) as tra_nombre_apellido"),
            DB::raw("(select CONCAT(trabajadores.tra_nombre,"."' '".",trabajadores.tra_apellido) from trabajadores where trabajadores.id = gestion_tickets_i_n_ds.idApoyo1) as apoyo1"),
            DB::raw("(select CONCAT(trabajadores.tra_nombre,"."' '".",trabajadores.tra_apellido) from trabajadores where trabajadores.id = gestion_tickets_i_n_ds.idApoyo2) as apoyo2"),
            DB::raw("(select CONCAT(trabajadores.tra_nombre,"."' '".",trabajadores.tra_apellido) from trabajadores where trabajadores.id = gestion_tickets_i_n_ds.idApoyo3) as apoyo3"),
            DB::raw("CONCAT(supervisores.sup_nombre,' ',supervisores.sup_apellido) as sup_nombre_apellido"),
            DB::raw("DATE_FORMAT(gestion_tickets_i_n_ds.fechaInicio, '%d/%m/%Y') as nfechaI"),
            DB::raw("(CASE WHEN gestion_tickets_i_n_ds.horasEjecucion IS NULL THEN '0'
             ELSE gestion_tickets_i_n_ds.horasEjecucion END) AS horasEjecucion"),
            DB::raw("(CASE WHEN gestion_tickets_i_n_ds.diasEjecucion IS NULL THEN '0'
             ELSE gestion_tickets_i_n_ds.diasEjecucion END) AS diasEjecucion"),
            'estado_solicituds.descripcionEstado',
            DB::raw("fnStripTags(solicitud_ticket_i_n_ds.descripcionP) as desFormat"),
            'turnos.descripcionTurno',
            DB::raw("CONCAT(users.nombre,' ',users.apellido) as nombre"),
            'duracion_solicitudes.descripcion_duracion',
            DB::raw("(CASE WHEN gestion_tickets_i_n_ds.horaTermino IS NULL THEN '0'
             ELSE gestion_tickets_i_n_ds.horaTermino END) AS horaTermino")
        )
            ->join('trabajadores', 'gestion_tickets_i_n_ds.id_trabajador', '=', 'trabajadores.id')
            ->join('supervisores', 'gestion_tickets_i_n_ds.id_supervisor', '=', 'supervisores.id')
            ->join('solicitud_ticket_i_n_ds', 'gestion_tickets_i_n_ds.id_solicitud', '=', 'solicitud_ticket_i_n_ds.id')
            ->join('edificios', 'solicitud_ticket_i_n_ds.id_edificio', '=', 'edificios.id')
            ->join('servicios', 'solicitud_ticket_i_n_ds.id_servicio', '=', 'servicios.id')
            ->join('estado_solicituds', 'solicitud_ticket_i_n_ds.id_estado', '=', 'estado_solicituds.id')
            ->join('tipo_reparacions', 'solicitud_ticket_i_n_ds.id_tipoReparacion', '=', 'tipo_reparacions.id')
            ->join('users', 'solicitud_ticket_i_n_ds.id_user', '=', 'users.id')
            ->join('turnos','gestion_tickets_i_n_ds.idTurno', '=', 'turnos.id')
            ->join('duracion_solicitudes','gestion_tickets_i_n_ds.idDuracion', '=', 'duracion_solicitudes.id')
            ->where('solicitud_ticket_i_n_ds.id_categoria',$filtro)
            ->orderBy('solicitud_ticket_i_n_ds.id')
            ->get();
    }

    public function headings(): array
    {
        return [
            'N° Ticket',
            'Fecha Solicitud',
            'Hora Solicitud',
            'Servicio',
            'Edificio',
            'Especialidad',
            'Responsable',
            'Apoyo 1',
            'Apoyo 2',
            'Apoyo 3',
            'Supervisor a Cargo',
            'Fecha de Programacion - Visita',
            'Horas de Ejecucion',
            'Dias de Ejecucion',
            'Estado Ticket',
            'Descripcion del Servicio Solicitado ',
            'Turno',
            'Nombre Solicitante',
            'Tipo de Trabajo',
            'Hora Termino',
        ];
    }
}

//Infraestructura Reporte Fechas Excel

class GestionExportByFechas implements FromCollection, WithHeadings, ShouldAutoSize
{
    public function __construct($fechaInicio, $fechaTermino)
    {
        $this->fechaInicio = $fechaInicio . " 00:00:00";
        $this->fechaTermino = $fechaTermino . " 23:59:59";
    }

    use Exportable;

    public function collection()
    {
        $fechaI = $this->fechaInicio;
        $fechaT = $this->fechaTermino;
        $filtro = [1];

        $data = GestionSolicitudes::select(
            DB::raw("CONCAT(solicitud_tickets.id) as nticket"),
            DB::raw("DATE_FORMAT(solicitud_tickets.created_at, '%d/%m/%Y') as nfechaS"),
            DB::raw("CONCAT(DATE_FORMAT(solicitud_tickets.created_at,'%H:%i:%s')) as horaSolicitud"),
            'servicios.descripcionServicio',
            'edificios.descripcionEdificio',
            'tipo_reparacions.descripcionTipoReparacion',
            DB::raw("CONCAT(trabajadores.tra_nombre,' ',trabajadores.tra_apellido) as tra_nombre_apellido"),
            DB::raw("(select CONCAT(trabajadores.tra_nombre,"."' '".",trabajadores.tra_apellido) from trabajadores where trabajadores.id = gestion_solicitudes.idApoyo1) as apoyo1"),
            DB::raw("(select CONCAT(trabajadores.tra_nombre,"."' '".",trabajadores.tra_apellido) from trabajadores where trabajadores.id = gestion_solicitudes.idApoyo2) as apoyo2"),
            DB::raw("(select CONCAT(trabajadores.tra_nombre,"."' '".",trabajadores.tra_apellido) from trabajadores where trabajadores.id = gestion_solicitudes.idApoyo3) as apoyo3"),
            DB::raw("CONCAT(supervisores.sup_nombre,' ',supervisores.sup_apellido) as sup_nombre_apellido"),
            DB::raw("DATE_FORMAT(gestion_solicitudes.fechaInicio, '%d/%m/%Y') as nfechaI"),
            DB::raw("(CASE WHEN gestion_solicitudes.horasEjecucion IS NULL THEN '0'
             ELSE gestion_solicitudes.horasEjecucion END) AS horasEjecucion"),
            DB::raw("(CASE WHEN gestion_solicitudes.diasEjecucion IS NULL THEN '0'
             ELSE gestion_solicitudes.diasEjecucion END) AS diasEjecucion"),
            'estado_solicituds.descripcionEstado',
            DB::raw("fnStripTags(solicitud_tickets.descripcionP) as desFormat"),
            'turnos.descripcionTurno',
            DB::raw("CONCAT(users.nombre,' ',users.apellido) as nombre"),
            'duracion_solicitudes.descripcion_duracion',
            DB::raw("(CASE WHEN gestion_solicitudes.horaTermino IS NULL THEN '0'
             ELSE gestion_solicitudes.horaTermino END) AS horaTermino")
        )
            ->join('trabajadores', 'gestion_solicitudes.id_trabajador', '=', 'trabajadores.id')
            ->join('supervisores', 'gestion_solicitudes.id_supervisor', '=', 'supervisores.id')
            ->join('solicitud_tickets', 'gestion_solicitudes.id_solicitud', '=', 'solicitud_tickets.id')
            ->join('edificios', 'solicitud_tickets.id_edificio', '=', 'edificios.id')
            ->join('servicios', 'solicitud_tickets.id_servicio', '=', 'servicios.id')
            ->join('estado_solicituds', 'solicitud_tickets.id_estado', '=', 'estado_solicituds.id')
            ->join('tipo_reparacions', 'solicitud_tickets.id_tipoReparacion', '=', 'tipo_reparacions.id')
            ->join('users', 'solicitud_tickets.id_user', '=', 'users.id')
            ->join('turnos','gestion_solicitudes.idTurno', '=', 'turnos.id')
            ->join('duracion_solicitudes','gestion_solicitudes.idDuracion', '=', 'duracion_solicitudes.id')
            ->orderBy('solicitud_tickets.id')
            ->where('solicitud_tickets.id_categoria',$filtro)
            ->whereBetween('solicitud_tickets.created_at', [$fechaI, $fechaT])
            ->get();

        return $data;
    }

    public function headings(): array
    {
        return [
            'N° Ticket',
            'Fecha Solicitud',
            'Hora Solicitud',
            'Servicio',
            'Edificio',
            'Especialidad',
            'Responsable',
            'Apoyo 1',
            'Apoyo 2',
            'Apoyo 3',
            'Supervisor a Cargo',
            'Fecha de Programacion - Visita',
            'Horas de Ejecucion',
            'Dias de Ejecucion',
            'Estado Ticket',
            'Descripcion del Servicio Solicitado ',
            'Turno',
            'Nombre Solicitante',
            'Tipo de Trabajo',
            'Hora Termino',
        ];
    }
}

//Equipos Medicos Reporte Fechas Excel

class GestionExportByFechasEM implements FromCollection, WithHeadings, ShouldAutoSize
{
    public function __construct($fechaInicio, $fechaTermino)
    {
        $this->fechaInicio = $fechaInicio . " 00:00:00";
        $this->fechaTermino = $fechaTermino . " 23:59:59";
    }

    use Exportable;

    public function collection()
    {
        $fechaI = $this->fechaInicio;
        $fechaT = $this->fechaTermino;
        $filtro = [2];

        $data = GestionTicketEMS::select(
            DB::raw("CONCAT(solicitud_tickets_e_m_s.id) as nticket"),
            DB::raw("DATE_FORMAT(solicitud_tickets_e_m_s.created_at, '%d/%m/%Y') as nfechaS"),
            DB::raw("CONCAT(DATE_FORMAT(solicitud_tickets_e_m_s.created_at,'%H:%i:%s')) as horaSolicitud"),
            'servicios.descripcionServicio',
            'edificios.descripcionEdificio',
            'tipo_reparacions.descripcionTipoReparacion',
            DB::raw("CONCAT(trabajadores.tra_nombre,' ',trabajadores.tra_apellido) as tra_nombre_apellido"),
            DB::raw("(select CONCAT(trabajadores.tra_nombre,"."' '".",trabajadores.tra_apellido) from trabajadores where trabajadores.id = gestion_ticket_e_m_s.idApoyo1) as apoyo1"),
            DB::raw("(select CONCAT(trabajadores.tra_nombre,"."' '".",trabajadores.tra_apellido) from trabajadores where trabajadores.id = gestion_ticket_e_m_s.idApoyo2) as apoyo2"),
            DB::raw("(select CONCAT(trabajadores.tra_nombre,"."' '".",trabajadores.tra_apellido) from trabajadores where trabajadores.id = gestion_ticket_e_m_s.idApoyo3) as apoyo3"),
            DB::raw("CONCAT(supervisores.sup_nombre,' ',supervisores.sup_apellido) as sup_nombre_apellido"),
            DB::raw("DATE_FORMAT(gestion_ticket_e_m_s.fechaInicio, '%d/%m/%Y') as nfechaI"),
            DB::raw("(CASE WHEN gestion_ticket_e_m_s.horasEjecucion IS NULL THEN '0'
             ELSE gestion_ticket_e_m_s.horasEjecucion END) AS horasEjecucion"),
            DB::raw("(CASE WHEN gestion_ticket_e_m_s.diasEjecucion IS NULL THEN '0'
             ELSE gestion_ticket_e_m_s.diasEjecucion END) AS diasEjecucion"),
            'estado_solicituds.descripcionEstado',
            DB::raw("fnStripTags(solicitud_tickets_e_m_s.descripcionP) as desFormat"),
            'turnos.descripcionTurno',
            DB::raw("CONCAT(users.nombre,' ',users.apellido) as nombre"),
            'duracion_solicitudes.descripcion_duracion',
            DB::raw("(CASE WHEN gestion_ticket_e_m_s.horaTermino IS NULL THEN '0'
             ELSE gestion_ticket_e_m_s.horaTermino END) AS horaTermino")
        )
            ->join('trabajadores', 'gestion_ticket_e_m_s.id_trabajador', '=', 'trabajadores.id')
            ->join('supervisores', 'gestion_ticket_e_m_s.id_supervisor', '=', 'supervisores.id')
            ->join('solicitud_tickets_e_m_s', 'gestion_ticket_e_m_s.id_solicitud', '=', 'solicitud_tickets_e_m_s.id')
            ->join('edificios', 'solicitud_tickets_e_m_s.id_edificio', '=', 'edificios.id')
            ->join('servicios', 'solicitud_tickets_e_m_s.id_servicio', '=', 'servicios.id')
            ->join('estado_solicituds', 'solicitud_tickets_e_m_s.id_estado', '=', 'estado_solicituds.id')
            ->join('tipo_reparacions', 'solicitud_tickets_e_m_s.id_tipoReparacion', '=', 'tipo_reparacions.id')
            ->join('users', 'solicitud_tickets_e_m_s.id_user', '=', 'users.id')
            ->join('turnos','gestion_ticket_e_m_s.idTurno', '=', 'turnos.id')
            ->join('duracion_solicitudes','gestion_ticket_e_m_s.idDuracion', '=', 'duracion_solicitudes.id')
            ->orderBy('solicitud_tickets_e_m_s.id')
            ->where('solicitud_tickets_e_m_s.id_categoria',$filtro)
            ->whereBetween('solicitud_tickets_e_m_s.created_at', [$fechaI, $fechaT])
            ->get();

        return $data;
    }

    public function headings(): array
    {
        return [
            'N° Ticket',
            'Fecha Solicitud',
            'Hora Solicitud',
            'Servicio',
            'Edificio',
            'Especialidad',
            'Responsable',
            'Apoyo 1',
            'Apoyo 2',
            'Apoyo 3',
            'Supervisor a Cargo',
            'Fecha de Programacion - Visita',
            'Horas de Ejecucion',
            'Dias de Ejecucion',
            'Estado Ticket',
            'Descripcion del Servicio Solicitado ',
            'Turno',
            'Nombre Solicitante',
            'Tipo de Trabajo',
            'Hora Termino',
        ];
    }
}

//Apoyo Clinico Reporte Fechas Excel

class GestionExportByFechasAP implements FromCollection, WithHeadings, ShouldAutoSize
{
    public function __construct($fechaInicio, $fechaTermino)
    {
        $this->fechaInicio = $fechaInicio . " 00:00:00";
        $this->fechaTermino = $fechaTermino . " 23:59:59";
    }

    use Exportable;

    public function collection()
    {
        $fechaI = $this->fechaInicio;
        $fechaT = $this->fechaTermino;
        $filtro = [4];

        $data = GestionTicketsAps::select(
            DB::raw("CONCAT(solicitud_tickets_aps.id) as nticket"),
            DB::raw("DATE_FORMAT(solicitud_tickets_aps.created_at, '%d/%m/%Y') as nfechaS"),
            DB::raw("CONCAT(DATE_FORMAT(solicitud_tickets_aps.created_at,'%H:%i:%s')) as horaSolicitud"),
            'servicios.descripcionServicio',
            'edificios.descripcionEdificio',
            'tipo_reparacions.descripcionTipoReparacion',
            DB::raw("CONCAT(trabajadores.tra_nombre,' ',trabajadores.tra_apellido) as tra_nombre_apellido"),
            DB::raw("(select CONCAT(trabajadores.tra_nombre,"."' '".",trabajadores.tra_apellido) from trabajadores where trabajadores.id = gestion_tickets_aps.idApoyo1) as apoyo1"),
            DB::raw("(select CONCAT(trabajadores.tra_nombre,"."' '".",trabajadores.tra_apellido) from trabajadores where trabajadores.id = gestion_tickets_aps.idApoyo2) as apoyo2"),
            DB::raw("(select CONCAT(trabajadores.tra_nombre,"."' '".",trabajadores.tra_apellido) from trabajadores where trabajadores.id = gestion_tickets_aps.idApoyo3) as apoyo3"),
            DB::raw("CONCAT(supervisores.sup_nombre,' ',supervisores.sup_apellido) as sup_nombre_apellido"),
            DB::raw("DATE_FORMAT(gestion_tickets_aps.fechaInicio, '%d/%m/%Y') as nfechaI"),
            DB::raw("(CASE WHEN gestion_tickets_aps.horasEjecucion IS NULL THEN '0'
             ELSE gestion_tickets_aps.horasEjecucion END) AS horasEjecucion"),
            DB::raw("(CASE WHEN gestion_tickets_aps.diasEjecucion IS NULL THEN '0'
             ELSE gestion_tickets_aps.diasEjecucion END) AS diasEjecucion"),
            'estado_solicituds.descripcionEstado',
            DB::raw("fnStripTags(solicitud_tickets_aps.descripcionP) as desFormat"),
            'turnos.descripcionTurno',
            DB::raw("CONCAT(users.nombre,' ',users.apellido) as nombre"),
            'duracion_solicitudes.descripcion_duracion',
            DB::raw("(CASE WHEN gestion_tickets_aps.horaTermino IS NULL THEN '0'
             ELSE gestion_tickets_aps.horaTermino END) AS horaTermino")
        )
            ->join('trabajadores', 'gestion_tickets_aps.id_trabajador', '=', 'trabajadores.id')
            ->join('supervisores', 'gestion_tickets_aps.id_supervisor', '=', 'supervisores.id')
            ->join('solicitud_tickets_aps', 'gestion_tickets_aps.id_solicitud', '=', 'solicitud_tickets_aps.id')
            ->join('edificios', 'solicitud_tickets_aps.id_edificio', '=', 'edificios.id')
            ->join('servicios', 'solicitud_tickets_aps.id_servicio', '=', 'servicios.id')
            ->join('estado_solicituds', 'solicitud_tickets_aps.id_estado', '=', 'estado_solicituds.id')
            ->join('tipo_reparacions', 'solicitud_tickets_aps.id_tipoReparacion', '=', 'tipo_reparacions.id')
            ->join('users', 'solicitud_tickets_aps.id_user', '=', 'users.id')
            ->join('turnos','gestion_tickets_aps.idTurno', '=', 'turnos.id')
            ->join('duracion_solicitudes','gestion_tickets_aps.idDuracion', '=', 'duracion_solicitudes.id')
            ->orderBy('solicitud_tickets_aps.id')
            ->where('solicitud_tickets_aps.id_categoria',$filtro)
            ->whereBetween('solicitud_tickets_aps.created_at', [$fechaI, $fechaT])
            ->get();

        return $data;
    }

    public function headings(): array
    {
        return [
            'N° Ticket',
            'Fecha Solicitud',
            'Hora Solicitud',
            'Servicio',
            'Edificio',
            'Especialidad',
            'Responsable',
            'Apoyo 1',
            'Apoyo 2',
            'Apoyo 3',
            'Supervisor a Cargo',
            'Fecha de Programacion - Visita',
            'Horas de Ejecucion',
            'Dias de Ejecucion',
            'Estado Ticket',
            'Descripcion del Servicio Solicitado ',
            'Turno',
            'Nombre Solicitante',
            'Tipo de Trabajo',
            'Hora Termino',
        ];
    }
}

//Industrial Reporte Fechas Excel

class GestionExportByFechasI implements FromCollection, WithHeadings, ShouldAutoSize
{
    public function __construct($fechaInicio, $fechaTermino)
    {
        $this->fechaInicio = $fechaInicio . " 00:00:00";
        $this->fechaTermino = $fechaTermino . " 23:59:59";
    }

    use Exportable;

    public function collection()
    {
        $fechaI = $this->fechaInicio;
        $fechaT = $this->fechaTermino;
        $filtro = [3];

        $data = GestionTicketsINDs::select(
            DB::raw("CONCAT(solicitud_ticket_i_n_ds.id) as nticket"),
            DB::raw("DATE_FORMAT(solicitud_ticket_i_n_ds.created_at, '%d/%m/%Y') as nfechaS"),
            DB::raw("CONCAT(DATE_FORMAT(solicitud_ticket_i_n_ds.created_at,'%H:%i:%s')) as horaSolicitud"),
            'servicios.descripcionServicio',
            'edificios.descripcionEdificio',
            'tipo_reparacions.descripcionTipoReparacion',
            DB::raw("CONCAT(trabajadores.tra_nombre,' ',trabajadores.tra_apellido) as tra_nombre_apellido"),
            DB::raw("(select CONCAT(trabajadores.tra_nombre,"."' '".",trabajadores.tra_apellido) from trabajadores where trabajadores.id = gestion_tickets_i_n_ds.idApoyo1) as apoyo1"),
            DB::raw("(select CONCAT(trabajadores.tra_nombre,"."' '".",trabajadores.tra_apellido) from trabajadores where trabajadores.id = gestion_tickets_i_n_ds.idApoyo2) as apoyo2"),
            DB::raw("(select CONCAT(trabajadores.tra_nombre,"."' '".",trabajadores.tra_apellido) from trabajadores where trabajadores.id = gestion_tickets_i_n_ds.idApoyo3) as apoyo3"),
            DB::raw("CONCAT(supervisores.sup_nombre,' ',supervisores.sup_apellido) as sup_nombre_apellido"),
            DB::raw("DATE_FORMAT(gestion_tickets_i_n_ds.fechaInicio, '%d/%m/%Y') as nfechaI"),
            DB::raw("(CASE WHEN gestion_tickets_i_n_ds.horasEjecucion IS NULL THEN '0'
             ELSE gestion_tickets_i_n_ds.horasEjecucion END) AS horasEjecucion"),
            DB::raw("(CASE WHEN gestion_tickets_i_n_ds.diasEjecucion IS NULL THEN '0'
             ELSE gestion_tickets_i_n_ds.diasEjecucion END) AS diasEjecucion"),
            'estado_solicituds.descripcionEstado',
            DB::raw("fnStripTags(solicitud_ticket_i_n_ds.descripcionP) as desFormat"),
            'turnos.descripcionTurno',
            DB::raw("CONCAT(users.nombre,' ',users.apellido) as nombre"),
            'duracion_solicitudes.descripcion_duracion',
            DB::raw("(CASE WHEN gestion_tickets_i_n_ds.horaTermino IS NULL THEN '0'
             ELSE gestion_tickets_i_n_ds.horaTermino END) AS horaTermino")
        )
            ->join('trabajadores', 'gestion_tickets_i_n_ds.id_trabajador', '=', 'trabajadores.id')
            ->join('supervisores', 'gestion_tickets_i_n_ds.id_supervisor', '=', 'supervisores.id')
            ->join('solicitud_ticket_i_n_ds', 'gestion_tickets_i_n_ds.id_solicitud', '=', 'solicitud_ticket_i_n_ds.id')
            ->join('edificios', 'solicitud_ticket_i_n_ds.id_edificio', '=', 'edificios.id')
            ->join('servicios', 'solicitud_ticket_i_n_ds.id_servicio', '=', 'servicios.id')
            ->join('estado_solicituds', 'solicitud_ticket_i_n_ds.id_estado', '=', 'estado_solicituds.id')
            ->join('tipo_reparacions', 'solicitud_ticket_i_n_ds.id_tipoReparacion', '=', 'tipo_reparacions.id')
            ->join('users', 'solicitud_ticket_i_n_ds.id_user', '=', 'users.id')
            ->join('turnos','gestion_tickets_i_n_ds.idTurno', '=', 'turnos.id')
            ->join('duracion_solicitudes','gestion_tickets_i_n_ds.idDuracion', '=', 'duracion_solicitudes.id')
            ->orderBy('solicitud_ticket_i_n_ds.id')
            ->where('solicitud_ticket_i_n_ds.id_categoria',$filtro)
            ->whereBetween('solicitud_ticket_i_n_ds.created_at', [$fechaI, $fechaT])
            ->get();

        return $data;
    }

    public function headings(): array
    {
        return [
            'N° Ticket',
            'Fecha Solicitud',
            'Hora Solicitud',
            'Servicio',
            'Edificio',
            'Especialidad',
            'Responsable',
            'Apoyo 1',
            'Apoyo 2',
            'Apoyo 3',
            'Supervisor a Cargo',
            'Fecha de Programacion - Visita',
            'Horas de Ejecucion',
            'Dias de Ejecucion',
            'Estado Ticket',
            'Descripcion del Servicio Solicitado ',
            'Turno',
            'Nombre Solicitante',
            'Tipo de Trabajo',
            'Hora Termino',
        ];
    }
}


class ExcelJefaturaController extends Controller
{
    public function generarExcelTodo(Request $request)
    {
        return \Excel::download(new GestionExport, 'Reporte.xlsx');
    }

    public function generarExcelByFecha($fechaInicio, $fechaTermino)
    {
        return \Excel::download(new GestionExportByFechas($fechaInicio, $fechaTermino), 'Reporte.xlsx');
    }

    public function generarExcelTodoEM(Request $request)
    {
        return \Excel::download(new GestionExportEM, 'Reporte.xlsx');
    }

    public function generarExcelByFechaEM($fechaInicio, $fechaTermino)
    {
        return \Excel::download(new GestionExportByFechasEM($fechaInicio, $fechaTermino), 'Reporte.xlsx');
    }

    public function generarExcelTodoAP(Request $request)
    {
        return \Excel::download(new GestionExportAP, 'Reporte.xlsx');
    }

    public function generarExcelByFechaAP($fechaInicio, $fechaTermino)
    {
        return \Excel::download(new GestionExportByFechasAP($fechaInicio, $fechaTermino), 'Reporte.xlsx');
    }

    public function generarExcelTodoI(Request $request)
    {
        return \Excel::download(new GestionExportI, 'Reporte.xlsx');
    }

    public function generarExcelByFechaI($fechaInicio, $fechaTermino)
    {
        return \Excel::download(new GestionExportByFechasI($fechaInicio, $fechaTermino), 'Reporte.xlsx');
    }
}
