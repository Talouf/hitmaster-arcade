<?php

// app/Models/News.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class News extends Model
{
    use HasFactory;

    protected $fillable = ['admin_id', 'title', 'content', 'post_date', 'image'];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function getImageUrlAttribute()
{
    return $this->image ? asset('images/' . $this->image) : asset('images/default-image.png');
}
}





