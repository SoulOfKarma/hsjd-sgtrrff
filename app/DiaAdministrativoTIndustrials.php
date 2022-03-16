<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiaAdministrativoTIndustrials extends Model
{
    protected $fillable = [
        'id_calendario_t_industrials','id_tipo_dia_administrativo',
        'fecha_dia_administrativo','estado_dia_administrativo',
    ];
}
