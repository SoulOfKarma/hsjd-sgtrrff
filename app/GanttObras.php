<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GanttObras extends Model
{
    protected $fillable = [
        'resourceId', 'start', 'end', 'title',
        'eventcolor', 'resourceAsociado',
    ];
}
