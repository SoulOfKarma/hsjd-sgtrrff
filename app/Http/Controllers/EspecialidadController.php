<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\especialidades;
use DB;

class EspecialidadController extends Controller
{
    public function index()
    {
        //$dataFiltro = [1];
        $get_all = especialidades::select('especialidades.*')
        //->whereNotIn('id',$dataFiltro)
        ->get();
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
