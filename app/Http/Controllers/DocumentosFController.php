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
       $SubirDocumentos->id_categoria = $request->id_categoria;
       $SubirDocumentos->save();
       return true;
    }
    return false;

    }

    public function getData(Request $request){
       $get_all = SubirDocumentos::select("subir_documentos.*",DB::raw("CONCAT(solicitud_tickets.id) as nticket"))
       ->join("solicitud_tickets","subir_documentos.id_solicitud","=","solicitud_tickets.id")
       ->where("solicitud_tickets.id",$request->id)
       ->get();
       return $get_all;
    }
}
