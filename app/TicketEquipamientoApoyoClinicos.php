<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketEquipamientoApoyoClinicos extends Model
{
    protected $fillable = [
        'id_solicitud','id_equipamiento_apoyoclinico'
    ];
}
