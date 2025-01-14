<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Favorite;
use Exception;
use Illuminate\Support\Facades\Validator;

class FavoriteController extends Controller
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
            'user_id' => 'required|integer|exists:users,id'
        ]);

        if ($validationResponse) {
            return $validationResponse;
        }

        try {
            $favorite = Favorite::create($request->all());
            return $this->jsonResponse(201, ['message' => 'favorite created successfully', 'favorite' => $favorite], 201);
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
            $favorite = Favorite::with(['products' => function ($query) {
                $query->select([
                    'products.id',
                    'products.title',
                    'products.price',
                    'products.stock',
                    'products.user_id'
                ])
                    ->orderBy('favorite_products.created_at', 'asc');
            }])->findOrFail($id);

            $favorite->products->transform(function ($product) {
                $product->favorite_product_id = $product->pivot->id;
                $product->created_at = $product->pivot->created_at;
                unset($product->pivot);
                return $product;
            });

            return $this->jsonResponse(200, ['favorite' => $favorite], 200);
        } catch (ModelNotFoundException $e) {
            return $this->jsonResponse(404, ['error' => 'Favorite not found'], 404);
        } catch (Exception $e) {
            return $this->jsonResponse(500, ['error' => $e], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $favorite = Favorite::find($id);

            if (!$favorite) {
                return $this->jsonResponse(404, ['error' => 'favorite not found'], 404);
            }

            $favorite->delete();
            return $this->jsonResponse(200, ['message' => 'favorite deleted successfully'], 200);
        } catch (Exception $e) {
            return $this->jsonResponse(500, ['error' => 'Internal Server Error'], 500);
        }
    }
}
