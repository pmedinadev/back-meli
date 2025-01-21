<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\WebhookLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use MercadoPago\Client\MerchantOrder\MerchantOrderClient;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;

class MercadoPagoController extends Controller
{
    public function __construct()
    {
        MercadoPagoConfig::setAccessToken(config('services.mercadopago.access_token'));
    }

    const PAYMENT_STATUS = [
        'approved' => 'completed',
        'pending' => 'pending',
        'in_process' => 'processing',
        'rejected' => 'failed',
        'cancelled' => 'cancelled',
    ];

    public function handleWebhook(Request $request): JsonResponse
    {
        try {
            // Revisar si la notificación ya fue procesada
            if (WebhookLog::where('notification_id', $request->id)->exists()) {
                return response()->json(['message' => 'Notification already processed'], 201);
            }

            // Registrar la notificación
            WebhookLog::create([
                'notification_id' => $request->id,
                'topic' => $request->topic ?? 'unknown',
            ]);

            // Manejar notificaciones de merchant_order
            if ($request->topic === 'merchant_order') {
                DB::beginTransaction();

                $merchantOrderClient = new MerchantOrderClient();
                $merchantOrder = $merchantOrderClient->get($request->id);

                // Obtener pedido por mp_preference_id
                $order = Order::where('mp_preference_id', $merchantOrder->preference_id)->first();

                if (!$order) {
                    Log::error('Order not found:', ['preference_id' => $merchantOrder->preference_id]);
                    return response()->json(['error' => 'Order not found'], 404);
                }

                // Calcular el monto total pagado desde los pagos aprobados
                $paidAmount = 0;
                foreach ($merchantOrder->payments as $payment) {
                    if ($payment->status === 'approved') {
                        $paidAmount += $payment->transaction_amount;
                    }
                }

                // Si el pago es completo
                if ($paidAmount >= $merchantOrder->total_amount) {
                    // Actualizar el estado del pedido
                    $order->update([
                        'mp_payment_id' => $merchantOrder->payments[0]->id,
                        'status' => 'completed'
                    ]);

                    // Actualizar el stock de los productos
                    foreach ($order->items as $item) {
                        $product = Product::find($item->product_id);
                        $product->decrement('stock', $item->quantity);
                    }

                    // Remover los productos del carrito
                    $cart = $order->user->cart;
                    if ($cart) {
                        $productIds = $order->items->pluck('product_id');
                        $cart->products()->detach($productIds);
                    }

                    DB::commit();
                }

                return response()->json(['message' => 'Notification processed'], 200);
            }

            return response()->json(['message' => 'Notification ignored'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Webhook Error:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json(['message' => 'Webhook received with errors'], 500);
        }
    }

    public function createPreference($orderId): JsonResponse
    {
        try {
            $order = Order::with(['items.product', 'shipping.address'])->findOrFail($orderId);

            $client = new PreferenceClient();

            // Mapear los productos del pedido
            $items = $order->items->map(function ($item) {
                return [
                    'id' => $item->product->id,
                    'title' => $item->product->title,
                    'quantity' => $item->quantity,
                    'currency_id' => 'MXN',
                    'unit_price' => floatval($item->price),
                ];
            })->toArray();

            // Calcular el costo total de envío
            $totalShippingCost = $order->items->sum('shipping_cost');

            $preference = $client->create([
                'items' => $items,
                'payer' => [
                    'name' => $order->shipping->address->contact_name,
                    'email' => $order->shipping->address->contact_email,
                    'phone' => [
                        'area_code' => '52',
                        'number' => $order->shipping->address->contact_phone,
                    ],
                ],
                'shipments' => [
                    'mode' => 'not_specified',
                    'cost' => floatval($totalShippingCost),
                    'receiver_address' => [
                        'zip_code' => $order->shipping->address->zip_code,
                        'street_name' => $order->shipping->address->street_address,
                    ]
                ],
                'payment_methods' => [
                    'excluded_payment_methods' => [],
                    'excluded_payment_types' => [
                        ['id' => 'atm'],
                        ['id' => 'ticket'],
                        ['id' => 'bank_transfer']
                    ],
                    'installments' => 12
                ],
                'back_urls' => [
                    'success' => env('FRONTEND_URL') . "/checkout/success",
                    'failure' => env('FRONTEND_URL') . "/checkout/failure",
                    'pending' => env('FRONTEND_URL') . "/checkout/pending"
                ],
                'auto_return' => 'approved',
                'statement_descriptor' => 'MERCADO LIBRE',
                'external_reference' => (string)$order->id,
                'notification_url' => 'https://lqskclvp-8000.usw3.devtunnels.ms/api/webhooks/mercadopago', // URL pública para recibir notificaciones, generada usando 'Port Forwarding' de Visual Studio Code
            ]);

            $order->update(['mp_preference_id' => $preference->id]);

            return response()->json([
                'preference_id' => $preference->id
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
