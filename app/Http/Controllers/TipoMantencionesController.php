<?php

namespace App\Http\Controllers;

use App\tipoMantenciones;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;

class TipoMantencionesController extends Controller
{

    public function GetTipoMantenciones(){
        try {
            $get_all = tipoMantenciones::all();
            return $get_all;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
    public function PostTMantencion(Request $request){
      try {
        tipoMantenciones::create($request->all());
        return true;
      } catch (\Throwable $th) {
          log::info($th);
          return false;
      }
    }
}
