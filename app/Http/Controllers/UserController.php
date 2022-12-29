<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        private UserService $userService
    ){}

    public function index(Request $request){
       
        if($request->ajax()) {
            return $this->userService->get($request->all());
        }

        return view('pages/users/index');
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
            return $this->sendSuccess([
                'message'   => 'User has been created',
                'data'      => $this->userService->create($request->all())
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e);
        }
    }

    public function update(UserRequest $request, $id){
        try {
            return $this->sendSuccess([
                'message'   => 'User has been updated',
                'data'      => $this->userService->update($request->all(), $id)
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
