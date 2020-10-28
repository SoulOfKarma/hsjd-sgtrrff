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

    public function buscarUsuarioData($id){
        $getdata = Users::where('id',$id)->first();
        return $getdata;
    }

    public function traerTodoUsuarios()
    {
        $get_all = Users::select('id',DB::raw("CONCAT(nombre,' ',apellido) as nombrecompleto"))
        ->where('id_cargo',1)
        ->get();

        return  $get_all;
        //
    }

    public function registrarUsuario(Request $request){
        $run = $request->run_usuario;
        $run = str_replace('.', '', $run);
        $run = strtoupper($run);

        tblPermisoUsuarios::create([
            'run_usuario' => $run,
            'permiso_usuario' => $request->permiso_usuario,
            'estado_login' =>  $request->estado_login
        ]);

        Users::create([
            'run' => $run,
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
        $run = $request->run_usuario;
        $run = str_replace('.', '', $run);
        $run = strtoupper($run);

        tblPermisoUsuarios::create([
            'run_usuario' => $run,
            'permiso_usuario' => $request->permiso_usuario,
            'estado_login' =>  $request->estado_login
        ]);

        Users::create([
            'run' => $run,
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

    public function getSoloSupervisoresRRFF()
    {
        $getall = Users::select('Users.*',DB::raw("CONCAT(Users.nombre,' ',Users.apellido) as nombreSupervisor"))
        ->where('id',[5])
        ->get();
        return $getall;
    }
}
