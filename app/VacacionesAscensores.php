<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VacacionesAscensores extends Model
{
    protected $fillable = [
        'id_calendario_ascensores','fecha_inicio_vacaciones','dias_vacaciones',
        'fecha_termino_vacaciones','estado_vacaciones',
    ];
}
