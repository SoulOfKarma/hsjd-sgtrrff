<?php

namespace App\Http\Controllers;

use App\Reemplazotindustrials;
use Illuminate\Http\Request;

class ReemplazotindustrialsController extends Controller
{
    public function get_reemplazo(){
        $get_all = Reemplazotindustrials::all();
        return $get_all;
    }
}
