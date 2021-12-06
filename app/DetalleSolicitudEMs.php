<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleSolicitudEMs extends Model
{
    protected $fillable = [
        'id_solicitud','desresolucionresultados','desobservaciones','id_danoEQ',
    ];
}
