<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\LoginCollection;
use App\Login;
use DB;
use Illuminate\Support\Facades\Hash;
use App\permiso_usuario;
use SebastianBergmann\Environment\Console;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Users;

class LoginController extends Controller
{

  public function getUsuarios(Request $request)
  {
    
    $rut = str_replace('.', '', $request->input('rut'));
    $rut = strtoupper($rut);
    $token = Str::random(60);

        Users::where('run',$rut)
        ->update(['api_token' => $token]);
    $get_all = DB::table('users')
      ->where('run', '=', $rut)
      ->get();
      $hashedPassword = "";
      foreach ($get_all as $p) {
        $hashedPassword = $p->password;
        if(Hash::check($request->input('pasword'), $hashedPassword)){
        return $get_all;
        }  
        else{
        return 1;
       }
      }
  }

  public function GetUsersByToken(Request $request)
  {
    
    $rut = str_replace('.', '', $request->input('rut'));
    $rut = strtoupper($rut);
    $get_all = DB::table('users')
      ->where('run', '=', $rut)
      ->get();
      $tokenBD = "";
      foreach ($get_all as $p) {
        $tokenBD = $p->api_token;
        if($request->input('token') == $tokenBD){
        return $get_all;
        }  
        else{
        return 1;
       }
      }
  }

  public function adminPr(Request $request)
  {
    $run = str_replace('.', '', $request->input('rut'));
    $run = strtoupper($run);
    $salida = DB::table('tbl_permiso_usuarios')
      ->where('run_usuario', '=', $run)
      ->get(['run_usuario', 'permiso_usuario', 'estado_login']);
    foreach ($salida as $p) {
      if ($p->estado_login == 1) {
        $request->session()->put('login', '1');
        $request->session()->put('run_usuario', $request->input('rut'));
        $request->session()->put('permiso_usuario', $p->permiso_usuario);
      }
    }
    return $salida;
  }

  public function salir(Request $request)
  {
    $request->session()->forget('login');
    $request->session()->forget('run_usuario');
    $request->session()->forget('permiso_usuario');
    $request->session()->flush();
  }
}
