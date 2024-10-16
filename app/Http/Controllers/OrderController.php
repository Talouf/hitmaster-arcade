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
        $shippingInfo = $order->shippingInfo;
        return view('orders.show', compact('order', 'shippingInfo'));
    }

    public function downloadInvoice(Order $order)
    {
        $this->authorize('view', $order);

        $order->load(['user', 'orderItems.product']); // Eager load relationships

        $logoPath = public_path('images/hitmaster.png');
        $logoData = base64_encode(file_get_contents($logoPath));
        $logoSrc = 'data:image/png;base64,' . $logoData;

        $pdf = PDF::loadView('pdf.invoice', compact('order', 'logoSrc'));
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

    // New method for admin to view order details
    public function adminShow(Order $order)
    {
        $this->authorize('viewAny', Order::class);
        return view('admin.orders.show', compact('order'));
    }
    public function adminIndex()
    {
        $this->authorize('viewAny', Order::class);
        $orders = Order::with('user')->latest()->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }
}