<?php

namespace App\Http\Controllers;

use App\documentacion_ap_tables;
use Illuminate\Http\Request;

class DocumentacionApTablesController extends Controller
{
    public function showRegistroEspecifico(Request $request){
        try {
            $get_all = documentacion_ap_tables::select("*")
            ->where("documentacion_ap_tables.idMAP", $request->id)
            ->get();
            return $get_all;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PostDocumentoAP(Request $request)
    {
        try {
            if ($request->hasFile('avatar')) {
                // Si es así , almacenamos en la carpeta public/avatars
                // esta estará dentro de public/defaults/
               $url = $request->avatar->store('users/Documentacion');
               $DocumentacionAPs = new documentacion_ap_tables;
               $DocumentacionAPs->idMAP = $request->id;
               //$repositorioDocumentaciones->descripcionDocumento = $request->nombreDoc;
               $DocumentacionAPs->nombreDocumento = $url;
               $DocumentacionAPs->save();
               $idLast = $DocumentacionAPs->id;
               documentacion_ap_tables::where('id', $idLast)
                ->where('idMAP', $request->id)
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
            $res=documentacion_ap_tables::where('id',$request->id)->delete();
            if($res){
              return true;
            }
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
}
