<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'guest_email',
        'order_date',
        'total_price',
        'status',
    ];

    protected $casts = [
        'order_date' => 'datetime',
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shippingInfo()
    {
        return $this->hasOne(ShippingInfo::class);
    }

    public function placeOrder(Request $request)
    {
        $user = Auth::user();
        $userId = $user ? $user->id : null;
        $guestEmail = !$user ? $request->email : null;

        $this->user_id = $userId;
        $this->guest_email = $guestEmail;
        $this->order_date = now();
        $this->total_price = $this->calculateTotalPrice($userId, $guestEmail);
        $this->status = 'pending';
        $this->save();

        $orderItems = OrderItem::where(function ($query) use ($userId, $guestEmail) {
            $query->where('user_id', $userId)
                  ->orWhere('guest_email', $guestEmail);
        })->where('is_ordered', false)->get();

        foreach ($orderItems as $item) {
            $item->order_id = $this->id;
            $item->is_ordered = true;
            $item->save();
        }

        return $this;
    }

    private function calculateTotalPrice($userId, $guestEmail)
    {
        return OrderItem::where(function ($query) use ($userId, $guestEmail) {
            $query->where('user_id', $userId)
                  ->orWhere('guest_email', $guestEmail);
        })->where('is_ordered', false)
          ->sum(DB::raw('quantity * price'));
    }

    public function getEmailAttribute()
    {
        return $this->user ? $this->user->email : $this->guest_email;
    }
 
}