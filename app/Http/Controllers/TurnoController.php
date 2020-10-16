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
}
