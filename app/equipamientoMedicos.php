<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class equipamientoMedicos extends Model
{
    protected $fillable = [
        'marca','modelo','serie','ninventario'
    ];
}
