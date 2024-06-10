<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request; // Add this line to import the Request class

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'email', 'order_date', 'total_price',
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function placeOrder(Request $request)
    {
        $user = auth()->user();
    
        // Create a new order
        $order = new Order();
        $order->user_id = $user->id;
        $order->email = $user->email;
        $order->order_date = now();
        $order->total_price = $this->calculateTotalPrice($user->id); // Implement this method to calculate the total price
        $order->save();
    
        // Log the order creation
        \Log::info('Order created', ['order_id' => $order->id]);
    
        // Update order items to link them to the new order
        $updated = OrderItem::where('user_id', $user->id)
            ->where('is_ordered', false)
            ->update(['order_id' => $order->id, 'is_ordered' => true]);
    
        // Log the update result
        \Log::info('Order items updated', ['updated' => $updated]);
    
        // Additional logic for order placement (e.g., sending confirmation email)
    
        return redirect()->route('order.success')->with('success', 'Order placed successfully.');
    }
}