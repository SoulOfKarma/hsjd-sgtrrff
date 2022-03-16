<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reemplazotindustrials extends Model
{
    protected $fillable = [
        'id_calendario_tindustrials','id_trabajador_reemplazo','dias_reemplazo',
        'fecha_inicio_reemplazo',
        'fecha_termino_reemplazo','estado_reemplazo',
       ];
}
