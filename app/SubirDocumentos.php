<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubirDocumentos extends Model
{
    protected $fillable = [
        'id_solicitud','nombre_documento',
    ];
}
