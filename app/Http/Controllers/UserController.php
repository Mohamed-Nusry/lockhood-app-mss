<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\Department;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct(
        private UserService $userService
    ){}

    public function index(Request $request){
       
        if($request->ajax()) {
            return $this->userService->get($request->all());
        }

        //Get Departments
        $all_departments = [];
        $departments_count = Department::count();
        if($departments_count > 0){
            $get_departments = Department::all();
            $all_departments = $get_departments;
        }

        return view('pages/users/index', compact('all_departments'));
    }
    
    public function edit(Request $request){
        try {
            return $this->sendSuccess([
                'message'   => 'User has been found',
                'data'      => $this->userService->edit($request->id)
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e);
        }

    }

    public function create(Request $request){
        try {


            $input = [];
            $input = $request->all();
            $input['password'] = Hash::make($input['password']);
            $input['created_by'] = Auth::user()->id;
            $input['updated_by'] = Auth::user()->id;

            return $this->sendSuccess([
                'message'   => 'User has been created',
                'data'      => $this->userService->create($input)
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e);
        }
    }

    public function update(UserRequest $request, $id){
        try {

            $input = [];
            $input = $request->all();
            $input['updated_by'] = Auth::user()->id;

            return $this->sendSuccess([
                'message'   => 'User has been updated',
                'data'      => $this->userService->update($input, $id)
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e);
        }
    }

    public function delete(Request $request, $id){
        try {
            return $this->sendSuccess([
                'message'   => 'User '.$request->name.' has been deleted',
                'data'      => $this->userService->delete($id)
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e);
        }
    }
}
