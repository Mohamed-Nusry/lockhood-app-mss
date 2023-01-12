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

            $check_already_exist_update = Material::where('code', $request->code)->where('name', $request->name)->count();

            if($check_already_exist_update > 0){

                $check_already_exist_update_dta = Material::where('code', $request->code)->where('name', $request->name)->first();

                $id = $check_already_exist_update_dta->id;

                $input = [];
                $input = $request->all();
                $input['updated_by'] = Auth::user()->id;
                $input['qty'] = $check_already_exist_update_dta->qty + $request->qty;
    
                return $this->sendSuccess([
                    'message'   => 'This Material was already in and it has been updated',
                    'data'      => $this->materialService->update($input, $id)
                ]);

            }else{

                $check_already_exist = Material::where('code', $request->code)->count();

                if($check_already_exist > 0){
                    
                    return response()->json([
                        'status'    => 400,
                        'message'   => 'Code need to be unique',
                        'data'      => null,
                    ], 200);

                }else{

                    $input = [];
                    $input = $request->all();
                    $input['created_by'] = Auth::user()->id;
                    $input['updated_by'] = Auth::user()->id;
        
                    return $this->sendSuccess([
                        'message'   => 'Material has been purchased',
                        'data'      => $this->materialService->create($input)
                    ]);

                }

            }

           
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
