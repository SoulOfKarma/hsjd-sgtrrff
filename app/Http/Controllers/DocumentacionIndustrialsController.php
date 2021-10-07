<?php

namespace App\Http\Controllers;

use App\DocumentacionIndustrials;
use Illuminate\Http\Request;

class DocumentacionIndustrialsController extends Controller
{
    public function showRegistroEspecifico(Request $request){
        try {
            $get_all = DocumentacionIndustrials::select("*")
            ->where("documentacion_industrials.idMIndustrial", $request->id)
            ->get();
            return $get_all;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PostDocumentoIND(Request $request)
    {
        try {
            if ($request->hasFile('avatar')) {
                // Si es así , almacenamos en la carpeta public/avatars
                // esta estará dentro de public/defaults/
               $url = $request->avatar->store('users/Documentacion');
               $DocumentacionIndustrials = new DocumentacionIndustrials;
               $DocumentacionIndustrials->idMIndustrial = $request->id;
               //$repositorioDocumentaciones->descripcionDocumento = $request->nombreDoc;
               $DocumentacionIndustrials->nombreDocumento = $url;
               $DocumentacionIndustrials->save();
               $idLast = $DocumentacionIndustrials->id;
               DocumentacionIndustrials::where('id', $idLast)
                ->where('idMIndustrial', $request->id)
                ->update(['descripcionDocumento' => $request->nombreDoc]);
               return true;
            }
            
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function DestroyDocReg(Request $request){
        try {
            $res=DocumentacionIndustrials::where('id',$request->id)->delete();
            if($res){
              return true;
            }
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
}
