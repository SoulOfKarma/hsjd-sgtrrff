<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Turno;

class TurnoController extends Controller
{
    public function index()
    {
        $get_all = Turno::all();

        return  $get_all;
        //
    }

    public function getTurnoSL(){
        $get_all = Turno::select("*")
        ->where('id','=',1) 
        ->orWhere('id','=',2)
        ->get();
        return $get_all;
    }
}
