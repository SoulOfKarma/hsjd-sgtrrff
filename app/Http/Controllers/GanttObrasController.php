<?php

namespace App\Http\Controllers;

use App\GanttObras;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;

class GanttObrasController extends Controller
{
    public function verificacionId(){
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

    public function PostNObraRANull(){
        try {
            $get_all = GanttObras::whereNull("resourceAsociado")
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
