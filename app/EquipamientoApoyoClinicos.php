<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EquipamientoApoyoClinicos extends Model
{
    protected $fillable = [
        'equipo','marca','modelo','serie','ninventario'
    ];
}
