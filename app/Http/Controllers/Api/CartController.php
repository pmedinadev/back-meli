<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
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
            $cart = Cart::create($request->all());
            return $this->jsonResponse(201, ['message' => 'Cart created successfully', 'cart' => $cart], 201);
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
            $cart = Cart::with(['products' => function ($query) {
                $query->select([
                    'products.id',
                    'products.title',
                    'products.price',
                    'products.stock',
                    'products.user_id'
                ])
                    ->orderBy('cart_products.created_at', 'asc');
            }])->findOrFail($id);

            $cart->products->transform(function ($product) {
                $product->cart_product_id = $product->pivot->id;
                $product->quantity = $product->pivot->quantity;
                $product->created_at = $product->pivot->created_at;
                unset($product->pivot);
                return $product;
            });

            return $this->jsonResponse(200, ['cart' => $cart], 200);
        } catch (ModelNotFoundException $e) {
            return $this->jsonResponse(404, ['error' => 'Cart not found'], 404);
        } catch (Exception $e) {
            return $this->jsonResponse(500, ['error' => 'Internal Server Error'], 500);
        }
    }
}
