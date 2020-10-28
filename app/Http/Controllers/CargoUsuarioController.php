<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\cargoUsuario;
use DB;

class CargoUsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $getall = cargoUsuario::all();
        return $getall;
    }

    public function getCargoNoJefatura()
    {
        $getall = cargoUsuario::select('cargo_Usuarios.*')
        ->whereNotIn('id',[1])
        ->whereNotIn('id',[5])
        ->whereNotIn('id',[6])
        ->get();
        return $getall;
    }

    public function create(Request $request)
    {
         cargoUsuario::create($request->all());
         return true;
    }

    public function modificarCargo(Request $request){
        cargoUsuario::where('id',$request->id)
        ->update(['descripcionCargo' => $request->descripcionCargo]);

        return true;
    }
}
