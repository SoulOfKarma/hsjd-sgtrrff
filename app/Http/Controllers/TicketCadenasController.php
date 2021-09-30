<?php

namespace App\Http\Controllers;

use App\TicketCadenas;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;

class TicketCadenasController extends Controller
{
    public function BuscarExistenciaCadena(Request $request){
        try {
            $get_all = TicketCadenas::select("ticket_cadenas.*")
            ->where("ticket_cadenas.idTicketNuevo",$request->idTicket)
            ->first();
            return $get_all;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
    
}
