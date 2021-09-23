<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReemplazoOxigenistas extends Model
{
    protected $fillable = [
        'id_calendario_oxigenistas','id_trabajador_reemplazo','dias_reemplazo',
        'fecha_inicio_reemplazo',
        'fecha_termino_reemplazo','estado_reemplazo',
       ];
}
