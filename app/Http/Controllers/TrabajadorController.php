<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Trabajadores;
use DB;

class TrabajadorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Traer todo de trabajadores
        $get_all = Trabajadores::select('trabajadores.id',DB::raw("CONCAT(trabajadores.tra_nombre,' ',trabajadores.tra_apellido) as tra_nombre_apellido"),'trabajadores.especialidad')
        ->get();

        return  $get_all;
    }


    public function GetTrabajadoresEX()
    {
        //Traer todo de trabajadores
        $get_all = Trabajadores::select('trabajadores.*')
            ->where('id', '!=', 999)
            ->get();

        return  $get_all;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
