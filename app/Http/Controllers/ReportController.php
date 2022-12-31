<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AssignedWork;
use App\Services\AssignedWorkService;
use App\Services\MaterialService;
use App\Models\Material;
use App\Models\User;
use Illuminate\Http\Request;
use PDF;


class ReportController extends Controller
{

    public function __construct(
        private AssignedWorkService $assignedworkService,
        private MaterialService $materialService
    ){}

  
    public function workreport(Request $request){

        if($request->ajax()) {
            return $this->assignedworkService->get($request->all());
        }


        return view('pages/workreports/index');
    }

    
    public function incomereport(Request $request){

        if($request->ajax()) {
            return $this->materialService->get($request->all());
        }


        return view('pages/incomereports/index');

        
    }

    public function workreportPDF(Request $request){

        $from_date = null;
        $to_date = null;

        if($request->from != null){
            $from_date = $request->from;
        }
        if($request->to != null){
            $to_date = $request->to;
        }


        if($from_date != null && $to_date != null){
            $assignedworks = AssignedWork::whereBetween('created_at', [$from_date, $to_date])->with('department')->with('employee')->with('kanban')->with('user')->get();
        }else{
            if($from_date != null && $to_date == null){
                $assignedworks = AssignedWork::whereDate('created_at', '>=', $from_date)->with('department')->with('employee')->with('kanban')->with('user')->get();
            }else{
                if($to_date != null && $from_date == null){
                    $assignedworks = AssignedWork::whereDate('created_at', '<=', $to_date)->with('department')->with('employee')->with('kanban')->with('user')->get();
                }else{
                    $assignedworks = AssignedWork::with('department')->with('employee')->with('kanban')->with('user')->get();
                }
            }
        }

  
        $data = [
            'title' => 'Work Report',
            'from_date' => $from_date,
            'to_date' => $to_date,
            'assignedworks' => $assignedworks
        ]; 
            
        $pdf = PDF::loadView('pdf/workreport', $data);
     
        return $pdf->download('workReport.pdf');

        // return view('pages/incomereports/index');

        
    }

    public function incomereportPDF(Request $request){

        $from_date = null;
        $to_date = null;

        if($request->from != null){
            $from_date = $request->from;
        }
        if($request->to != null){
            $to_date = $request->to;
        }


        if($from_date != null && $to_date != null){
            $materials = Material::whereBetween('created_at', [$from_date, $to_date])->with('supplier')->with('user')->get();
        }else{
            if($from_date != null && $to_date == null){
                $materials = Material::whereDate('created_at', '>=', $from_date)->with('supplier')->with('user')->get();
            }else{
                if($to_date != null && $from_date == null){
                    $materials = Material::whereDate('created_at', '<=', $to_date)->with('supplier')->with('user')->get();
                }else{
                    $materials = Material::with('supplier')->with('user')->get();
                }
            }
        }

  
        $data = [
            'title' => 'Income Report',
            'from_date' => $from_date,
            'to_date' => $to_date,
            'materials' => $materials
        ]; 
            
        $pdf = PDF::loadView('pdf/incomereport', $data);
     
        return $pdf->download('incomeReport.pdf');

        // return view('pages/incomereports/index');

        
    }

    
}
