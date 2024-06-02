<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Webhook;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->server('HTTP_STRIPE_SIGNATURE');
        $endpointSecret = env('STRIPE_WEBHOOK_SECRET');

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $endpointSecret);

            if ($event->type === 'checkout.session.completed') {
                $session = $event->data->object;

                // Handle the successful payment
                $this->handleCheckoutSession($session);
            }

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            Log::error('Stripe webhook error: ' . $e->getMessage());
            return response()->json(['status' => 'failed', 'message' => $e->getMessage()], 400);
        }
    }

    protected function handleCheckoutSession($session)
    {
        $email = $session->customer_details->email;

        // Mark the order items as ordered
        OrderItem::where('user_id', $session->client_reference_id)
            ->where('is_ordered', false)
            ->update([
                'is_ordered' => true,
                'email' => $email
            ]);
    }
}
