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
use Illuminate\Support\Facades\Auth;
use App\Users;
use Carbon\Carbon;
use Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class LoginController extends Controller
{

  public function getUsuarios(Request $request)
  {
    
    $rut = str_replace('.', '', $request->input('run'));
    $rut = strtoupper($rut);
    $token = Str::random(60);

        Users::where('run',$rut)
        ->update(['api_token' => $token]);
    $get_all = DB::table('users')
      ->where('run', '=', $rut)
      ->get();
      $hashedPassword = "";

      Users::where('run',$rut)
        ->update(['api_token' => Hash::make($token)]);

      foreach ($get_all as $p) {
        $hashedPassword = $p->password;
        if(Hash::check($request->input('password'), $hashedPassword)){
        return $get_all;
        
        }  
        else{
        return 1;
       }
      }
  }

/*   public function GetUsersByToken(Request $request)
  {
    
    $rut = str_replace('.', '', $request->input('rut'));
    $rut = strtoupper($rut);
    $get_all = DB::table('users')
      ->where('run', '=', $rut)
      ->get();

      Users::where('run',$rut)
        ->update(['api_token' => Hash::make($request->input('token'))]);
      $tokenBD = "";
      foreach ($get_all as $p) {
        $tokenBD = $p->api_token;
       // if($request->input('token') == $tokenBD){
        if(Hash::check($request->input('token'), $tokenBD)){
        return $get_all;
        }  
        else{
        return 1;
       }
      }
  } */

  public function GetUsersByExternalRut(Request $request)
  {
    
    $rut = str_replace('.', '', $request->input('run'));
    $rut = strtoupper($rut);
    $token = Str::random(60);
    Users::where('run',$rut)
    ->update(['api_token' => Hash::make($token)]);
    $get_all = DB::table('users')
      ->where('run', '=', $rut)
      ->get();
     
        return $get_all;
       
      
  }

  public function generarToken(Request $request)
  {

    $request->validate([
      'run' => 'required|string',
      'password' => 'required|string'
    ]);
     
      $credentials = request(['run', 'password']);
  
        if (! $token = JWTAuth::attempt($credentials)) {
          
            return response()->json(['error' => 'invalid_credentials'], 400);
        }

      return response()->json(compact('token'));
      
  }

  public function adminPr(Request $request)
  {
    $run = str_replace('.', '', $request->input('run'));
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
    $request->session()->forget('token');
    $request->session()->flush();
    

    return response()->json([
        'message' => 'Successfully logged out'
    ]);
  }

  public function login(Request $request)
  {

    $request->validate([
      'run' => 'required|string',
      'password' => 'required|string'
    ]);
     
      $credentials = request(['run', 'password']);
  
        if (! $token = JWTAuth::attempt($credentials)) {
          
            return response()->json(['error' => 'invalid_credentials'], 400);
        }

      return response()->json(compact('token'));
    
  }

  public function getAuthenticatedUser()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                    return response()->json(['user_not_found'], 404);
            }
            } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
                    return response()->json(['token_expired'], $e->getStatusCode());
            } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
                    return response()->json(['token_invalid'], $e->getStatusCode());
            } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
                    return response()->json(['token_absent'], $e->getStatusCode());
            }
            return response()->json(compact('user'));
    }
}
