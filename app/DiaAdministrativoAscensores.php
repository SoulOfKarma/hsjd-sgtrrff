<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiaAdministrativoAscensores extends Model
{
    protected $fillable = [
        'id_calendario_ascensores','id_tipo_dia_administrativo',
        'fecha_dia_administrativo','estado_dia_administrativo',
    ];
}
