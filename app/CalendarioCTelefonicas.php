<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CalendarioCTelefonicas extends Model
{
    protected $table = 'calendario_ctelefonicas';
    
    protected $fillable = [
        'title','descripcion_ctelefonicas','id_turno',
        'id_trabajador','id_edificio','label','classes',
        'id_val_dia_administrativo','id_val_vacaciones',
        'id_val_reemplazo','id_val_turno_extra',
        'hora_inicio','hora_termino','startDate','endDate',
        'dias_ejecucion','horas_ejecucion',

    ];
}
