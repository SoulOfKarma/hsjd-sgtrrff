<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\SubirDocumentos;
use DB;
use App\SolicitudTickets;
use App\SolicitudTicketINDs;
use App\SolicitudTicketsEM;
use App\SolicitudTicketsAps;


class DocumentosFController extends Controller
{
    public function store(Request $request){
      try {
        if ($request->hasFile('avatar')) {
          // Si es así , almacenamos en la carpeta public/avatars
          // esta estará dentro de public/defaults/
         $get_all = SolicitudTickets::latest('id')->first(); 
         $url = $request->avatar->store('users/Documentacion');
         $SubirDocumentos = new SubirDocumentos;
         $SubirDocumentos->id_solicitud = $get_all->id;
         $SubirDocumentos->nombre_documento = $url;
         $SubirDocumentos->id_categoria = $request->id_categoria;
         $SubirDocumentos->save();
         return true;
         }
         return false;
      } catch (\Throwable $th) {
        log::info($th);
        return false;
      }
      // Verificamos si hay un file con nombre avatar
    }

    public function storeAP(Request $request){
      try {
        if ($request->hasFile('avatar')) {
          // Si es así , almacenamos en la carpeta public/avatars
          // esta estará dentro de public/defaults/
         $get_all = SolicitudTicketsAps::latest('id')->first(); 
         $url = $request->avatar->store('users/Documentacion');
         $SubirDocumentos = new SubirDocumentos;
         $SubirDocumentos->id_solicitud = $get_all->id;
         $SubirDocumentos->nombre_documento = $url;
         $SubirDocumentos->id_categoria = $request->id_categoria;
         $SubirDocumentos->save();
         return true;
         }
         return false;
      } catch (\Throwable $th) {
        log::info($th);
        return false;
      }
      // Verificamos si hay un file con nombre avatar
    }

    public function storeEM(Request $request){
      try {
        if ($request->hasFile('avatar')) {
          // Si es así , almacenamos en la carpeta public/avatars
          // esta estará dentro de public/defaults/
         $get_all = SolicitudTicketsEM::latest('id')->first(); 
         $url = $request->avatar->store('users/Documentacion');
         $SubirDocumentos = new SubirDocumentos;
         $SubirDocumentos->id_solicitud = $get_all->id;
         $SubirDocumentos->nombre_documento = $url;
         $SubirDocumentos->id_categoria = $request->id_categoria;
         $SubirDocumentos->save();
         return true;
         }
         return false;
      } catch (\Throwable $th) {
        log::info($th);
        return false;
      }
      // Verificamos si hay un file con nombre avatar
    }

    public function storeIND(Request $request){
      try {
        if ($request->hasFile('avatar')) {
          // Si es así , almacenamos en la carpeta public/avatars
          // esta estará dentro de public/defaults/
         $get_all = SolicitudTicketINDs::latest('id')->first(); 
         $url = $request->avatar->store('users/Documentacion');
         $SubirDocumentos = new SubirDocumentos;
         $SubirDocumentos->id_solicitud = $get_all->id;
         $SubirDocumentos->nombre_documento = $url;
         $SubirDocumentos->id_categoria = $request->id_categoria;
         $SubirDocumentos->save();
         return true;
         }
         return false;
      } catch (\Throwable $th) {
        log::info($th);
        return false;
      }
      // Verificamos si hay un file con nombre avatar
    }

    public function getData(Request $request){
       $get_all = SubirDocumentos::select("subir_documentos.*",DB::raw("CONCAT(subir_documentos.id_solicitud) as nticket"))
       ->where("subir_documentos.id_solicitud",$request->id)
       ->where("subir_documentos.id_categoria",$request->id_categoria)
       ->get();
       return $get_all;
    }
}
