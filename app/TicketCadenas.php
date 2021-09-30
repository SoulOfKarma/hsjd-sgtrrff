<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketCadenas extends Model
{
    protected $fillable = [
        'idTicketPrincipal', 'idTicketNuevo'
    ];
}
