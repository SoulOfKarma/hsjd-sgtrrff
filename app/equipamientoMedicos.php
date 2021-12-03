<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class equipamientoMedicos extends Model
{
    protected $fillable = [
        'equipo','marca','modelo','serie','ninventario'
    ];
}
