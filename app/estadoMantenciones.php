<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class estadoMantenciones extends Model
{
    protected $fillable = [
        'id_mantencionIND','codMan','idEstadoManI'
    ];
}
