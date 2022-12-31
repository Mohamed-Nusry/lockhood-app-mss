<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\MaterialRequest;
use App\Models\Material;
use App\Models\Supplier;
use App\Services\MaterialService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class MaterialController extends Controller
{

    public function __construct(
        private MaterialService $materialService
    ){}

  
    public function index(Request $request){

        if($request->ajax()) {
            return $this->materialService->get($request->all());
        }

        //Get Suppliers
        $all_suppliers = [];


        $suppliers_count = Supplier::count();
        if($suppliers_count > 0){
            $get_suppliers = Supplier::all();
            $all_suppliers = $get_suppliers;
        }

        return view('pages/materials/index', compact('all_suppliers'));
    }

    public function edit(Request $request){
        try {
            return $this->sendSuccess([
                'message'   => 'Material has been found',
                'data'      => $this->materialService->edit($request->id)
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e);
        }

    }

    public function create(MaterialRequest $request){
        try {

            $input = [];
            $input = $request->all();
            $input['created_by'] = Auth::user()->id;
            $input['updated_by'] = Auth::user()->id;

            return $this->sendSuccess([
                'message'   => 'Material has been purchased',
                'data'      => $this->materialService->create($input)
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
                'message'   => 'Material has been updated',
                'data'      => $this->materialService->update($input, $id)
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e);
        }
    }

    public function delete(Request $request, $id){
        try {
            return $this->sendSuccess([
                'message'   => 'Material '.$request->name.' has been deleted',
                'data'      => $this->materialService->delete($id)
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e);
        }
    }
}
