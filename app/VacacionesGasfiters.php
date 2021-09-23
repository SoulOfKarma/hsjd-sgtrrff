<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VacacionesGasfiters extends Model
{
    protected $fillable = [
        'id_calendario_gasfiters','fecha_inicio_vacaciones','dias_vacaciones',
        'fecha_termino_vacaciones','estado_vacaciones',
    ];
}
