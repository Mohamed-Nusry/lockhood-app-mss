<?php

namespace App\Services;

use App\Models\Material;
use App\Repositories\MaterialRepository;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class MaterialService {

    public function __construct(
        private MaterialRepository $materialRepository
    ){}

    public function get(array $data)
    {
        return DataTables::eloquent($this->materialRepository->getFilterQuery($data))
            ->addColumn('action', function($query){
                if(Auth::user()->user_type != 5 ){
                    $button = '<button type="button" data-id="'.$query->id.'" class="btn btn-primary btn-sm btn-edit"><i class="fas fa-pencil-alt"></i> Edit</button> ';
                    $button .= '<button type="button" data-id="'.$query->id.'" data-name="'.$query->name.'" class="btn btn-danger btn-sm btn-delete"><i class="fas fa-trash-alt"></i> Delete</button>';
                }else{ 
                    $button = '<button disabled type="button" data-id="'.$query->id.'" class="btn btn-primary btn-sm btn-edit"><i class="fas fa-pencil-alt"></i> Edit</button> ';
                    $button .= '<button disabled type="button" data-id="'.$query->id.'" data-name="'.$query->name.'" class="btn btn-danger btn-sm btn-delete"><i class="fas fa-trash-alt"></i> Delete</button>';
                }

                return $button;
            })
            ->addColumn('supplier_id', function (Material $supplier) {
                return ($supplier->supplier != null) ? $supplier->supplier->name : "N/A";
            })
            ->addColumn('created_by', function (Material $created_user) {
                return ($created_user->createdUser != null) ? $created_user->createdUser->first_name.' '.$created_user->createdUser->last_name : "N/A";
            })
            ->addColumn('created_at', function (Material $date) {
                return date('M j Y g:i A', strtotime($date->created_at));
             })
             ->addColumn('updated_by', function (Material $updated_user) {
                return ($updated_user->updateUser != null) ? $updated_user->updateUser->first_name.' '.$updated_user->updateUser->last_name : "N/A";
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function create(array $data)
    {
        try {
            return $this->materialRepository->create($data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function edit($id)
    {
        try {
            return $this->materialRepository->find($id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update(array $data, $id)
    {
        try {
            return $this->materialRepository->update($data, $id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function delete($id)
    {
        try {
            return $this->materialRepository->delete($id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
