<?php

namespace App\Http\Controllers;

use App\Entregacilindros;
use App\SolicitudTicketINDs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use DB;

class EntregacilindrosController extends Controller
{
    public function PostECilindros(Request $request){
       try {
           $get_id = SolicitudTicketINDs::select('solicitud_ticket_i_n_ds.id')
           ->orderBy('solicitud_ticket_i_n_ds.id','desc')
           ->first();

           $data = $request->all();

           $count = count($data);
           log::info($count);

            $i = 0;
            foreach ($request as $key) {
                if($count > $i){
                    $obj = [
                        'idTicket' => $get_id->id,
                        'idCilindro' => $request[$i]['idCilindro'],
                        'cantRecepcion' => $request[$i]['ncilindrosvacios'],
                        'cantEntrega' => $request[$i]['ncilindrosllenos']
                      ];
                      Entregacilindros::create($obj);
                }
                
            $i++;
            }
           //
           return true;
       } catch (\Throwable $th) {
           log::info($th);
           return false;
       }
    } 
}
