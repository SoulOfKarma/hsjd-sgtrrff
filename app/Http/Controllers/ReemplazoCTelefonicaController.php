<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\ReemplazoCTelefonicas;

class ReemplazoCTelefonicaController extends Controller
{
    public function get_reemplazo(){
        $get_all = ReemplazoCTelefonicas::all();
        return $get_all;
    }
}
