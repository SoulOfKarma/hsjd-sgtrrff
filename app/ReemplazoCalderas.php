<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReemplazoCalderas extends Model
{
    protected $fillable = [
        'id_calendario_calderas','id_trabajador_reemplazo','dias_reemplazo',
        'fecha_inicio_reemplazo',
        'fecha_termino_reemplazo','estado_reemplazo',
       ];
}
