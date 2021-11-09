<?php

namespace App\Http\Controllers;

use App\equipamientoMedicos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use DB;

class EquipamientoMedicosController extends Controller
{
    public function PostEquipamientoNuevo(Request $request){
        try {
            equipamientoMedicos::create($request->all());
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function GetTodoEquipamientoMedico(){
        try {
            $get_all = equipamientoMedicos::all();
            return $get_all;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
}
