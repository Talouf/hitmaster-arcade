<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'order_id', 'email', 'address', 'city', 'state', 'zip_code', 'country',
    ];
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
