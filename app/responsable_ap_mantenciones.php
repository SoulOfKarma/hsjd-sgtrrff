<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class responsable_ap_mantenciones extends Model
{
    protected $fillable = [
        'id_matencion_ap', 'codMan', 'id_trabajador','codManMes'

    ];
}
