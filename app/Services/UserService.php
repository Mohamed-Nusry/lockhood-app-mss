<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class UserService {

    public function __construct(
        private UserRepository $userRepository
    ){}

    public function get(array $data)
    {
        return DataTables::eloquent($this->userRepository->getFilterQuery($data))
            ->addColumn('action', function($query){
                if(Auth::user()->user_type == 1 || Auth::user()->user_type == 2){
                    $button = '<button type="button" data-id="'.$query->id.'" class="btn btn-primary btn-sm btn-edit"><i class="fas fa-pencil-alt"></i> Edit</button> ';
                    $button .= '<button type="button" data-id="'.$query->id.'" data-name="'.$query->name.'" class="btn btn-danger btn-sm btn-delete"><i class="fas fa-trash-alt"></i> Delete</button>';
                }else{
                    $button = '<button disabled type="button" data-id="'.$query->id.'" class="btn btn-primary btn-sm btn-edit"><i class="fas fa-pencil-alt"></i> Edit</button> ';
                    $button .= '<button disabled type="button" data-id="'.$query->id.'" data-name="'.$query->name.'" class="btn btn-danger btn-sm btn-delete"><i class="fas fa-trash-alt"></i> Delete</button>';
                }
               
                return $button;
            })
            ->addColumn('department_id', function (User $department) {
                return ($department->department != null) ? $department->department->name : "N/A";
            })
            ->addColumn('user_type', function ($query) {
                if($query->user_type != null){
                    if($query->user_type ==  1){
                        return "Admin";
                    }else{
                        if($query->user_type ==  2){
                            return "Factory Head";
                        }else{
                            if($query->user_type ==  3){
                                return "Supervisor";
                            }else{
                                if($query->user_type ==  4){
                                    return "Department Head";
                                }else{
                                    if($query->user_type ==  5){
                                        return "Employee";
                                    }else{
                                        return "N/A";
                                    }
                                }
                            }
                        }
                    }
                }else{
                    return "N/A";
                }
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function create(array $data)
    {
        try {
            return $this->userRepository->create($data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function edit($id)
    {
        try {
            return $this->userRepository->find($id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update(array $data, $id)
    {
        try {
            return $this->userRepository->update($data, $id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function delete($id)
    {
        try {
            return $this->userRepository->delete($id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
