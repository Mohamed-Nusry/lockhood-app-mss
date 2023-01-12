<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Material;
use App\Models\Product;
use App\Models\ProductMaterial;
use App\Models\Supplier;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{

    public function __construct(
        private ProductService $productService
    ){}

  
    public function index(Request $request){

        if($request->ajax()) {
            return $this->productService->get($request->all());
        }

        $all_materials = [];

        $materials_count = Material::count();
        if($materials_count > 0){
            $get_materials = Material::all();
            $all_materials = $get_materials;
        }

        return view('pages/products/index', compact('all_materials'));
    }

    public function edit(Request $request){
        try {
            return $this->sendSuccess([
                'message'   => 'Product has been found',
                'data'      => $this->productService->edit($request->id)
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e);
        }

    }

    public function create(ProductRequest $request){
        try {

            $check_already_exist_update = Product::where('code', $request->code)->where('name', $request->name)->count();

            if($check_already_exist_update > 0){

                $check_already_exist_update_dta = Product::where('code', $request->code)->where('name', $request->name)->first();

                $id = $check_already_exist_update_dta->id;

                $input = [];
                $input = $request->all();
                $input['updated_by'] = Auth::user()->id;
                $input['qty'] = $check_already_exist_update_dta->qty + $request->qty;
    
                return $this->sendSuccess([
                    'message'   => 'This Product was already in and it has been updated',
                    'data'      => $this->productService->update($input, $id)
                ]);

            }else{

                $check_already_exist = Product::where('code', $request->code)->count();

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

                      //Add Data
                        $create_product = $this->productService->create($input);

                        //Add Materials
                        if($request->material_ids && $request->material_ids !=null && count($request->material_ids) > 0){
                            foreach ($request->material_ids as $key => $value) {
                                $create_product_materials = new ProductMaterial();
                                $create_product_materials->product_id = $create_product->id;
                                $create_product_materials->material_id = $value;
                                $create_product_materials->save();

                                //reduce quantity
                                $get_material_dta_count = Material::where('id', $value)->count();

                                if($get_material_dta_count > 0){
                                    $get_material_dta = Material::where('id', $value)->first();
                                    $get_material_dta->qty = $get_material_dta->qty - 1;
                                    $get_material_dta->save();
                                }

                            }
                        }
        
                    return $this->sendSuccess([
                        'message'   => 'Product has been added',
                        'data'      => $create_product
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
                'message'   => 'Product has been updated',
                'data'      => $this->productService->update($input, $id)
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e);
        }
    }

    public function delete(Request $request, $id){
        try {
            return $this->sendSuccess([
                'message'   => 'Product '.$request->name.' has been deleted',
                'data'      => $this->productService->delete($id)
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e);
        }
    }
}
