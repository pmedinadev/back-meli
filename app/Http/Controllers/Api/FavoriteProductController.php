<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FavoriteProduct;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class FavoriteProductController extends Controller
{
    private function getRules(): array
    {
        return [
            'favorite_id' => 'required|integer|exists:favorites,id',
            'product_id' => 'required|integer|exists:products,id'
        ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate($this->getRules());

            DB::beginTransaction();

            $favoriteProduct = FavoriteProduct::create($validated);

            DB::commit();

            return response()->json([
                'message' => 'Producto agregado a favoritos correctamente',
                'favorite_product' => $favoriteProduct
            ], Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error al agregar el producto a favoritos',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        try {
            $favoriteProduct = FavoriteProduct::findOrFail($id);

            return response()->json([
                'favorite_product' => $favoriteProduct
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Producto favorito no encontrado'
            ], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error al obtener el producto favorito',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            DB::beginTransaction();

            $favoriteProduct = FavoriteProduct::findOrFail($id);
            $favoriteProduct->delete();

            DB::commit();

            return response()->json([
                'message' => 'Producto eliminado de favoritos correctamente'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Producto favorito no encontrado'
            ], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error al eliminar el producto de favoritos',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
