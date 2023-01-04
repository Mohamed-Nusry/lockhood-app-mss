<?php

namespace App\Services;

use App\Models\AssignedWork;
use App\Repositories\AssignedWorkRepository;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class AssignedWorkService {

    public function __construct(
        private AssignedWorkRepository $assignedworkRepository
    ){}

    public function get(array $data)
    {
        return DataTables::eloquent($this->assignedworkRepository->getFilterQuery($data))
            ->addColumn('action', function($query){
                if(Auth::user()->user_type == 4){
                    $button = '<button type="button" data-id="'.$query->id.'" class="btn btn-primary btn-sm btn-edit"><i class="fas fa-pencil-alt"></i> Edit</button> ';
                    $button .= '<button type="button" data-id="'.$query->id.'" data-name="'.$query->name.'" class="btn btn-danger btn-sm btn-delete"><i class="fas fa-trash-alt"></i> Delete</button>';
                }else{
                    $button = '<button disabled type="button" data-id="'.$query->id.'" class="btn btn-primary btn-sm btn-edit"><i class="fas fa-pencil-alt"></i> Edit</button> ';
                    $button .= '<button disabled type="button" data-id="'.$query->id.'" data-name="'.$query->name.'" class="btn btn-danger btn-sm btn-delete"><i class="fas fa-trash-alt"></i> Delete</button>';
                }

                if(Auth::user()->user_type == 4 || Auth::user()->user_type == 5){
                    if($query->status ==  1){
                        $button .= '&nbsp;<button type="button" data-id="'.$query->id.'" data-name="'.$query->name.'" class="btn btn-dark btn-sm btn-ongoing"> Mark as ongoing</button>';
                    }else{
                        if($query->status ==  2){
                            $button .= '&nbsp;<button type="button" data-id="'.$query->id.'" data-name="'.$query->name.'" class="btn btn-success btn-sm btn-complete"> Mark as completed</button>';
                        }
                    }
                }else{
                    if($query->status ==  1){
                        $button .= '&nbsp;<button disabled type="button" data-id="'.$query->id.'" data-name="'.$query->name.'" class="btn btn-dark btn-sm btn-ongoing"> Mark as ongoing</button>';
                    }else{
                        if($query->status ==  2){
                            $button .= '&nbsp;<button disabled type="button" data-id="'.$query->id.'" data-name="'.$query->name.'" class="btn btn-success btn-sm btn-complete"> Mark as completed</button>';
                        }
                    }
                }

                return $button;
            })
            ->addColumn('department_id', function (AssignedWork $department) {
                return ($department->department != null) ? $department->department->name : "N/A";
            })
            ->addColumn('created_by', function (AssignedWork $created_user) {
                return ($created_user->createdUser != null) ? $created_user->createdUser->first_name.' '.$created_user->createdUser->last_name : "N/A";
            })
            ->addColumn('updated_by', function (AssignedWork $updated_user) {
                return ($updated_user->updateUser != null) ? $updated_user->updateUser->first_name.' '.$updated_user->updateUser->last_name : "N/A";
            })
            ->addColumn('employee_id', function (AssignedWork $employee) {
               return ($employee->employee != null) ? $employee->employee->name : "N/A";
            })
            ->addColumn('kanban_id', function (AssignedWork $kanban) {
               return ($kanban->kanban != null) ? $kanban->kanban->name : "N/A";
            })
            ->addColumn('created_at', function (AssignedWork $date) {
                return date('M j Y g:i A', strtotime($date->created_at));
             })
            ->addColumn('status', function ($query) {
                if($query->status != null){
                    if($query->status ==  1){
                        return "Pending";
                    }else{
                        if($query->status ==  2){
                            return "Ongoing";
                        }else{
                            if($query->status ==  3){
                                return "Completed";
                            }else{
                                return "N/A";
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
            return $this->assignedworkRepository->create($data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function edit($id)
    {
        try {
            return $this->assignedworkRepository->find($id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update(array $data, $id)
    {
        try {
            return $this->assignedworkRepository->update($data, $id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function delete($id)
    {
        try {
            return $this->assignedworkRepository->delete($id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
