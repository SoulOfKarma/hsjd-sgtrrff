<?php

namespace App\Http\Controllers;

use App\calendarioanios;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;

class CalendarioaniosController extends Controller
{
    public function GetAnio(){
        try {
            $get_all = calendarioanios::all();
            return $get_all;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PostAnio(Request $request){
      try {
          calendarioanios::create($request->all());
          return true;
      } catch (\Throwable $th) {
          log::info($th);
          return false;
      }
    }
}
