<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    public function __construct(
        private OrderService $orderService
    ){}

  
    public function index(Request $request){

        if($request->ajax()) {
            return $this->orderService->get($request->all());
        }

        //Get Products
        $all_products = [];

        $products_count = Product::count();
        if($products_count > 0){
            $get_products = Product::all();
            $all_products = $get_products;
        }

        return view('pages/order/index', compact('all_products'));
    }

    public function edit(Request $request){
        try {
            return $this->sendSuccess([
                'message'   => 'Order has been found',
                'data'      => $this->orderService->edit($request->id)
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e);
        }

    }

    public function price(Request $request){


        $total = 0;

        if($request->product_ids && count($request->product_ids) > 0){

            foreach ($request->product_ids as $key => $value) {
                $get_product_count = Product::where('id', $value)->count();
                if($get_product_count > 0){
                    $get_product = Product::where('id', $value)->first();
                    $total = $total + $get_product->price;
                }

              
            }

        }

        return $this->sendSuccess([
            'message'   => 'Total Calculated',
            'data'      => $total
        ]);

    }

    public function create(OrderRequest $request){

        try {

            $input = [];
            $input = $request->all();
            $input['created_by'] = Auth::user()->id;
            $input['updated_by'] = Auth::user()->id;

            //Add Data
            $create_order = $this->orderService->create($input);

            //Add Products
            if($request->product_ids && $request->product_ids !=null && count($request->product_ids) > 0){
                foreach ($request->product_ids as $key => $value) {
                    $create_order_products = new OrderProduct();
                    $create_order_products->order_id = $create_order->id;
                    $create_order_products->product_id = $value;
                    $create_order_products->save();

                    //Reduce product qty
                    $get_product_dta_count = Product::where('id', $value)->count();

                    if($get_product_dta_count > 0){
                        $get_product_dta = Product::where('id', $value)->first();
                        $get_product_dta->qty = $get_product_dta->qty - 1;
                        $get_product_dta->save();
                    }


                }
            }

            if($create_order){
                //Add order no
                $update_order = Order::where('id', $create_order->id)->first();
                $update_order->order_no = "ORD".$create_order->id;
                $update_order->save();

            }

            return $this->sendSuccess([
                'message'   => 'Order has been created',
                'data'      => $create_order
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
                'message'   => 'Order has been updated',
                'data'      => $this->orderService->update($input, $id)
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e);
        }
    }

    public function delete(Request $request, $id){
        try {
            return $this->sendSuccess([
                'message'   => 'Order '.$request->name.' has been deleted',
                'data'      => $this->orderService->delete($id)
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e);
        }
    }

    public function changeStatus(Request $request){

        try {
            $input = [];
            $input = $request->all();
            $input['updated_by'] = Auth::user()->id;
           
            return $this->sendSuccess([
                'message'   => 'Status has been updated',
                'data'      => $this->orderService->update($input, $request->id)
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e);
        }
    }


}
