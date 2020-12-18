<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\SubirDocumentos;
use DB;


class DocumentosFController extends Controller
{
    public function store(Request $request){

      // Verificamos si hay un file con nombre avatar
    if ($request->hasFile('avatar')) {
        // Si es así , almacenamos en la carpeta public/avatars
        // esta estará dentro de public/defaults/
       
       $url = $request->avatar->store('users/Documentacion');
       $SubirDocumentos = new SubirDocumentos;
       $SubirDocumentos->id_solicitud = $request->id;
       $SubirDocumentos->nombre_documento = $url;
       $SubirDocumentos->save();
       return true;
    }
    return false;

    }

    public function getData(){
       $get_all = SubirDocumentos::select("subir_documentos.*",DB::raw("CONCAT(DATE_FORMAT(solicitud_tickets.created_at, '%d%m%Y'),'-',solicitud_tickets.id,'-',solicitud_tickets.id_user) as nticket"))
       ->join("solicitud_tickets","subir_documentos.id_solicitud","=","solicitud_tickets.id")
       ->get();
       return $get_all;
    }
}
