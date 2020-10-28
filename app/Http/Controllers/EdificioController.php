<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Edificios;
use DB;

class EdificioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $get_all = Edificios::all();

        return  $get_all;

        //Retorna Todo del listado de Edificios

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        Edificios::create($request->all());

        return true;
    }

    public function modificarEdificio(Request $request){
        Edificios::where('id',$request->id)
        ->update(['descripcionEdificio' => $request->descripcionEdificio]);

        return true;
    }
}
