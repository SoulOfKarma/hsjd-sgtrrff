<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VacacionesCTelefonicas extends Model
{

    protected $table = 'vacaciones_c_telefonicas';

    protected $fillable = [
        'id_calendario_ctelefonicas','fecha_inicio_vacaciones','dias_vacaciones',
        'fecha_termino_vacaciones','estado_vacaciones',
    ];
}
