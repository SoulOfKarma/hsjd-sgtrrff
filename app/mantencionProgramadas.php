<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class mantencionProgramadas extends Model
{
    protected $fillable = [
        'id_edificio','descripcion_mantencion','descripcion_proveedor','codManEne','codManFeb','codManMar','codManAbr',
        'codManMay','codManJun','codManJul','codManAgo','codManSep','codManOct',
        'codManNov','codManDic','desFrecuencia','id_anio','id_tmantencion'
    ];
}
