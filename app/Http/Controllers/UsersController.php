<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Users;
use App\tblPermisoUsuarios;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use DB;

class UsersController extends Controller
{
    public function traerTodoUsuarios()
    {
        $get_all = Users::select('id',DB::raw("CONCAT(nombre,' ',apellido) as nombrecompleto"))
        ->where('id_cargo',1)
        ->get();

        return  $get_all;
        //
    }

    public function registrarUsuario(Request $request){
        $respuesta = tblPermisoUsuarios::create($request->all());
        Users::create([
            'run' => $request->run,
            'email' => $request->email,
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'anexo' => $request->anexo,
            'id_cargo' => $request->id_cargo,
            'id_cargo_asociado' => $request->id_cargo_asociado,
            'id_edificio' => $request->id_edificio,
            'id_servicio' => $request->id_servicio,
            'id_unidadEspecifica' => $request->id_unidadEspecifica,
            'password' => Hash::make($request->password),
            'api_token' => Str::random(60),
        ]);

        return "Ok";

        
    }

    public function registrarUsuarioSub(Request $request){
        $respuesta = tblPermisoUsuarios::create($request->all());
        Users::create([
            'run' => $request->run,
            'email' => $request->email,
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'anexo' => $request->anexo,
            'id_cargo' => $request->id_cargo,
            'id_cargo_asociado' => $request->id_cargo_asociado,
            'id_edificio' => $request->id_edificio,
            'id_servicio' => $request->id_servicio,
            'id_unidadEspecifica' => $request->id_unidadEspecifica,
            'password' => Hash::make($request->password),
            'api_token' => Str::random(60),
        ]);

        return "Ok";

        
    }
}
