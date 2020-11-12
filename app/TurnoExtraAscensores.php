<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TurnoExtraAscensores extends Model
{
    protected $fillable = [
        'id_calendario_ascensores','hora_inicio_turno_extra',
        'fecha_inicio_turno_extra','fecha_termino_turno_extra',
        'dias_ejecucion_turno_extra','horas_ejecucion_turno_extra',
    ];
}
