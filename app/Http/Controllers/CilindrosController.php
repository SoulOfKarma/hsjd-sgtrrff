<?php

namespace App\Http\Controllers;

use App\cilindros;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use DB;

class CilindrosController extends Controller
{
    public function GetCilindros(){
        try {
            $get_all = cilindros::all();
            return $get_all;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PostCilindros(Request $request){
      try {
          cilindros::create($request->all());
          return true;
      } catch (\Throwable $th) {
          log::info($th);
          return false;
      }
    }
}
