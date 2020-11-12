<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;
use App\CalendarioAscensores;

class CalendarioAscensoresController extends Controller
{
    public function getTodoCalendario()
    {
        $getall = CalendarioAscensores::all();
        return $getall;
    }

    public function postNuevoTCalendario(Request $request){
        $res = CalendarioAscensores::create($request->all());

        return $res;
    }
}
