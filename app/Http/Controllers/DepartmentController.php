<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DepartmentController extends Controller
{
  
    public function index(Request $request){

        if($request->ajax()) {
            $data = Department::orderBy('created_at', 'desc')->limit(10)->get();
            return $data;
            return DataTables::eloquent($data)
            ->addColumn('action', function($query){
                $button = '<a type="button" data-id="'.$query->id.'" class="btn btn-primary btn-sm btn-edit"><i class="fas fa-pencil-alt"></i> Edit</a> ';
                $button .= '<a type="button" data-id="'.$query->id.'" data-name="'.$query->name.'" class="btn btn-danger btn-sm btn-delete"><i class="fas fa-trash-alt"></i> Delete</a>';
                return $button;
            })
            ->rawColumns(['action'])
            ->toJson();
        
        }

        return view('pages/departments/index');
    }

    public function create(Request $request){
        try {

            $this->validate($request, [
                'name' => 'required',
                'code' => 'required',
            ],
                $messages = [
                    'required' => 'The :attribute field is required.',
                ]
            );

            $input = [];
            $input = $request->all();

            Department::create($input);
                

            return $this->sendSuccess([
                'message'   => 'Department has been created',
                'data'      => null
            ]);

        } catch (\Exception $e) {
            return $this->sendError($e);
        }
    }

    public function update(Request $request, $id){
        try {
            return $this->sendSuccess([
                'message'   => 'Department has been updated',
                'data'      => $this->userService->update($request->all(), $id)
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e);
        }
    }

    public function delete(Request $request, $id){
        try {
            return $this->sendSuccess([
                'message'   => 'Department '.$request->name.' has been deleted',
                'data'      => $this->userService->delete($id)
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e);
        }
    }
}
