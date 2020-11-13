<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReemplazoAscensores extends Model
{
    protected $fillable = [
        'id_calendario_ascensores','id_trabajador_reemplazo',
        'fecha_inicio_reemplazo',
        'fecha_termino_reemplazo',
       ];
}
