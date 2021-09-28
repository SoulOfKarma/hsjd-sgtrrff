<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GanttIndustrial extends Model
{
    protected $fillable = [
        'resourceId', 'start', 'end', 'title',
        'eventcolor', 'resourceAsociado',
    ];
}
