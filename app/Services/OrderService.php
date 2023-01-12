<?php

namespace App\Services;

use App\Models\Department;
use App\Models\Order;
use App\Repositories\OrderRepository;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class OrderService {

    public function __construct(
        private OrderRepository $orderRepository
    ){}

    public function get(array $data)
    {
        
        return DataTables::eloquent($this->orderRepository->getFilterQuery($data))
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
            ->addColumn('created_by', function (Order $created_user) {
                return ($created_user->createdUser != null) ? $created_user->createdUser->first_name.' '.$created_user->createdUser->last_name : "N/A";
            })
            ->addColumn('updated_by', function (Order $updated_user) {
                return ($updated_user->updateUser != null) ? $updated_user->updateUser->first_name.' '.$updated_user->updateUser->last_name : "N/A";
            })
            ->addColumn('payment_status', function ($query) {
                if($query->payment_status != null){
                    if($query->payment_status ==  1){
                        return "Cash";
                    }else{
                        if($query->payment_status ==  2){
                            return "Card";
                        }else{
                            if($query->payment_status ==  3){
                                return "Checkque";
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
            return $this->orderRepository->create($data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function edit($id)
    {
        try {
            return $this->orderRepository->find($id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update(array $data, $id)
    {
        try {
            return $this->orderRepository->update($data, $id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function delete($id)
    {
        try {
            return $this->orderRepository->delete($id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
