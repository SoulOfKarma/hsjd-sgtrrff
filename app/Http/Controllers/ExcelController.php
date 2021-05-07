<?php

namespace App\Http\Controllers;

use App\GestionSolicitudes;
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
        return GestionSolicitudes::select(
            DB::raw("CONCAT(solicitud_tickets.id) as nticket"),
            DB::raw("DATE_FORMAT(solicitud_tickets.created_at, '%d/%m/%Y') as nfechaS"),
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
        return GestionSolicitudes::select(
            DB::raw("CONCAT(solicitud_tickets.id) as nticket"),
            DB::raw("DATE_FORMAT(solicitud_tickets.created_at, '%d/%m/%Y') as nfechaS"),
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
        return GestionSolicitudes::select(
            DB::raw("CONCAT(solicitud_tickets.id) as nticket"),
            DB::raw("DATE_FORMAT(solicitud_tickets.created_at, '%d/%m/%Y') as nfechaS"),
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

        $data = GestionSolicitudes::select(
            DB::raw("CONCAT(solicitud_tickets.id) as nticket"),
            DB::raw("DATE_FORMAT(solicitud_tickets.created_at, '%d/%m/%Y') as nfechaS"),
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

        $data = GestionSolicitudes::select(
            DB::raw("CONCAT(solicitud_tickets.id) as nticket"),
            DB::raw("DATE_FORMAT(solicitud_tickets.created_at, '%d/%m/%Y') as nfechaS"),
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

        $data = GestionSolicitudes::select(
            DB::raw("CONCAT(solicitud_tickets.id) as nticket"),
            DB::raw("DATE_FORMAT(solicitud_tickets.created_at, '%d/%m/%Y') as nfechaS"),
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

class ExcelController extends Controller
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
