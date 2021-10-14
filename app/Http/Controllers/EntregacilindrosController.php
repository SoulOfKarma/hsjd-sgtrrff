<?php

namespace App\Http\Controllers;

use App\Entregacilindros;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use DB;

class EntregacilindrosController extends Controller
{
    public function PostECilindros(Request $request){
       try {
           Entregacilindros::create($request->all());
           return true;
       } catch (\Throwable $th) {
           log::info($th);
           return false;
       }
    } 
}
