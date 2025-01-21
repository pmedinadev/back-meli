<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $orders = $request->user()
                ->orders()
                ->with(['items.product', 'shipping.address'])
                ->latest()
                ->get();

            return response()->json(['orders' => $orders]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error al obtener las órdenes',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $order = Order::create([
                'user_id' => $request->user()->id,
                'total_amount' => 0, // Será calculado más adelante
                'expires_at' => now()->addMinutes(10),
            ]);

            // Crear pedido desde el carrito
            if ($request->from_cart) {
                $cartItems = $request->user()
                    ->cart
                    ->products()
                    ->select(['products.*'])
                    ->whereIn('user_id', $request->selected_sellers)
                    ->get();

                // Calcular el monto total de los productos
                $totalProductsAmount = $cartItems->sum(function ($item) {
                    return $item->price * $item->pivot->quantity;
                });

                // Verificar si el pedido califica para envío gratis
                $qualifiesForFreeShipping = $totalProductsAmount >= 299;

                // Crear items del pedido
                foreach ($cartItems as $item) {
                    $quantity = $item->pivot->quantity;
                    $shippingCost = $item->shipping_type === 'paid_by_buyer' && !$qualifiesForFreeShipping
                        ? floatval($item->shipping_cost)
                        : 0;

                    $subtotal = ($item->price * $quantity) + $shippingCost;

                    $orderItem = $order->items()->create([
                        'product_id' => $item->id,
                        'seller_id' => $item->user_id,
                        'quantity' => $quantity,
                        'price' => $item->price,
                        'shipping_cost' => $shippingCost,
                        'subtotal' => $subtotal,
                    ]);
                }
            }
            // Crear pedido desde el detalle del producto
            else {
                $product = Product::findOrFail($request->product_id);
                $quantity = $request->quantity;

                // Revisar si el pedido califica para envío gratis
                $totalProductAmount = $product->price * $quantity;
                $qualifiesForFreeShipping = $totalProductAmount >= 299;

                $shippingCost = $product->shipping_type === 'paid_by_buyer' && !$qualifiesForFreeShipping
                    ? floatval($product->shipping_cost)
                    : 0;

                $subtotal = $totalProductAmount + $shippingCost;

                $orderItem = $order->items()->create([
                    'product_id' => $product->id,
                    'seller_id' => $product->user_id,
                    'quantity' => $quantity,
                    'price' => $product->price,
                    'shipping_cost' => $shippingCost,
                    'subtotal' => $subtotal,
                ]);
            }

            // Calcular el total del pedido
            $order->update([
                'total_amount' => $order->items()->sum('subtotal')
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Pedido creado correctamente',
                'order' => $order->load('items')
            ], Response::HTTP_CREATED);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Order Creation Error:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'message' => 'Error al crear el pedido',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id): JsonResponse
    {
        try {
            $order = Order::findOrFail($id);

            if ($order->user_id !== $request->user()->id) {
                return response()->json([
                    'message' => 'No autorizado',
                ], Response::HTTP_FORBIDDEN);
            }

            $order->load(['items.product', 'shipping.address']);

            return response()->json(['order' => $order]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error al obtener la orden',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function showItem(Request $request, $orderId, $productId): JsonResponse
    {
        try {
            $orderItem = OrderItem::with([
                'order.shipping.address',
                'product.photos',
                'seller'
            ])
                ->where('order_id', $orderId)
                ->where('product_id', $productId)
                ->firstOrFail();

            // Verificar si el usuario es el dueño del pedido
            if ($orderItem->order->user_id !== $request->user()->id) {
                return response()->json([
                    'message' => 'No autorizado',
                ], Response::HTTP_FORBIDDEN);
            }

            return response()->json([
                'orderItem' => $orderItem
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error al obtener el detalle del producto',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateShipping(Request $request, $id): JsonResponse
    {
        try {
            $order = Order::findOrFail($id);

            if ($order->user_id !== $request->user()->id) {
                return response()->json([
                    'message' => 'No autorizado',
                ], Response::HTTP_FORBIDDEN);
            }

            $validated = $request->validate([
                'address_id' => 'required|exists:user_addresses,id',
            ]);

            // Crear o actualizar envío con estado inicial
            $shipping = $order->shipping()->updateOrCreate(
                ['order_id' => $order->id],
                [
                    'address_id' => $validated['address_id'],
                    'delivery_status' => 'pending',
                    'estimated_delivery_date' => now()->addDay(),
                    'tracking_number' => 'ML' . str_pad($order->id, 8, '0', STR_PAD_LEFT),
                    'delivery_notes' => 'Tu pedido se está preparando',
                ]
            );

            $order->load('items.product', 'shipping.address');

            return response()->json([
                'message' => 'Envío actualizado correctamente',
                'shipping' => $shipping
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar el envío',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateDeliveryStatus(Request $request, $id): JsonResponse
    {
        try {
            $order = Order::findOrFail($id);
            $shipping = $order->shipping;

            if (!$shipping) {
                return response()->json([
                    'message' => 'Envío no encontrado'
                ], Response::HTTP_NOT_FOUND);
            }

            $validated = $request->validate([
                'delivery_status' => 'required|in:pending,in_transit,delivered,cancelled,returned',
                'delivery_notes' => 'nullable|string'
            ]);

            $shipping->update([
                'delivery_status' => $validated['delivery_status'],
                'delivery_notes' => $validated['delivery_notes'],
                'delivered_at' => $validated['delivery_status'] === 'delivered' ? now() : null
            ]);

            return response()->json([
                'message' => 'Estado de envío actualizado',
                'shipping' => $shipping
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar el estado del envío',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
