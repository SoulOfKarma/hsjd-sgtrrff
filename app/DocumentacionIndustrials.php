<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentacionIndustrials extends Model
{
    protected $fillable = [
        'idMIndustrial','descripcionDocumento','nombreDocumento',
    ];
}
