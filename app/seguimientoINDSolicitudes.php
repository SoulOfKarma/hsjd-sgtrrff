<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class seguimientoINDSolicitudes extends Model
{
    protected $fillable = [
        'uuid', 'id_solicitud', 'id_user', 'descripcionSeguimiento'

    ];
}
