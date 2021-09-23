<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiaAdministrativoCalderas extends Model
{
    protected $fillable = [
        'id_calendario_calderas','id_tipo_dia_administrativo',
        'fecha_dia_administrativo','estado_dia_administrativo',
    ];
}
