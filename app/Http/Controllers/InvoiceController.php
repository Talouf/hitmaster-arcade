<?php

namespace App\Http\Controllers;

use App\Models\Order;
use PDF;

class InvoiceController extends Controller
{
    public function generate($orderId)
    {
        $order = Order::with('orderItems.product', 'user')->findOrFail($orderId);
        
        $pdf = PDF::loadView('invoices.template', compact('order'));
        
        return $pdf->download('invoice-' . $order->id . '.pdf');
    }
}