<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TipoReparacions;
use DB;

class TipoReparacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $get_all = TipoReparacions::all();

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
        TipoReparacions::create($request->all());
        return true;
    }

    public function modificarTipoReparacion(Request $request){
        TipoReparacions::where('id',$request->id)
        ->update(['descripcionTipoReparacion' => $request->descripcionTipoReparacion]);
        return true;
    }

    
}
