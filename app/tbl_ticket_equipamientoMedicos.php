<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbl_ticket_equipamientoMedicos extends Model
{
    protected $fillable = [
        'id_solicitud','id_equipamiento_medico'
    ];
}
