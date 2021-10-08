<?php

namespace App\Http\Controllers;

use App\estadoCodMIndustriales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use DB;

class EstadoCodMIndustrialesController extends Controller
{
    public function PostEstadoCodMInd(Request $request){
       try {
           estadoCodMIndustriales::create($request->all());
           return true;
       } catch (\Throwable $th) {
           log::info($th);
           return false;
       }
    }

    public function GetEstadoCodMInd(){
        try {
            $get_all = estadoCodMIndustriales::all();
            return $get_all;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
     }
}
