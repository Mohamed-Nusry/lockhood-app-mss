<?php

namespace App\Services;

use App\Models\Department;
use App\Models\Kanban;
use App\Repositories\KanbanRepository;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class KanbanService {

    public function __construct(
        private KanbanRepository $kanbanRepository
    ){}

    public function get(array $data)
    {
        
        return DataTables::eloquent($this->kanbanRepository->getFilterQuery($data))
            ->addColumn('action', function($query){
                if(Auth::user()->user_type == 3){
                    $button = '<button type="button" data-id="'.$query->id.'" class="btn btn-primary btn-sm btn-edit"><i class="fas fa-pencil-alt"></i> Edit</button> ';
                    $button .= '<button type="button" data-id="'.$query->id.'" data-name="'.$query->name.'" class="btn btn-danger btn-sm btn-delete"><i class="fas fa-trash-alt"></i> Delete</button>';
                }else{
                    $button = '<button disabled type="button" data-id="'.$query->id.'" class="btn btn-primary btn-sm btn-edit"><i class="fas fa-pencil-alt"></i> Edit</button> ';
                    $button .= '<button disabled type="button" data-id="'.$query->id.'" data-name="'.$query->name.'" class="btn btn-danger btn-sm btn-delete"><i class="fas fa-trash-alt"></i> Delete</button>';
                }
                if(Auth::user()->user_type == 3 || Auth::user()->user_type == 4){
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

                if(Auth::user()->user_type == 3 && $query->status ==  3){
                    $button .= '&nbsp;<button type="button" data-id="'.$query->id.'" data-name="'.$query->name.'" class="btn btn-secondary btn-sm btn-mark-close"> Send to IT Department</button>';
                }

                return $button;
            })
            ->addColumn('department_id', function (Kanban $department) {
                return ($department->department != null) ? $department->department->name : "N/A";
            })
            ->addColumn('created_by', function (Kanban $created_user) {
                return ($created_user->createdUser != null) ? $created_user->createdUser->first_name.' '.$created_user->createdUser->last_name : "N/A";
            })
            ->addColumn('updated_by', function (Kanban $updated_user) {
                return ($updated_user->updateUser != null) ? $updated_user->updateUser->first_name.' '.$updated_user->updateUser->last_name : "N/A";
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
                                return "Closed";
                            }
                        }
                    }
                }else{
                    return "N/A";
                }
            })
            ->rawColumns(['action'])
            ->filter(function ($query) {
               if(Auth::user()->department_id != null){
                   $query->where('department_id', '=', Auth::user()->department_id);
               }     
            })
            ->toJson();
    }

    public function create(array $data)
    {
        try {
            return $this->kanbanRepository->create($data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function edit($id)
    {
        try {
            return $this->kanbanRepository->find($id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update(array $data, $id)
    {
        try {
            return $this->kanbanRepository->update($data, $id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function delete($id)
    {
        try {
            return $this->kanbanRepository->delete($id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
