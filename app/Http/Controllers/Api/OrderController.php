<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
    */
    public function index()
    {
        $data = OrderResource::collection(Order::all());

        return $this->check_data($data);
    }

    /**
     * Store a newly created resource in storage.
    */
    public function store(Request $request)
    {
        $requestData = $request->all();
        $request->validate([
            'product_id' => ' required|numeric',
            'amount' => ' required',
        ]);

        $product = Product::find($request->product_id);

        $requestData['summa'] = $product->price * $request->amount ;
        $requestData['month'] = date('m');
        $requestData['year'] = date('Y');

        // return $requestData ;

        $data = Order::create($requestData);

        return $this->check_data($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $data = new OrderResource($order) ;

        return $this->check_data($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $requestData = $request->all();
        $request->validate([
            'product_id' => ' required|numeric',
            'amount' => ' required',
        ]);

        $product = Product::findOrFail($request->product_id);

        $requestData['summa'] = $product->price * $request->amount ;

        // return $requestData ;

        $data = $order->update($requestData);

        return $this->check_data($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $data = $order->delete();

        return $this->check_data($data);
    }

    // Extra functions

    public function check_data($data){
        if (!$data )
            return response()->json(['status' => false, 'data' => null]);

        return response()->json(['status' => true, 'data' => $data]);
    }
}
