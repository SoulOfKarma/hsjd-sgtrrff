<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $fillable = [
        'id', 'run','email', 'nombre', 'apellido', 'anexo',
        'id_cargo', 'id_cargo_asociado', 'id_edificio',
        'id_servicio', 'id_unidadEspecifica', 'password', 'password',
        'api_token'
    ];
}
