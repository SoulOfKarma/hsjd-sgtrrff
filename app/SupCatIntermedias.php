<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupCatIntermedias extends Model
{
    protected $fillable = [
        'id_supervisor','id_categoria',
    ];
}
