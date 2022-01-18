<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tra_sups extends Model
{
    protected $fillable = [
        'id_trabajador','id_supervisor'
    ];
}
