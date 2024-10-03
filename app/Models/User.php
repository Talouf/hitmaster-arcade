<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nickname',
        'name',
        'surname',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function shippingInfos()
    {
        return $this->hasMany(ShippingInfo::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function transferGuestOrders()
    {
        $guestOrders = Order::where('guest_email', $this->email)->whereNull('user_id')->get();

        foreach ($guestOrders as $order) {
            $order->update([
                'user_id' => $this->id,
                'guest_email' => null
            ]);
        }
    }
}