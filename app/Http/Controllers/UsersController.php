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
       
                 tblPermisoUsuarios::create([
                   'run_usuario' => $run,
                   'permiso_usuario' => $request->permiso_usuario,
                   'estado_login' =>  $request->estado_login
                ]); 
            }
         }else{
             if($idvalmail == 1){
                /* $run = $request->run_usuario;
                $run = str_replace('.', '', $run);
                $run = strtoupper($run);  */
       
                Users::create([
                   //'run' =>  $request->run_usuario,
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
                /* $run = $request->run_usuario;
                $run = str_replace('.', '', $run);
                $run = strtoupper($run);  */
       
                Users::create([
                   //'run' =>  $request->run_usuario,
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
            log::info($idvalrun);
            log::info($idvalmail);
            if($idvalrun == 1){
                if($idvalmail == 1){
                    log::info("Aca weon");
                    $run = $request->run_usuario;
                    $run = str_replace('.', '', $run);
                    $run = strtoupper($run);
                    log::info($run);
                    log::info($request);
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
                   /*  $run = $request->run_usuario;
                    $run = str_replace('.', '', $run);
                    $run = strtoupper($run); */

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

                    /* DB::table('tbl_permiso_usuarios')
                    ->updateOrInsert([
                        'run_usuario' => $run,
                        'permiso_usuario' => $request->permiso_usuario,
                        'estado_login' =>  $request->estado_login
                    ]); */
                    
                 }else{
                    Users::where('id',$request->id)
                    ->update([
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
       
                 tblPermisoUsuarios::create([
                   'run_usuario' => $run,
                   'permiso_usuario' => $request->permiso_usuario,
                   'estado_login' =>  $request->estado_login
                ]); 
            }
         }else{
             if($idvalmail == 1){
                /* $run = $request->run_usuario;
                $run = str_replace('.', '', $run);
                $run = strtoupper($run);  */
       
                Users::create([
                   //'run' =>  $request->run_usuario,
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
                /* $run = $request->run_usuario;
                $run = str_replace('.', '', $run);
                $run = strtoupper($run);  */
       
                Users::create([
                   //'run' =>  $request->run_usuario,
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
                   /*  $run = $request->run_usuario;
                    $run = str_replace('.', '', $run);
                    $run = strtoupper($run); */

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

                    /* DB::table('tbl_permiso_usuarios')
                    ->updateOrInsert([
                        'run_usuario' => $run,
                        'permiso_usuario' => $request->permiso_usuario,
                        'estado_login' =>  $request->estado_login
                    ]); */
                    
                 }else{
                    Users::where('id',$request->id)
                    ->update([
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

                    Supervisores::create([
                        'sup_run' => $run,
                        'sup_nombre' => $request->nombre,
                        'sup_apellido' => $request->apellido,
                        'id_especialidad1' =>$request->id_especialidad1,
                        'id_especialidad2' =>$request->id_especialidad2,
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

                    Supervisores::create([
                        'sup_run' => $run,
                        'sup_nombre' => $request->nombre,
                        'sup_apellido' => $request->apellido,
                        'id_especialidad1' =>$request->id_especialidad1,
                        'id_especialidad2' =>$request->id_especialidad2,
                    ]);

                    tblPermisoUsuarios::create([
                        'run_usuario' => $run,
                        'permiso_usuario' => $request->permiso_usuario,
                        'estado_login' =>  $request->estado_login
                    ]);
                
                }
             }else{
                 if($idvalmail == 1){
                    /* $run = $request->run_usuario;
                    $run = str_replace('.', '', $run);
                    $run = strtoupper($run); */
            
                    Users::create([
                        //'run' => $run,
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
            
                    Supervisores::create([
                        //'sup_run' => $run,
                        'sup_nombre' => $request->nombre,
                        'sup_apellido' => $request->apellido,
                        'id_especialidad1' =>$request->id_especialidad1,
                        'id_especialidad2' =>$request->id_especialidad2,
                    ]);
            
                    /* tblPermisoUsuarios::create([
                        'run_usuario' => $run,
                        'permiso_usuario' => $request->permiso_usuario,
                        'estado_login' =>  $request->estado_login
                    ]); */
                            
                    
                 }else{
                    /* $run = $request->run_usuario;
                    $run = str_replace('.', '', $run);
                    $run = strtoupper($run); */
            
                    Users::create([
                        //'run' => $run,
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
            
                    Supervisores::create([
                        //'sup_run' => $run,
                        'sup_nombre' => $request->nombre,
                        'sup_apellido' => $request->apellido,
                        'id_especialidad1' =>$request->id_especialidad1,
                        'id_especialidad2' =>$request->id_especialidad2,
                    ]);
            
                    /* tblPermisoUsuarios::create([
                        'run_usuario' => $run,
                        'permiso_usuario' => $request->permiso_usuario,
                        'estado_login' =>  $request->estado_login
                    ]); */
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

                    Supervisores::where('sup_run',$run)
                    ->update([
                        'sup_nombre' => $request->nombre,
                        'sup_apellido' => $request->apellido,
                        'id_especialidad1' =>$request->id_especialidad1,
                        'id_especialidad2' =>$request->id_especialidad2,
                    ]);

                    tblPermisoUsuarios::where('run_usuario',$run)
                    ->update([
                        'permiso_usuario' => $request->permiso_usuario,
                        'estado_login' =>  $request->estado_login
                    ]);
                
                }
             }else{
                 if($idvalmail == 1){
                    /* $run = $request->run_usuario;
                    $run = str_replace('.', '', $run);
                    $run = strtoupper($run); */

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

                    /* tblPermisoUsuarios::where('run_usuario',$run)
                    ->update([
                        'permiso_usuario' => $request->permiso_usuario,
                        'estado_login' =>  $request->estado_login
                    ]); */
                            
                    
                 }else{
                    /* $run = $request->run_usuario;
                    $run = str_replace('.', '', $run);
                    $run = strtoupper($run); */

                    Users::where('id',$request->id)
                    ->update([
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

                    Supervisores::where('sup_run',$run)
                    ->update([
                        'sup_nombre' => $request->nombre,
                        'sup_apellido' => $request->apellido,
                        'id_especialidad1' =>$request->id_especialidad1,
                        'id_especialidad2' =>$request->id_especialidad2,
                    ]);

                    /* tblPermisoUsuarios::where('run_usuario',$run)
                    ->update([
                        'permiso_usuario' => $request->permiso_usuario,
                        'estado_login' =>  $request->estado_login
                    ]); */
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

                Trabajadores::create([
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

            }else{
                $run = $request->run_usuario;
                $run = str_replace('.', '', $run);
                $run = strtoupper($run);

                Users::create([
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

                Trabajadores::create([
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
            }
         }else{
             if($idvalmail == 1){
                /* $run = $request->run_usuario;
                $run = str_replace('.', '', $run);
                $run = strtoupper($run); */

                Users::create([
                    //'run' => $run,
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

                Trabajadores::create([
                    'tra_run' => $run,
                    'tra_nombre' => $request->nombre,
                    'tra_apellido' => $request->apellido,
                    'id_especialidad1' => $request->id_especialidad1,
                ]);

                /* tblPermisoUsuarios::create([
                    'run_usuario' => $run,
                    'permiso_usuario' => $request->permiso_usuario,
                    'estado_login' =>  $request->estado_login
                ]); */
             }else{
                /* $run = $request->run_usuario;
                $run = str_replace('.', '', $run);
                $run = strtoupper($run); */

                Users::create([
                    //'run' => $run,
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

                Trabajadores::create([
                    'tra_run' => $run,
                    'tra_nombre' => $request->nombre,
                    'tra_apellido' => $request->apellido,
                    'id_especialidad1' => $request->id_especialidad1,
                ]);

                /* tblPermisoUsuarios::create([
                    'run_usuario' => $run,
                    'permiso_usuario' => $request->permiso_usuario,
                    'estado_login' =>  $request->estado_login
                ]); */
              }
            }   
        return true;
        } catch (\Throwable $th) {
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

                    Trabajadores::where('tra_run',$run)
                    ->update([
                        'tra_nombre' => $request->nombre,
                        'tra_apellido' => $request->apellido,
                        'id_especialidad1' => $request->id_especialidad1,
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

                    Trabajadores::where('tra_run',$run)
                    ->update([
                        'tra_nombre' => $request->nombre,
                        'tra_apellido' => $request->apellido,
                        'id_especialidad1' => $request->id_especialidad1,
                    ]);

                    tblPermisoUsuarios::where('run_usuario',$run)
                    ->update([
                        'permiso_usuario' => $request->permiso_usuario,
                        'estado_login' =>  $request->estado_login
                    ]);
                }
             }else{
                 if($idvalmail == 1){
                    /* $run = $request->run_usuario;
                    $run = str_replace('.', '', $run);
                    $run = strtoupper($run); */

                    Users::where('id',$request->id)
                    ->update([
                        //'run' => $run,
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

                   /*  tblPermisoUsuarios::where('run_usuario',$run)
                    ->update([
                        'permiso_usuario' => $request->permiso_usuario,
                        'estado_login' =>  $request->estado_login
                    ]); */
                    
                 }else{
                    /* $run = $request->run_usuario;
                    $run = str_replace('.', '', $run);
                    $run = strtoupper($run); */

                    Users::where('id',$request->id)
                    ->update([
                        //'run' => $run,
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

                    Trabajadores::where('tra_run',$run)
                    ->update([
                        'tra_nombre' => $request->nombre,
                        'tra_apellido' => $request->apellido,
                        'id_especialidad1' => $request->id_especialidad1,
                    ]);

                   /*  tblPermisoUsuarios::where('run_usuario',$run)
                    ->update([
                        'permiso_usuario' => $request->permiso_usuario,
                        'estado_login' =>  $request->estado_login
                    ]); */
               }
            }
        return true;

    } catch (\Throwable $th) {
        return false;
    }  
    }

    public function getSoloSupervisoresRRFF()
    {
        $getall = Users::select('Users.*','users.id as id_user','supervisores.*',DB::raw("CONCAT(Users.nombre,' ',Users.apellido) as nombreSupervisor"))
        ->join('supervisores','users.run','=','supervisores.sup_run')
        ->where('id_cargo',[5])
        ->get();
         return $getall;
    }

    public function getSoloTrabajadoresRRFF(){
        $get_all = Users::select('Users.*','trabajadores.*',DB::raw("CONCAT(Users.nombre,' ',Users.apellido) as nombreTrabajador"))
        ->join('trabajadores','users.run','=','trabajadores.tra_run')
        ->where('id_cargo',[6])
        ->get();
        return $get_all;
    }

    public function getSoloJefatura(){
        $get_all = Users::select('Users.*',DB::raw("CONCAT(Users.nombre,' ',Users.apellido) as nombreUsuario"))
        ->where('id_cargo',[1])
        ->get();
        return $get_all;
    }

    public function getSoloSubrogantes(){
        $get_all = Users::select('Users.*',DB::raw("CONCAT(Users.nombre,' ',Users.apellido) as nombreUsuario"))
        ->whereNotIn('id_cargo',[1])
        ->whereNotIn('id_cargo',[5])
        ->whereNotIn('id_cargo',[6])
        ->get();
        return $get_all;
    }
}
