<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\DepartmentRequest;
use App\Models\Department;
use App\Services\DepartmentService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DepartmentController extends Controller
{

    public function __construct(
        private DepartmentService $departmentService
    ){}

  
    public function index(Request $request){

        if($request->ajax()) {
            return $this->departmentService->get($request->all());
        }

        return view('pages/departments/index');
    }

    public function edit(Request $request){
        try {
            return $this->sendSuccess([
                'message'   => 'Department has been found',
                'data'      => $this->departmentService->edit($request->id)
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e);
        }

    }

    public function create(DepartmentRequest $request){
        try {
            return $this->sendSuccess([
                'message'   => 'Department has been created',
                'data'      => $this->departmentService->create($request->all())
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e);
        }
    }

    public function update(Request $request, $id){
        try {
            return $this->sendSuccess([
                'message'   => 'Department has been updated',
                'data'      => $this->departmentService->update($request->all(), $id)
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e);
        }
    }

    public function delete(Request $request, $id){
        try {
            return $this->sendSuccess([
                'message'   => 'Department '.$request->name.' has been deleted',
                'data'      => $this->departmentService->delete($id)
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e);
        }
    }
}
