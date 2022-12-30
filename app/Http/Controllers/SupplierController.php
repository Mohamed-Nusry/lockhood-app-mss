<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SupplierRequest;
use App\Models\Supplier;
use App\Services\SupplierService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class SupplierController extends Controller
{

    public function __construct(
        private SupplierService $supplierService
    ){}

  
    public function index(Request $request){

        if($request->ajax()) {
            return $this->supplierService->get($request->all());
        }

        return view('pages/suppliers/index');
    }

    public function edit(Request $request){
        try {
            return $this->sendSuccess([
                'message'   => 'Supplier has been found',
                'data'      => $this->supplierService->edit($request->id)
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e);
        }

    }

    public function create(SupplierRequest $request){
        try {

            $input = [];
            $input = $request->all();
            $input['created_by'] = Auth::user()->id;
            $input['updated_by'] = Auth::user()->id;

            return $this->sendSuccess([
                'message'   => 'Supplier has been created',
                'data'      => $this->supplierService->create($input)
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
                'message'   => 'Supplier has been updated',
                'data'      => $this->supplierService->update($input, $id)
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e);
        }
    }

    public function delete(Request $request, $id){
        try {
            return $this->sendSuccess([
                'message'   => 'Supplier '.$request->name.' has been deleted',
                'data'      => $this->supplierService->delete($id)
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e);
        }
    }
}
