<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\AssignedWorkService;
use App\Services\MaterialService;
use Illuminate\Http\Request;


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

    
}
