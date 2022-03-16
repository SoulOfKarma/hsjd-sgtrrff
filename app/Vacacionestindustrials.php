<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vacacionestindustrials extends Model
{
    protected $fillable = [
        'id_calendario_tindustrials','fecha_inicio_vacaciones','dias_vacaciones',
        'fecha_termino_vacaciones','estado_vacaciones',
    ];
}
