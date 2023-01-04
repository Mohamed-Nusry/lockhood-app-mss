<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssignedWorkRequest;
use App\Models\AssignedWorkMaterial;
use App\Models\Kanban;
use App\Models\User;
use App\Services\AssignedWorkService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssignedWorkController extends Controller
{

    public function __construct(
        private AssignedWorkService $assignedworkService
    ){}

  
    public function index(Request $request){

        if($request->ajax()) {
            return $this->assignedworkService->get($request->all());
        }

          //Get Employees
          $all_employees = [];
          $all_kanbans = [];
          if(Auth::user()->department_id != null){

            $employees_count = User::where('department_id', Auth::user()->department_id)->where('user_type', 5)->count();
            if($employees_count > 0){
                $get_employees = User::where('department_id', Auth::user()->department_id)->where('user_type', 5)->get();
                $all_employees = $get_employees;
            }

            $kanbans_count = Kanban::where('department_id', Auth::user()->department_id)->count();
            if($kanbans_count > 0){
                $get_kanbans = Kanban::where('department_id', Auth::user()->department_id)->get();
                $all_kanbans = $get_kanbans;
            }
           
          }
        

        return view('pages/assignedworks/index', compact('all_employees', 'all_kanbans'));
    }

    public function edit(Request $request){
        try {
            return $this->sendSuccess([
                'message'   => 'Work has been found',
                'data'      => $this->assignedworkService->edit($request->id)
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e);
        }

    }

    public function create(AssignedWorkRequest $request){
        try {

            $input = [];
            $input = $request->all();
            $input['created_by'] = Auth::user()->id;
            $input['updated_by'] = Auth::user()->id;
            if(Auth::user()->department_id != null){
                $input['department_id'] = Auth::user()->department_id;
            }


            //Add Data
            $create_assignedwork = $this->assignedworkService->create($input);


            return $this->sendSuccess([
                'message'   => 'Work has been created',
                'data'      => $create_assignedwork
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e);
        }
    }

    public function update(Request $request, $id){
        try {

            $input = [];
            $input = $request->all();
            $input['updated_by'] = Auth::user()->id;
           
            return $this->sendSuccess([
                'message'   => 'Work has been updated',
                'data'      => $this->assignedworkService->update($input, $id)
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e);
        }
    }

    public function delete(Request $request, $id){
        try {
            return $this->sendSuccess([
                'message'   => 'Work '.$request->name.' has been deleted',
                'data'      => $this->assignedworkService->delete($id)
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e);
        }
    }

    public function changeStatus(Request $request){

        try {
            $input = [];
            $input = $request->all();
            $input['updated_by'] = Auth::user()->id;
           
            return $this->sendSuccess([
                'message'   => 'Status has been updated',
                'data'      => $this->assignedworkService->update($input, $request->id)
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e);
        }
    }
}
