<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Handle JSON responses.
     */
    private function jsonResponse($status, $data, $code)
    {
        return response()->json(array_merge(['status' => $status], $data), $code);
    }

    /**
     * Validate request data.
     */
    private function validateRequest(Request $request, array $rules)
    {
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->jsonResponse(400, ['errors' => $validator->errors()], 400);
        }

        return null;
    }

    public function search(Request $request)
    {
        try {
            $query = $request->get('q');

            $products = Product::with(['photos', 'user'])
                ->where('title', 'LIKE', "%{$query}%")
                ->orWhere('description', 'LIKE', "%{$query}%")
                ->orderBy('created_at', 'desc')
                ->get();

            return $this->jsonResponse(200, ['products' => $products], 200);
        } catch (Exception $e) {
            return $this->jsonResponse(500, ['error' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $query = Product::with('photos');

            if ($request->has('status')) {
                $query->where('status', $request->status);
            }

            if ($request->has('user_id')) {
                $query->where('user_id', $request->user_id);
            }

            // $products = Product::all();
            $products = $query->orderBy('created_at', 'desc')->get();

            return $this->jsonResponse(200, ['products' => $products], 200);
        } catch (Exception $e) {
            return $this->jsonResponse(500, ['error' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validationResponse = $this->validateRequest($request, [
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'condition' => 'sometimes|string',
            'stock' => 'sometimes|integer',
            'upc' => 'sometimes|string',
            'sku' => 'sometimes|string',
            'price' => 'sometimes|numeric',
            'publication_type' => 'sometimes|string',
            'warranty_type' => 'sometimes|string',
            'warranty_duration' => 'sometimes|integer',
            'warranty_duration_type' => 'sometimes|string',
            'status' => 'required|string',
            'category_id' => 'sometimes|integer|exists:categories,id',
            'user_id' => 'required|integer|exists:users,id',
        ]);

        if ($validationResponse) {
            return $validationResponse;
        }

        try {
            $product = Product::create($request->all());
            return $this->jsonResponse(201, ['message' => 'Product created successfully', 'product' => $product], 201);
        } catch (Exception $e) {
            return $this->jsonResponse(500, ['error' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $product = Product::with('user', 'photos')->find($id);

            if (!$product) {
                return $this->jsonResponse(404, ['error' => 'Product not found'], 404);
            }

            return $this->jsonResponse(200, ['product' => $product], 200);
        } catch (Exception $e) {
            return $this->jsonResponse(500, ['error' => $e], 500);
            // return $this->jsonResponse(500, ['error' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validationResponse = $this->validateRequest($request, [
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'condition' => 'sometimes|string',
            'stock' => 'sometimes|integer',
            'upc' => 'sometimes|string',
            'sku' => 'sometimes|string',
            'price' => 'sometimes|numeric',
            'publication_type' => 'sometimes|string',
            'warranty_type' => 'sometimes|string',
            'warranty_duration' => 'sometimes|integer',
            'warranty_duration_type' => 'sometimes|string',
            'status' => 'sometimes|string',
            'category_id' => 'sometimes|integer|exists:categories,id',
        ]);

        if ($validationResponse) {
            return $validationResponse;
        }

        try {
            $product = Product::find($id);

            if (!$product) {
                return $this->jsonResponse(404, ['error' => 'Product not found'], 404);
            }

            $product->update($request->all());
            return $this->jsonResponse(200, ['message' => 'Product updated successfully', 'product' => $product], 200);
        } catch (Exception $e) {
            return $this->jsonResponse(500, ['error' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $product = Product::find($id);

            if (!$product) {
                return $this->jsonResponse(404, ['error' => 'Product not found'], 404);
            }

            $product->delete();
            return $this->jsonResponse(200, ['message' => 'Product deleted successfully'], 200);
        } catch (Exception $e) {
            return $this->jsonResponse(500, ['error' => 'Internal Server Error'], 500);
        }
    }
}
