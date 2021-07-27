<?php

namespace App\Http\Controllers;

use App\GanttObras;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;

class GanttObrasController extends Controller
{
    public function GetLastIdObras(){
        try {
            $get_all = GanttObras::select("gantt_obras.*")
            ->orderBy("gantt_obras.id","desc")
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
            $get_all = GanttObras::all();
            return $get_all;
            
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PostNObra(Request $request){
      try {
          $get_all = GanttObras::create($request->all());
          return true;
      } catch (\Throwable $th) {
          log::info($th);
          return false;
      }
    }

    public function PostNSubObra(Request $request){
        try {
            $get_all = GanttObras::create($request->all());
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PostNObraRANull(){
        try {
            $get_all = GanttObras::select("gantt_obras.*", DB::raw("DATE_FORMAT(gantt_obras.start,'%d/%m/%Y') as starts"),
            DB::raw("DATE_FORMAT(gantt_obras.end,'%d/%m/%Y') as ends"))
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
            $get_all = GanttObras::select("gantt_obras.*")
            ->whereNotNull("gantt_obras.resourceAsociado")
            ->get();
            return $get_all;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
      }

    
}
