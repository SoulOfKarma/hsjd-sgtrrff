<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\especialidades;
use DB;

class EspecialidadController extends Controller
{
    public function index()
    {
        $get_all = especialidades::all();

        return  $get_all;
    }

    public function agregarEspecialidad(Request $request){
        especialidades::create($request->all());

        return true;
    }

    public function modificarEspecialidad(Request $request){ 
        especialidades::where('id',$request->id)
        ->update(['descripcionEspecialidad' => $request->descripcionEspecialidad]);
        return true;
    }
}
