<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReemplazoCTelefonicas extends Model
{
    protected $table = 'reemplazo_c_telefonicas';

    protected $fillable = [
        'id_calendario_ctelefonicas','id_trabajador_reemplazo','dias_reemplazo',
        'fecha_inicio_reemplazo',
        'fecha_termino_reemplazo','estado_reemplazo',
       ];
}
