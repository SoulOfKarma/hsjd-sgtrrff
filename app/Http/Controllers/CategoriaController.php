<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\categoria;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $getall = categoria::all();

        return $getall;
    }

    public function getCategoriaSI()
    {
        $getall = categoria::select("*")
        ->where("id","!=",5)
        ->get();

        return $getall;
    }

    
}
