<?php

namespace App\Services;

use App\Repositories\KanbanRepository;
use Yajra\DataTables\Facades\DataTables;

class KanbanService {

    public function __construct(
        private KanbanRepository $kanbanRepository
    ){}

    public function get(array $data)
    {
        return DataTables::eloquent($this->kanbanRepository->getFilterQuery($data))
            ->addColumn('action', function($query){
                $button = '<a type="button" data-id="'.$query->id.'" class="btn btn-primary btn-sm btn-edit"><i class="fas fa-pencil-alt"></i> Edit</a> ';
                $button .= '<a type="button" data-id="'.$query->id.'" data-name="'.$query->name.'" class="btn btn-danger btn-sm btn-delete"><i class="fas fa-trash-alt"></i> Delete</a>';
                return $button;
            })
            ->rawColumns(['action'])
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
