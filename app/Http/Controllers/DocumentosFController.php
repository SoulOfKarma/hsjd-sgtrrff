<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\SubirDocumentos;


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
       $get_all = SubirDocumentos::all();
       return $get_all;
    }
}
