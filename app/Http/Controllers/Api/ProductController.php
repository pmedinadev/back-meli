<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return response()->json($products, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $product = Product::create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'user_id' => $request->user_id
        ]);

        $data = [
            'status' => 201,
            'message' => 'Product created successfully',
            'product' => $product
        ];

        return response()->json($data, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::find($id);

        if (!$product) {
            $data = [
                'status' => 404,
                'error' => 'Product not found'
            ];
        
            return response()->json($data, 404);
        }

        $data = [
            'status' => 200,
            'product' => $product
        ];
        
        return response()->json($data, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::find($id);

        if (!$product) {
            $data = [
                'status' => 404,
                'error' => 'Product not found'
            ];
        
            return response()->json($data, 404);
        }
        
        $product->title = $request->title;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;

        $product->save();

        $data = [
            'status' => 200,
            'message' => 'Product updated successfully',
            'product' => $product
        ];
        
        return response()->json($data, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);

        if(!$product) {
            $data = [
                'status' => 404,
                'error' => 'Product not found'
            ];

            return response()->json($data, 404);
        }

        $product->delete();

        $data = [
            'status' => 200,
            'message' => 'Product deleted successfully'
        ];

        return response()->json($data, 200);
    }
}
