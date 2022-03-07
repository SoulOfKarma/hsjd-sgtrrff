<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                //$refreshed = JWTAuth::parseToken()->refresh();
                return response()->json(['success'=> false,'status' => 'expired'],401);
                //return response()->json(['success'=> false,'token'=>$refreshed,'status' => 'expired'],401);
                
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return response()->json(['success'=> false,'status' => 'Token is Invalid'],401);
            }else{
                log::info($e);
                return response()->json(['success'=> false,'status' => 'Authorization Token not found'],401);
            }
        }
        return $next($request);
    }
}
