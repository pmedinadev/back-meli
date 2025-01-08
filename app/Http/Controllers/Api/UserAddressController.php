<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserAddress;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UserAddressController extends Controller
{
    private function getRules(): array
    {
        return [
            'street_address' => 'required|string|max:255',
            'no_street_number' => 'boolean',
            'zip_code' => 'required_without:unknown_zip_code|string|size:5',
            'unknown_zip_code' => 'boolean',
            'state' => 'required|string|max:255',
            'municipality' => 'required|string|max:255',
            'locality' => 'required|string|max:255',
            'neighborhood' => 'required|string|max:255',
            'interior_number' => 'nullable|string|max:255',
            'delivery_instructions' => 'nullable|string',
            'address_type' => ['required', Rule::in(['residential', 'business'])],
            'contact_name' => 'required|string|max:255',
            'contact_phone' => 'required|string|max:15',
            'is_default' => 'boolean'
        ];
    }

    private function getUpdateRules(): array
    {
        return [
            'street_address' => 'string|max:255',
            'no_street_number' => 'boolean',
            'zip_code' => 'string|size:5',
            'unknown_zip_code' => 'boolean',
            'state' => 'string|max:255',
            'municipality' => 'string|max:255',
            'locality' => 'string|max:255',
            'neighborhood' => 'string|max:255',
            'interior_number' => 'nullable|string|max:255',
            'delivery_instructions' => 'nullable|string',
            'address_type' => Rule::in(['residential', 'business']),
            'contact_name' => 'string|max:255',
            'contact_phone' => 'string|max:15',
            'is_default' => 'boolean'
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            return response()->json([
                'addresses' => $request->user()->addresses()->get()
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error al obtener las direcciones',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate($this->getRules());

            DB::beginTransaction();

            if ($validated['is_default'] ?? false) {
                $request->user()->addresses()->update(['is_default' => false]);
            }

            $address = $request->user()->addresses()->create($validated);

            DB::commit();

            return response()->json([
                'message' => 'Dirección guardada correctamente',
                'address' => $address
            ], Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error al guardar la dirección',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, UserAddress $address): JsonResponse
    {
        if ($address->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'No autorizado para ver esta dirección'
            ], Response::HTTP_FORBIDDEN);
        }

        try {
            return response()->json([
                'address' => $address
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error al obtener la dirección',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserAddress $address): JsonResponse
    {
        if ($address->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'No autorizado para actualizar esta dirección'
            ], Response::HTTP_FORBIDDEN);
        }

        try {
            $validated = $request->validate(
                array_intersect_key(
                    $this->getUpdateRules(),
                    $request->all()
                )
            );

            DB::beginTransaction();

            if ($validated['is_default'] ?? false) {
                $request->user()->addresses()
                    ->where('id', '!=', $address->id)
                    ->update(['is_default' => false]);
            }

            $address->update($validated);

            DB::commit();

            return response()->json([
                'message' => 'Dirección actualizada correctamente',
                'address' => $address
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error al actualizar la dirección',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, UserAddress $address): JsonResponse
    {
        if ($address->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'No autorizado para eliminar esta dirección'
            ], Response::HTTP_FORBIDDEN);
        }

        try {
            DB::beginTransaction();
            $address->delete();
            DB::commit();

            return response()->json([
                'message' => 'Dirección eliminada correctamente'
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error al eliminar la dirección',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
