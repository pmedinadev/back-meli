<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CartProduct;
use Exception;
use Illuminate\Support\Facades\Validator;

class CartProductController extends Controller	
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validationResponse = $this->validateRequest($request, [
            'cart_id' =>'required|integer',
            'product_id' =>'required|integer',
            'quantity' => 'required|integer',
        ]);

        if ($validationResponse) {
            return $validationResponse;
        }

        try {
            $cartproduct = CartProduct::create($request->all());
            return $this->jsonResponse(201, ['message' => 'Cart Product created successfully', 'cartproduct' => $cartproduct], 201);
        } catch (Exception $e) {
            return $this->jsonResponse(500, ['error' => $e], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $cartproduct = CartpProduct::find($id);

        $validationResponse = $this->validateRequest($request, [
            'quantity' => 'required|integer',
        ]);

        if ($validationResponse) {
            return $validationResponse;
        }

        try {
            $cartproduct = CartProduct::find($id);

            if (!$cartproduct) {
                return $this->jsonResponse(404, ['error' => 'Cart Product not found'], 404);
            }

            $cartproduct->update($request->all());
            return $this->jsonResponse(200, ['message' => 'Cart Product updated successfully', 'category' => $category], 200);
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
            $cartproduct = CartProduct::find($id);

            if (!$cartproduct) {
                return $this->jsonResponse(404, ['error' => 'Cart Product not found'], 404);
            }

            $cartproduct->delete();
            return $this->jsonResponse(200, ['message' => 'Cart Product deleted successfully'], 200);
        } catch (Exception $e) {
            return $this->jsonResponse(500, ['error' => 'Internal Server Error'], 500);
        }
    }
}
