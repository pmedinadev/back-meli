<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use Exception;
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
            $cart = Cart::find($id);

            if (!$cart) {
                return $this->jsonResponse(404, ['error' => 'Cart not found'], 404);
            }

            return $this->jsonResponse(200, ['Cart' => $cart], 200);
        } catch (Exception $e) {
            return $this->jsonResponse(500, ['error' => 'Internal Server Error'], 500);
        }
    }
}
