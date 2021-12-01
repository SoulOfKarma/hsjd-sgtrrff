<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EstadoSolicituds;
use DB;

class EstadoController extends Controller
{
    public function index()
    {
        //$dataFiltro1 = [1];
        //$dataFiltro2 = [7];
        //$dataFiltro3 = [6];
        $get_all = EstadoSolicituds::select('estado_solicituds.*')
        //->whereNotIn('id',$dataFiltro1)
        //->whereNotIn('id',$dataFiltro2)
        //->whereNotIn('id',$dataFiltro3)
        ->get();

        return  $get_all;
        //Traer todo de estados
    }

    public function EstadoAsignar()
    {
        $dataFiltro1 = [1];
        $dataFiltro2 = [7];
        $dataFiltro3 = [6];
        $dataFiltro4 = [9];
        $get_all = EstadoSolicituds::select('estado_solicituds.*')
        ->whereNotIn('id',$dataFiltro1)
        ->whereNotIn('id',$dataFiltro2)
        ->whereNotIn('id',$dataFiltro3)
        ->whereNotIn('id',$dataFiltro4)
        ->get();

        return  $get_all;
        //Traer todo de estados
    }

    
}
