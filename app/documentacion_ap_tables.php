<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class documentacion_ap_tables extends Model
{
    protected $fillable = [
        'idMAP', 'descripcionDocumento', 'nombreDocumento'

    ];
}
