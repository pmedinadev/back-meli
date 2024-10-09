<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use Exception;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
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
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $reviews = Review::all();
            return $this->jsonResponse(200, ['reviews' => $reviews], 200);
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
            'product_id' => 'integer|exists:products,id',
            'user_id' => 'integer|exists:users,id',
            'rate' => 'numeric|between:0,5',
            'review' => 'string|max:255'
        ]);

        if ($validationResponse) {
            return $validationResponse;
        }

        try {
            $review = Review::create($request->all());
            return $this->jsonResponse(201, ['message' => 'Product created successfully', 'product' => $review], 201);
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
            $review = Review::find($id);

            if (!$review) {
                return $this->jsonResponse(404, ['error' => 'Review not found'], 404);
            }

            return $this->jsonResponse(200, ['reviews' => $review], 200);
        } catch (Exception $e) {
            return $this->jsonResponse(500, ['error' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validationResponse = $this->validateRequest($request, [
            'product_id' => 'required|integer|exists:products,id',
            'user_id' => 'required|integer|exists:users,id',
            'rate' => 'sometimes|numeric|between:0,5',
            'review' => 'sometimes|string|max:255'
        ]);

        if ($validationResponse) {
            return $validationResponse;
        }

        try {
            $review = Review::find($id);

            if (!$review) {
                return $this->jsonResponse(404, ['error' => 'Review not found'], 404);
            }

            $review->update($request->all());
            return $this->jsonResponse(200, ['message' => 'Review updated successfully', 'review' => $review], 200);
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
            $review = Review::find($id);

            if (!$review) {
                return $this->jsonResponse(404, ['error' => 'Review not found'], 404);
            }

            $review->delete();
            return $this->jsonResponse(200, ['message' => 'Review deleted successfully'], 200);
        } catch (Exception $e) {
            return $this->jsonResponse(500, ['error' => 'Internal Server Error'], 500);
        }
    }
}
