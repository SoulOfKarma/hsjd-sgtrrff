<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class estado_ap_mantenciones extends Model
{
    protected $fillable = [
        'id_mantencionAP', 'codMan', 'idEstadoManAP','codManMes'

    ];
}
