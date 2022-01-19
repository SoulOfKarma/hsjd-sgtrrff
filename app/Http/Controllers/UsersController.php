<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Users;
use App\tblPermisoUsuarios;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Supervisores;
use App\Trabajadores;
use App\SupCatIntermedias;
use App\tra_sups;
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
        try
        {       
            $idvalrun = $request->idvalRut;
            $idvalmail = $request->idvalmail;
         if($idvalrun == 1){
            if($idvalmail == 1){
                $run = $request->run_usuario;
                $run = str_replace('.', '', $run);
                $run = strtoupper($run); 
                Users::create([
                   'run' =>  $run,
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
       
                 tblPermisoUsuarios::create([
                   'run_usuario' => $run,
                   'permiso_usuario' => $request->permiso_usuario,
                   'estado_login' =>  $request->estado_login
                ]); 
             }else{
                $run = $request->run_usuario;
                $run = str_replace('.', '', $run);
                $run = strtoupper($run); 
       
                Users::create([
                   'run' =>  $run,
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
       
                 tblPermisoUsuarios::create([
                   'run_usuario' => $run,
                   'permiso_usuario' => $request->permiso_usuario,
                   'estado_login' =>  $request->estado_login
                ]); 
            }
         }else{
             if($idvalmail == 1){
                Users::create([
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
             }else{
                Users::create([
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
             }
         }   
         return true;
        }
        catch(\Throwable $th){
          return false;
        }
        
    }

    public function modificarUsuarioJefe(Request $request){
        try {
            $idvalrun = $request->idvalRut;
            $idvalmail = $request->idvalmail;
            if($idvalrun == 1){
                if($idvalmail == 1){
                    $run = $request->run_usuario;
                    $run = str_replace('.', '', $run);
                    $run = strtoupper($run);
                    Users::where('id',$request->id)
                    ->update([
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

                    DB::table('tbl_permiso_usuarios')
                    ->updateOrInsert([
                        'run_usuario' => $run,
                        'permiso_usuario' => $request->permiso_usuario,
                        'estado_login' =>  $request->estado_login
                    ]);
                  
                 }else{
                    $run = $request->run_usuario;
                    $run = str_replace('.', '', $run);
                    $run = strtoupper($run);

                    Users::where('id',$request->id)
                    ->update([
                        'run' => $run,
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

                    DB::table('tbl_permiso_usuarios')
                    ->updateOrInsert([
                        'run_usuario' => $run,
                        'permiso_usuario' => $request->permiso_usuario,
                        'estado_login' =>  $request->estado_login
                    ]);
                }
             }else{
                 if($idvalmail == 1){
                    Users::where('id',$request->id)
                    ->update([
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
                 }else{
                    Users::where('id',$request->id)
                    ->update([
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
               }
            }
        
         return true;
        } catch (\Throwable $th) {
            return false;
        }

    }

    public function registrarUsuarioSub(Request $request){
        try {
            $idvalrun = $request->idvalRut;
            $idvalmail = $request->idvalmail;
         if($idvalrun == 1){
            if($idvalmail == 1){
                $run = $request->run_usuario;
                $run = str_replace('.', '', $run);
                $run = strtoupper($run); 
       
                Users::create([
                   'run' =>  $request->run_usuario,
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
       
                 tblPermisoUsuarios::create([
                   'run_usuario' => $run,
                   'permiso_usuario' => $request->permiso_usuario,
                   'estado_login' =>  $request->estado_login
                ]); 
             }else{
                $run = $request->run_usuario;
                $run = str_replace('.', '', $run);
                $run = strtoupper($run); 
       
                Users::create([
                   'run' =>  $request->run_usuario,
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
       
                 tblPermisoUsuarios::create([
                   'run_usuario' => $run,
                   'permiso_usuario' => $request->permiso_usuario,
                   'estado_login' =>  $request->estado_login
                ]); 
            }
         }else{
             if($idvalmail == 1){
                Users::create([
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
             }else{
                Users::create([
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
             }
         }   
        return true;
        } catch (\Throwable $th) {
            return false;
        }
        

        
    }

    public function modificarUsuarioSub(Request $request){
        try {
            $idvalrun = $request->idvalRut;
            $idvalmail = $request->idvalmail;
            if($idvalrun == 1){
                if($idvalmail == 1){
                    $run = $request->run_usuario;
                    $run = str_replace('.', '', $run);
                    $run = strtoupper($run);

                    Users::where('id',$request->id)
                    ->update([
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

                    DB::table('tbl_permiso_usuarios')
                    ->updateOrInsert([
                        'run_usuario' => $run,
                        'permiso_usuario' => $request->permiso_usuario,
                        'estado_login' =>  $request->estado_login
                    ]);
                  
                 }else{
                    $run = $request->run_usuario;
                    $run = str_replace('.', '', $run);
                    $run = strtoupper($run);

                    Users::where('id',$request->id)
                    ->update([
                        'run' => $run,
                        //'email' => $request->email,
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

                    DB::table('tbl_permiso_usuarios')
                    ->updateOrInsert([
                        'run_usuario' => $run,
                        'permiso_usuario' => $request->permiso_usuario,
                        'estado_login' =>  $request->estado_login
                    ]);
                }
             }else{
                 if($idvalmail == 1){
                        Users::where('id',$request->id)
                        ->update([
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
                 }else{
                    Users::where('id',$request->id)
                    ->update([
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
               }
            }
        return true;

    } catch (\Throwable $th) {
        return false;
    }
    }

    public function registrarSupervisor(Request $request){
        try {
            $idvalrun = $request->idvalRut;
            $idvalmail = $request->idvalmail;
            $idSup = 0;
            if($idvalrun == 1){
                if($idvalmail == 1){
                    $run = $request->run_usuario;
                    $run = str_replace('.', '', $run);
                    $run = strtoupper($run);

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

                    $idSup = Supervisores::create([
                        'sup_run' => $run,
                        'sup_nombre' => $request->nombre,
                        'sup_apellido' => $request->apellido,
                        'id_especialidad1' =>$request->id_especialidad1,
                        'id_especialidad2' =>$request->id_especialidad2,
                    ])->id;

                    SupCatIntermedias::create([
                        'id_supervisor' => $idSup,
                        'id_categoria' => $request->id_categoria,
                    ]);

                    tblPermisoUsuarios::create([
                        'run_usuario' => $run,
                        'permiso_usuario' => $request->permiso_usuario,
                        'estado_login' =>  $request->estado_login
                    ]);
                            
                 }else{
                    $run = $request->run_usuario;
                    $run = str_replace('.', '', $run);
                    $run = strtoupper($run);

                    Users::create([
                        'run' => $run,
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

                    $idSup = Supervisores::create([
                        'sup_run' => $run,
                        'sup_nombre' => $request->nombre,
                        'sup_apellido' => $request->apellido,
                        'id_especialidad1' =>$request->id_especialidad1,
                        'id_especialidad2' =>$request->id_especialidad2,
                    ])->id;

                    SupCatIntermedias::create([
                        'id_supervisor' => $idSup,
                        'id_categoria' => $request->id_categoria,
                    ]);

                    tblPermisoUsuarios::create([
                        'run_usuario' => $run,
                        'permiso_usuario' => $request->permiso_usuario,
                        'estado_login' =>  $request->estado_login
                    ]);
                
                }
             }else{
                 if($idvalmail == 1){
                    Users::create([
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
            
                    $idSup = Supervisores::create([
                        'sup_nombre' => $request->nombre,
                        'sup_apellido' => $request->apellido,
                        'id_especialidad1' =>$request->id_especialidad1,
                        'id_especialidad2' =>$request->id_especialidad2,
                    ])->id;

                    SupCatIntermedias::create([
                        'id_supervisor' => $idSup,
                        'id_categoria' => $request->id_categoria,
                    ]);
                 }else{
                    Users::create([
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
            
                    $idSup = Supervisores::create([
                        'sup_nombre' => $request->nombre,
                        'sup_apellido' => $request->apellido,
                        'id_especialidad1' =>$request->id_especialidad1,
                        'id_especialidad2' =>$request->id_especialidad2,
                    ])->id;

                    SupCatIntermedias::create([
                        'id_supervisor' => $idSup,
                        'id_categoria' => $request->id_categoria,
                    ]);
               }
            }
            

        return true;

        } catch (\Throwable $th) {
            return false;
        }
    }

    public function modificarSupervisor(Request $request){
        try {
            $idvalrun = $request->idvalRut;
            $idvalmail = $request->idvalmail;
            if($idvalrun == 1){
                if($idvalmail == 1){
                    
                    $run = $request->run_usuario;
                    $run = str_replace('.', '', $run);
                    $run = strtoupper($run);
            
                    $resp = Users::where('id',$request->id)
                    ->update([
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
            
                    Supervisores::where('sup_run',$run)
                    ->update([
                        'sup_nombre' => $request->nombre,
                        'sup_apellido' => $request->apellido,
                        'id_especialidad1' =>$request->id_especialidad1,
                        'id_especialidad2' =>$request->id_especialidad2,
                    ]);

                    SupCatIntermedias::where('id_supervisor',$request->idSup)
                    ->update([
                        'id_categoria' => $request->id_categoria,
                    ]);
            
                    tblPermisoUsuarios::where('run_usuario',$run)
                    ->update([
                        'permiso_usuario' => $request->permiso_usuario,
                        'estado_login' =>  $request->estado_login
                    ]);
                  
                 }else{
                    $run = $request->run_usuario;
                    $run = str_replace('.', '', $run);
                    $run = strtoupper($run);

                    Users::where('id',$request->id)
                    ->update([
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

                    Supervisores::where('sup_run',$run)
                    ->update([
                        'sup_nombre' => $request->nombre,
                        'sup_apellido' => $request->apellido,
                        'id_especialidad1' =>$request->id_especialidad1,
                        'id_especialidad2' =>$request->id_especialidad2,
                    ]);

                    SupCatIntermedias::where('id_supervisor',$request->idSup)
                    ->update([
                        'id_categoria' => $request->id_especialidad1,
                    ]);

                    tblPermisoUsuarios::where('run_usuario',$run)
                    ->update([
                        'permiso_usuario' => $request->permiso_usuario,
                        'estado_login' =>  $request->estado_login
                    ]);
                
                }
             }else{
                 if($idvalmail == 1){
                    Users::where('id',$request->id)
                    ->update([
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

                    Supervisores::where('sup_run',$run)
                    ->update([
                        'sup_nombre' => $request->nombre,
                        'sup_apellido' => $request->apellido,
                        'id_especialidad1' =>$request->id_especialidad1,
                        'id_especialidad2' =>$request->id_especialidad2,
                    ]);

                    SupCatIntermedias::where('id_supervisor',$request->idSup)
                    ->update([
                        'id_categoria' => $request->id_especialidad1,
                    ]);
                 }else{
                    Users::where('id',$request->id)
                    ->update([
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

                    Supervisores::where('sup_run',$run)
                    ->update([
                        'sup_nombre' => $request->nombre,
                        'sup_apellido' => $request->apellido,
                        'id_especialidad1' =>$request->id_especialidad1,
                        'id_especialidad2' =>$request->id_especialidad2,
                    ]);

                    SupCatIntermedias::where('id_supervisor',$request->idSup)
                    ->update([
                        'id_categoria' => $request->id_especialidad1,
                    ]);
               }
            }    
        

        return true;
    } catch (\Throwable $th) {
       return false;
    }
        
    }

    public function registrarTrabajador(Request $request){
        try {
            $idvalrun = $request->idvalRut;
            $idvalmail = $request->idvalmail;
            $run = $request->run_usuario;
            $run = str_replace('.', '', $run);
            $run = strtoupper($run);
         if($idvalrun == 1){
            if($idvalmail == 1){
                $run = $request->run_usuario;
                $run = str_replace('.', '', $run);
                $run = strtoupper($run);
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

                $response = Trabajadores::create([
                    'tra_run' => $run,
                    'tra_nombre' => $request->nombre,
                    'tra_apellido' => $request->apellido,
                    'id_especialidad1' => $request->id_especialidad1,
                ]);

                tblPermisoUsuarios::create([
                    'run_usuario' => $run,
                    'permiso_usuario' => $request->permiso_usuario,
                    'estado_login' =>  $request->estado_login
                ]);

                tra_sups::create([
                    'id_trabajador' => $response->id,
                    'id_supervisor' => $request->idSupervisor
                ]);

            }else{
                $run = $request->run_usuario;
                $run = str_replace('.', '', $run);
                $run = strtoupper($run);
                Users::create([
                    'run' => $run,
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

                $response = Trabajadores::create([
                    'tra_run' => $run,
                    'tra_nombre' => $request->nombre,
                    'tra_apellido' => $request->apellido,
                    'id_especialidad1' => $request->id_especialidad1,
                ]);

                tblPermisoUsuarios::create([
                    'run_usuario' => $run,
                    'permiso_usuario' => $request->permiso_usuario,
                    'estado_login' =>  $request->estado_login
                ]);

                tra_sups::create([
                    'id_trabajador' => $response->id,
                    'id_supervisor' => $request->idSupervisor
                ]);
            }
         }else{
             if($idvalmail == 1){
                Users::create([
                    'run' => null,
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

                $response = Trabajadores::create([
                    'tra_run' => null,
                    'tra_nombre' => $request->nombre,
                    'tra_apellido' => $request->apellido,
                    'id_especialidad1' => $request->id_especialidad1,
                ]);

                tra_sups::create([
                    'id_trabajador' => $response->id,
                    'id_supervisor' => $request->idSupervisor
                ]);
             }else{
                Users::create([
                    'run' => null,
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

                $response = Trabajadores::create([
                    'tra_run' => null,
                    'tra_nombre' => $request->nombre,
                    'tra_apellido' => $request->apellido,
                    'id_especialidad1' => $request->id_especialidad1,
                ]);

                tra_sups::create([
                    'id_trabajador' => $response->id,
                    'id_supervisor' => $request->idSupervisor
                ]);
              }
            }   
        return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
            
        }
    }

    public function modificarTrabajador(Request $request){
        try {
            $idvalrun = $request->idvalRut;
            $idvalmail = $request->idvalmail;
            if($idvalrun == 1){
                if($idvalmail == 1){
                    $run = $request->run_usuario;
                    $run = str_replace('.', '', $run);
                    $run = strtoupper($run);

                    Users::where('id',$request->id_user)
                    ->update([
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

                    Trabajadores::where('tra_run',$run)
                    ->update([
                        'tra_nombre' => $request->nombre,
                        'tra_apellido' => $request->apellido,
                        'id_especialidad1' => $request->id_especialidad1,
                    ]);

                    tra_sups::UpdateOrCreate([
                        'id_trabajador' => $request->id_trabajador,
                        'id_supervisor' => $request->idSupervisor
                    ]);

                    tblPermisoUsuarios::where('run_usuario',$run)
                    ->update([
                        'permiso_usuario' => $request->permiso_usuario,
                        'estado_login' =>  $request->estado_login
                    ]);
                  
                 }else{
                    $run = $request->run_usuario;
                    $run = str_replace('.', '', $run);
                    $run = strtoupper($run);

                    Users::where('id',$request->id_user)
                    ->update([
                        'run' => $run,
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

                    Trabajadores::where('tra_run',$run)
                    ->update([
                        'tra_nombre' => $request->nombre,
                        'tra_apellido' => $request->apellido,
                        'id_especialidad1' => $request->id_especialidad1,
                    ]);

                    tra_sups::UpdateOrCreate([
                        'id_trabajador' => $request->id_trabajador,
                        'id_supervisor' => $request->idSupervisor
                    ]);

                    tblPermisoUsuarios::where('run_usuario',$run)
                    ->update([
                        'permiso_usuario' => $request->permiso_usuario,
                        'estado_login' =>  $request->estado_login
                    ]);
                }
             }else{
                 if($idvalmail == 1){
                    Users::where('id',$request->id_user)
                    ->update([
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

                    Trabajadores::where('tra_run',$run)
                    ->update([
                        'tra_nombre' => $request->nombre,
                        'tra_apellido' => $request->apellido,
                        'id_especialidad1' => $request->id_especialidad1,
                    ]);

                    tra_sups::UpdateOrCreate([
                        'id_trabajador' => $request->id_trabajador,
                        'id_supervisor' => $request->idSupervisor
                    ]);
                    
                 }else{
                    Users::where('id',$request->id_user)
                    ->update([
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

                    Trabajadores::where('tra_run',$run)
                    ->update([
                        'tra_nombre' => $request->nombre,
                        'tra_apellido' => $request->apellido,
                        'id_especialidad1' => $request->id_especialidad1,
                    ]);

                    tra_sups::UpdateOrCreate([
                        'id_trabajador' => $request->id_trabajador,
                        'id_supervisor' => $request->idSupervisor
                    ]);
               }
            }
        return true;

    } catch (\Throwable $th) {
        return false;
    }  
    }

    public function getSoloSupervisoresRRFF()
    {
        $getall = Users::select('users.*','users.id as id_user','supervisores.*',DB::raw("CONCAT(users.nombre,' ',users.apellido) as nombreSupervisor"),
        'sup_cat_intermedias.id_supervisor','sup_cat_intermedias.id_categoria')
        ->join('supervisores','users.run','=','supervisores.sup_run')
        ->join('sup_cat_intermedias','supervisores.id','=','sup_cat_intermedias.id_supervisor')
        ->where('id_cargo',[5])
        ->get();
         return $getall;
    }

    public function getSoloTrabajadoresRRFF(){
        $get_all = Users::select('users.*','users.id as id_user','trabajadores.*',DB::raw("CONCAT(users.nombre,' ',users.apellido) as nombreTrabajador"))
        ->join('trabajadores','users.run','=','trabajadores.tra_run')
        ->where('id_cargo',[6])
        ->get();
        return $get_all;
    }

    public function getSoloJefatura(){
        $get_all = Users::select('users.*',DB::raw("CONCAT(users.nombre,' ',users.apellido) as nombreUsuario"))
        ->where('id_cargo',[1])
        ->get();
        return $get_all;
    }

    public function getSoloSubrogantes(){
        $get_all = Users::select('users.*',DB::raw("CONCAT(users.nombre,' ',users.apellido) as nombreUsuario"))
        ->whereNotIn('id_cargo',[1])
        ->whereNotIn('id_cargo',[5])
        ->whereNotIn('id_cargo',[6])
        ->get();
        return $get_all;
    }

    public function GetUsuariosPermisos(){
        try {
            $get_all = Users::select('users.run',DB::raw("CONCAT(users.nombre,' ',users.apellido) as nombreUsuario"),
            'cargo_usuarios.descripcionCargo','tbl_permiso_usuarios.id','tbl_permiso_usuarios.estado_login',DB::raw("(CASE tbl_permiso_usuarios.estado_login
            WHEN 1 THEN 'Activo'
            ELSE 'Desabilitado'
            end) AS estadoUsuario"))
            ->join('tbl_permiso_usuarios','users.run', '=', 'tbl_permiso_usuarios.run_usuario')
            ->join('cargo_usuarios','users.id_cargo', '=', 'cargo_usuarios.id')
            ->get();
            return $get_all;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PutDesabilitarHabilitarUsuario(Request $request){
        try {
             $res = tblPermisoUsuarios::where('id',$request->idPermiso)
             ->update([
               'estado_login' => $request->estado_login
              ]);
              return $res;
        } catch (\Throwable $th) {
            return false;
        }
    }
}
