<?php

namespace App\Http\Controllers;

use App\Vacacionestindustrials;
use Illuminate\Http\Request;

class VacacionestindustrialsController extends Controller
{
    public function get_vacaciones(){
        $get_all = Vacacionestindustrials::all();
        return $get_all;
    }
}
