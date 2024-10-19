<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Exception;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
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
            $categories = Category::all();
            return $this->jsonResponse(200, ['categories' => $categories], 200);
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
            'name' =>'required|string|max:255',
        ]);

        if ($validationResponse) {
            return $validationResponse;
        }

        try {
            $category = Category::create($request->all());
            return $this->jsonResponse(201, ['message' => 'Category created successfully', 'category' => $category], 201);
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
            $category = Category::find($id);

            if (!$category) {
                return $this->jsonResponse(404, ['error' => 'Category not found'], 404);
            }

            return $this->jsonResponse(200, ['category' => $category], 200);
        } catch (Exception $e) {
            return $this->jsonResponse(500, ['error' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::find($id);

        $validationResponse = $this->validateRequest($request, [
            'name' => 'sometimes|string|max:255'
        ]);

        if ($validationResponse) {
            return $validationResponse;
        }

        try {
            $category = Category::find($id);

            if (!$category) {
                return $this->jsonResponse(404, ['error' => 'Category not found'], 404);
            }

            $category->update($request->all());
            return $this->jsonResponse(200, ['message' => 'Category updated successfully', 'category' => $category], 200);
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
            $category = Category::find($id);

            if (!$category) {
                return $this->jsonResponse(404, ['error' => 'Category not found'], 404);
            }

            $category->delete();
            return $this->jsonResponse(200, ['message' => 'Category deleted successfully'], 200);
        } catch (Exception $e) {
            return $this->jsonResponse(500, ['error' => 'Internal Server Error'], 500);
        }
    }
}
