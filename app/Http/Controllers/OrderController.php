<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use PDF;
use Illuminate\Support\Facades\Auth;


class OrderController extends Controller
{
    use AuthorizesRequests;

    public function show(Order $order)
    {
        $this->authorize('view', $order);
        return view('orders.show', compact('order'));
    }

    public function downloadInvoice(Order $order)
    {
        $this->authorize('view', $order);
        
        $pdf = PDF::loadView('pdf.invoice', compact('order'));
        return $pdf->download('invoice-' . $order->id . '.pdf');
    }

    public function userOrders()
    {
        $orders = auth()->user()->orders()->latest()->paginate(10);
        return view('profile.orders', compact('orders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required_if:user_id,null|email',
        ]);

        $order = new Order();
        $newOrder = $order->placeOrder($request);

        if ($newOrder) {
            return redirect()->route('orders.show', $newOrder)->with('success', 'Order placed successfully!');
        } else {
            return back()->with('error', 'Failed to place order. Please try again.');
        }
    }
}