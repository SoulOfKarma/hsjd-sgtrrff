<?php

namespace App;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Users extends Authenticatable implements JWTSubject
{

    use Notifiable, HasApiTokens;
    
    protected $fillable = [
        'id', 'run','email', 'nombre', 'apellido', 'anexo',
        'id_cargo', 'id_cargo_asociado', 'id_edificio',
        'id_servicio', 'id_unidadEspecifica', 'password',
        'api_token'
    ];

    protected $hidden = ['password', 'remember_token'];

    public function getJWTIdentifier()
        {
            return $this->getKey();
        }
        public function getJWTCustomClaims()
        {
            return [];
        }
}
