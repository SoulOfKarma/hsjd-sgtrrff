<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Servicios;
use DB;
use Illuminate\Support\Facades\Log;

class ServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $get_all = Servicios::all();

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
        Servicios::create($request->all());

        return true;
    }

    
    public function modificarServicio(Request $request)
    {
    
        Servicios::where('id',$request->id)
        ->update(['descripcionServicio' => $request->descripcionServicio,'id_edificio' => $request->id_edificio]);

        return true;
    }
}
