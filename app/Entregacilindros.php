<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entregacilindros extends Model
{
    protected $fillable = [
        'idTicket',
        'idCilindro',
        'cantRecepcion',
        'cantEntrega',
    ];
}
