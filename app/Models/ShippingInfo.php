<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingInfo extends Model
{
    use HasFactory;

    protected $table = 'shipping_info'; // Explicitly set the table name

    protected $fillable = [
        'user_id',
        'order_id',
        'name',
        'address',
        'city',
        'state',
        'zip_code',
        'country',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}