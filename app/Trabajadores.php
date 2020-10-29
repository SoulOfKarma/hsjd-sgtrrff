<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trabajadores extends Model
{
    protected $fillable = [
        'tra_run','tra_nombre','tra_apellido',
        'id_especialidad1',
    ];
}
