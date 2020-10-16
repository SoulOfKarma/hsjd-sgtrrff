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


class GestionExport implements FromCollection, WithHeadings, ShouldAutoSize
{

    use Exportable;

    public function collection()
    {
        return GestionSolicitudes::select(
            DB::raw("CONCAT(DATE_FORMAT(solicitud_tickets.created_at, '%d%m%Y'),'-',solicitud_tickets.id,'-',solicitud_tickets.id_user) as nticket"),
            DB::raw("DATE_FORMAT(solicitud_tickets.created_at, '%d/%m/%Y') as nfechaS"),
            'edificios.descripcionEdificio',
            'servicios.descripcionServicio',
            'unidad_esps.descripcionUnidadEsp',
            'tipo_reparacions.descripcionTipoReparacion',
            DB::raw("CONCAT(trabajadores.tra_nombre,' ',trabajadores.tra_apellido) as tra_nombre_apellido"),
            DB::raw("(select CONCAT(trabajadores.tra_nombre,"."' '".",trabajadores.tra_apellido) from trabajadores where trabajadores.id = gestion_solicitudes.idApoyo1) as apoyo1"),
            DB::raw("(select CONCAT(trabajadores.tra_nombre,"."' '".",trabajadores.tra_apellido) from trabajadores where trabajadores.id = gestion_solicitudes.idApoyo2) as apoyo2"),
            DB::raw("(select CONCAT(trabajadores.tra_nombre,"."' '".",trabajadores.tra_apellido) from trabajadores where trabajadores.id = gestion_solicitudes.idApoyo3) as apoyo3"),
            DB::raw("CONCAT(supervisores.sup_nombre,' ',supervisores.sup_apellido) as sup_nombre_apellido"),
            DB::raw("DATE_FORMAT(gestion_solicitudes.fechaInicio, '%d/%m/%Y') as nfechaI"),
            'gestion_solicitudes.horasEjecucion',
            'gestion_solicitudes.diasEjecucion',
            'estado_solicituds.descripcionEstado',
            DB::raw("fnStripTags(solicitud_tickets.descripcionP) as desFormat"),
            DB::raw("CONCAT(users.nombre,' ',users.apellido) as nombre"),
            'gestion_solicitudes.horaInicio',
            'gestion_solicitudes.horaCambiada',
            'gestion_solicitudes.horaTermino'
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
            'Unidad Especifica',
            'Especialidad Requerida',
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
            'Nombre Solicitante',
            'Hora Inicio',
            'Hora Cambiada',
            'Hora Termino',
        ];
    }
}

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

        $data = GestionSolicitudes::select(
            DB::raw("CONCAT(DATE_FORMAT(solicitud_tickets.created_at, '%d%m%Y'),'-',solicitud_tickets.id,'-',solicitud_tickets.id_user) as nticket"),
            DB::raw("DATE_FORMAT(solicitud_tickets.created_at, '%d/%m/%Y') as nfechaS"),
            'edificios.descripcionEdificio',
            'servicios.descripcionServicio',
            'unidad_esps.descripcionUnidadEsp',
            'tipo_reparacions.descripcionTipoReparacion',
            DB::raw("CONCAT(trabajadores.tra_nombre,' ',trabajadores.tra_apellido) as tra_nombre_apellido"),
            DB::raw("(select CONCAT(trabajadores.tra_nombre,"."' '".",trabajadores.tra_apellido) from trabajadores where trabajadores.id = gestion_solicitudes.idApoyo1) as apoyo1"),
            DB::raw("(select CONCAT(trabajadores.tra_nombre,"."' '".",trabajadores.tra_apellido) from trabajadores where trabajadores.id = gestion_solicitudes.idApoyo2) as apoyo2"),
            DB::raw("(select CONCAT(trabajadores.tra_nombre,"."' '".",trabajadores.tra_apellido) from trabajadores where trabajadores.id = gestion_solicitudes.idApoyo3) as apoyo3"),
            DB::raw("CONCAT(supervisores.sup_nombre,' ',supervisores.sup_apellido) as sup_nombre_apellido"),
            DB::raw("DATE_FORMAT(gestion_solicitudes.fechaInicio, '%d/%m/%Y') as nfechaI"),
            'gestion_solicitudes.horasEjecucion',
            'gestion_solicitudes.diasEjecucion',
            'estado_solicituds.descripcionEstado',
            DB::raw("fnStripTags(solicitud_tickets.descripcionP) as desFormat"),
            'users.nombre',
            'gestion_solicitudes.horaInicio',
            'gestion_solicitudes.horaCambiada',
            'gestion_solicitudes.horaTermino'
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
            ->orderBy('solicitud_tickets.id')
            ->whereBetween('solicitud_tickets.created_at', [$fechaI, $fechaT])
            ->get();

        log::info($data);

        return $data;
    }

    public function headings(): array
    {
        return [
            'N° Ticket',
            'Fecha Solicitud',
            'Servicio',
            'Edificio',
            'Unidad Especifica',
            'Especialidad Requerida',
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
            'Nombre Solicitante',
            'Hora Inicio',
            'Hora Cambiada',
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

        log::info($fechaInicio);
        log::info($fechaTermino);
        return \Excel::download(new GestionExportByFechas($fechaInicio, $fechaTermino), 'Reporte.xlsx');
    }
}
