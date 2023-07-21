<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = ProductResource::collection(Product::all());

        return $this->check_data($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ' required',
            'brand' => ' required',
            'price' => ' required|numeric',
        ]);

        $data = Product::create($request->all());

        return $this->check_data($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $data = new ProductResource($product) ;

        return $this->check_data($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $data = $product->update($request->all());

        return $this->check_data($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $data = $product->delete();

        return $this->check_data($data);
    }

    // Extra functions

    public function check_data($data){
        if (!$data )
            return response()->json(['status' => false, 'data' => null]);

        return response()->json(['status' => true, 'data' => $data]);
    }
}
