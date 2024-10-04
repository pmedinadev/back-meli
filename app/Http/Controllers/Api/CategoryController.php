<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return response()->json($categories, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $category = Category::create([
            'name' => $request->name
        ]);

        $data = [
            'status' => 201,
            'message' => 'Category created successfully!',
            'category' => $category
        ];

        return response()->json($data, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::find($id);

        if(!$category) {
            $data = [
                'status' => 404,
                'error' => 'Category not found'
            ];

            return response()->json($data, 404);
        }

        $data = [
            'status' => 200,
            'student' => $category
        ];

        return response()->json($data, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::find($id);

        if(!$category) {
            $data = [
                'status' => 404,
                'error' => 'Category not found'
            ];

            return response()->json($data, 404);
        }

        $category->name = $request->name;

        $category->save();

        $data = [
            'status' => 200,
            'message' => 'Category updated successfully!',
            'student' => $category
        ];

        return response()->json($data, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);

        if(!$category) {
            $data = [
                'status' => 404,
                'error' => 'Category not found'
            ];

            return response()->json($data, 404);
        }

        $category->delete();

        $data = [
            'status' => 200,
            'message' => 'Category deleted successfully!'
        ];

        return response()->json($data, 200);
    }
}
