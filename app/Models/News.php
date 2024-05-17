<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin; // Importez le modèle Admin

class News extends Model
{
    use HasFactory;

    protected $fillable = ['admin_id', 'title', 'content', 'post_date'];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}



