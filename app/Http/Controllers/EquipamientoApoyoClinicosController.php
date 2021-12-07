<?php

namespace App\Http\Controllers;

use App\EquipamientoApoyoClinicos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use DB;

class EquipamientoApoyoClinicosController extends Controller
{
    public function PostEquipamientoApoyoClinico(Request $request){
        try {
            EquipamientoApoyoClinicos::create($request->all());
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function GetTodoEquipamientoApoyoClinico(){
        try {
            $get_all = EquipamientoApoyoClinicos::all();
            return $get_all;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PutEquipamientoApoyoClinico(Request $request){
        try {
            EquipamientoApoyoClinicos::where(
                'id',$request->id)
            //],[
                ->update([
                'equipo' => $request->equipo,
                'marca' => $request->marca,
                'modelo' => $request->modelo,
                'serie' => $request->serie,
                'ninventario' => $request->ninventario
            ]); 

            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
}
