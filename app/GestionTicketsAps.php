<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GestionTicketsAps extends Model
{
    protected $fillable = [
        'uuid', 'id_solicitud', 'id_trabajador', 'id_supervisor',
        'idApoyo1', 'idApoyo2', 'idApoyo3','idTurno','idDuracion',
        'horaInicio', 'horaTermino', 'fechaInicio', 'fechaTermino',
        'diasEjecucion', 'horasEjecucion',
    ];
}
