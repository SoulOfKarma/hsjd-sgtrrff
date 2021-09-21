<?php

namespace App\Http\Controllers;

use App\SupCatIntermedias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use DB;

class SupCatIntermediasController extends Controller
{
    public function GuardarSupCat(Request $request){
        try {
            SupCatIntermedias::create($request->all());
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
}
