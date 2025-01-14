<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Favorite;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class FavoriteController extends Controller
{
    private function getRules(): array
    {
        return ['user_id' => 'required|integer|exists:users,id'];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate($this->getRules());

            DB::beginTransaction();

            $favorite = Favorite::create($validated);

            DB::commit();

            return response()->json([
                'message' => 'Lista de favoritos creada correctamente',
                'favorite' => $favorite,
            ], Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error al crear la lista de favoritos',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        try {
            $favorite = Favorite::with(['products' => function ($query) {
                $query->select([
                    'products.id',
                    'products.title',
                    'products.price',
                    'products.stock',
                    'products.user_id',
                ])->orderBy('favorite_products.created_at', 'asc');
            }])->findOrFail($id);

            $favorite->products->transform(function ($product) {
                $product->favorite_product_id = $product->pivot->id;
                $product->created_at = $product->pivot->created_at;
                unset($product->pivot);
                return $product;
            });

            return response()->json(['favorite' => $favorite]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Lista de favoritos no encontrada'
            ], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error al obtener la lista de favoritos',
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

            $favorite = Favorite::findOrFail($id);
            $favorite->delete();

            DB::commit();

            return response()->json([
                'message' => 'Lista de favoritos eliminada correctamente'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Lista de favoritos no encontrada'
            ], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error al eliminar la lista de favoritos',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
