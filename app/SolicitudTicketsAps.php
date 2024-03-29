<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SolicitudTicketsAps extends Model
{
    protected $fillable = [
        'id', 'uuid', 'id_user', 'id_estado',
        'id_edificio', 'id_servicio', 'id_ubicacionEx',
        'id_tipoReparacion', 'id_categoria', 'tituloP', 'descripcionP','id_prioridad'
    ];
}
