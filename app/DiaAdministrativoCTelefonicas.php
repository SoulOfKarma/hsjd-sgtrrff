<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiaAdministrativoCTelefonicas extends Model
{

    protected $table = 'dia_administrativo_c_telefonicas';

    protected $fillable = [
        'id_calendario_ctelefonicas','id_tipo_dia_administrativo',
        'fecha_dia_administrativo','estado_dia_administrativo',
    ];
}
