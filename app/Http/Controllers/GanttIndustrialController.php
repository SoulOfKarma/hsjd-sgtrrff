<?php

namespace App\Http\Controllers;

use App\GanttIndustrial;
use App\Users;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;

class GanttIndustrialController extends Controller
{
    public function GetLastIdObras(){
        try {
            $get_all = GanttIndustrial::select("gantt_industrials.*")
            ->orderBy("gantt_industrials.id","desc")
            ->limit(1)
            ->get();
            return $get_all;
            
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function GetObras(){
        try {
            $get_all = GanttIndustrial::all();
            return $get_all;
            
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PostNObra(Request $request){
      try {
          $get_all = GanttIndustrial::create($request->all());
          return true;
      } catch (\Throwable $th) {
          log::info($th);
          return false;
      }
    }

    public function PostNSubObra(Request $request){
        try {
            $get_all = GanttIndustrial::create($request->all());
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PostNObraRANull(){
        try {
            $get_all = GanttIndustrial::select("gantt_industrials.*", DB::raw("DATE_FORMAT(gantt_industrials.start,'%d/%m/%Y') as starts"),
            DB::raw("DATE_FORMAT(gantt_industrials.end,'%d/%m/%Y') as ends"))
            ->whereNull("resourceAsociado")
            ->get();
            return $get_all;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
      }

      public function PostNObraRA(){
        try {
            $get_all = GanttIndustrial::select("gantt_industrials.*")
            ->whereNotNull("gantt_industrials.resourceAsociado")
            ->get();
            return $get_all;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
      }

      public function PutObra(Request $request){
          try {
            $resp = GanttIndustrial::where('id', $request->id)
                    ->update([
                     'title' => $request->title,'start' => $request->start,'end' => $request->end,
                     'eventcolor' => $request->eventcolor, 'resourceId' => $request->resourceId,
                     'resourceAsociado' => $request->resourceAsociado
                    ]);

            return true;
          } catch (\Throwable $th) {
            log::info($th);
            return false;
          }
      }

      public function GetColorCargo(Request $request){
          try {
              $get_all = Users::select('users.id_cargo','cargo_usuarios.descripcionCargo')
              ->join('cargo_usuarios','users.id_cargo','=', 'cargo_usuarios.id')
              ->where('users.run',$request->run)
              ->get();
              return $get_all;
            }
            catch (\Throwable $th) {
            log::info($th);
            return false;
          }
      }
}
