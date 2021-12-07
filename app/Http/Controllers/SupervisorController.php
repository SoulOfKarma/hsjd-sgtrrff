<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Supervisores;
use Illuminate\Support\Facades\Log;
use DB;

class SupervisorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Traer todo de supervisores
        $get_all = Supervisores::select('supervisores.id',DB::raw("CONCAT(supervisores.sup_nombre,' ',supervisores.sup_apellido) as sup_nombre_apellido"),'supervisores.id_especialidad1')
        /* ->join('tbl_permiso_usuarios','supervisores.sup_run', '=', 'tbl_permiso_usuarios.run_usuario')
        ->whereNotIn('supervisores.id_especialidad1',[23])
        ->whereNotIn('supervisores.id_especialidad2',[23])
        ->whereNotIn('tbl_permiso_usuarios.estado_login',[0]) */
        ->get();
        return  $get_all;
        
    }

}
