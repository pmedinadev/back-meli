<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WishlistProduct;
use Exception;
use Illuminate\Support\Facades\Validator;

class WishlistProductController extends Controller
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
            'wishlist_id' => 'required|integer|exists:wishlists,id',
            'product_id' => 'required|integer|exists:products,id'
        ]);

        if ($validationResponse) {
            return $validationResponse;
        }

        try {
            $wishlistproducts = WishlistProduct::create($request->all());
            return $this->jsonResponse(201, ['message' => 'wishlist products created successfully', 'wishlistproducts' => $wishlistproducts], 201);
        } catch (Exception $e) {
            return $this->jsonResponse(500, ['error' => $e], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $wishlistproducts = WishlistProduct::find($id);

            if (!$wishlistproducts) {
                return $this->jsonResponse(404, ['error' => 'wishlist products not found'], 404);
            }

            return $this->jsonResponse(200, ['wishlistproducts' => $wishlistproducts], 200);
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
            $wishlistproducts = WishlistProduct::find($id);

            if (!$wishlistproducts) {
                return $this->jsonResponse(404, ['error' => 'wishlist products products not found'], 404);
            }

            $wishlistproducts->delete();
            return $this->jsonResponse(200, ['message' => 'wishlist products products deleted successfully'], 200);
        } catch (Exception $e) {
            return $this->jsonResponse(500, ['error' => 'Internal Server Error'], 500);
        }
    }
}
