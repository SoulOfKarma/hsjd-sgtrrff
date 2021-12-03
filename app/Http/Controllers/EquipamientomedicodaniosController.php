<?php

namespace App\Http\Controllers;

use App\equipamientomedicodanios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use DB;

class EquipamientomedicodaniosController extends Controller
{
    public function GetListadoDanio(){
        try {
            $get_all = equipamientomedicodanios::all();
            return $get_all;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
}
