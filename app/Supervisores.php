<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supervisores extends Model
{
    protected $fillable = [
        'sup_run','sup_nombre','sup_apellido',
        'id_especialidad1','id_especialidad2'
    ];
}
