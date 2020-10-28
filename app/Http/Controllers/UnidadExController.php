<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UnidadEsps;
use DB;

class UnidadExController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $get_all = UnidadEsps::all();

        return  $get_all;
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        UnidadEsps::create($request->all());
        return true;
    }

    public function modificarUnidadEspecifica(Request $request){
        UnidadEsps::where('id',$request->id)
        ->update(['descripcionUnidadEsp' => $request->descripcionUnidadEsp]);

        return true;
    }

  
}
