<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
        try {
            //Traer todo de trabajadores
            $get_all = Trabajadores::select('trabajadores.id',DB::raw("CONCAT(trabajadores.tra_nombre,' ',trabajadores.tra_apellido) as tra_nombre_apellido"),'trabajadores.id_especialidad1')
            ->leftJoin('tbl_permiso_usuarios','trabajadores.tra_run','=','tbl_permiso_usuarios.run_usuario')
            ->where('tbl_permiso_usuarios.estado_login',[1])
            ->orWhere('trabajadores.tra_run','00000000-0')
            ->orderBy('trabajadores.id','asc')
            ->get();

        return  $get_all;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
        
    }

    public function getTrabajadoresByRun($run)
    {
        try {
            //Traer todo de trabajadores
            $get_all = Trabajadores::select('trabajadores.id',DB::raw("CONCAT(trabajadores.tra_nombre,' ',trabajadores.tra_apellido) as tra_nombre_apellido"),'trabajadores.id_especialidad1')
            ->where('tra_run',$run)
            ->get();

        return  $get_all;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
        
    }


    public function GetTrabajadoresEX()
    {
        try {
            //Traer todo de trabajadores
            $get_all = Trabajadores::select('trabajadores.*',DB::raw("CONCAT(trabajadores.tra_nombre,' ',trabajadores.tra_apellido) as tra_nombre_apellido"))
            //->where('id', '!=', 1)
            ->get();

        return  $get_all;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
        
    }

    public function GetTrabajadoresEspAsc()
    {
        try {
            //Traer todo de trabajadores
            $get_all = Trabajadores::select('trabajadores.*',DB::raw("CONCAT(trabajadores.tra_nombre,' ',trabajadores.tra_apellido) as tra_nombre_apellido"))
            ->where('id_especialidad1', '=', 17)
            ->get();

            return  $get_all;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
        
    }

    public function GetTrabajadoresEspCTel()
    {
        try {
            //Traer todo de trabajadores
            $get_all = Trabajadores::select('trabajadores.*',DB::raw("CONCAT(trabajadores.tra_nombre,' ',trabajadores.tra_apellido) as tra_nombre_apellido"))
            ->where('id_especialidad1', '=', 18)
            ->get();

            return  $get_all;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
        
    }

}
