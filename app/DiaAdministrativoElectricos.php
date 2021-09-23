<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiaAdministrativoElectricos extends Model
{
    protected $fillable = [
        'id_calendario_electricos','id_tipo_dia_administrativo',
        'fecha_dia_administrativo','estado_dia_administrativo',
    ];
}
