<?php

// app/Models/Product.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'price', 'image',
    ];

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function home()
{
    $latestProducts = Product::latest()->take(2)->get();
    return view('home', compact('latestProducts'));
}
}


