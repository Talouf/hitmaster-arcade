<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'title_en',
        'title_fr',
        'content_en',
        'content_fr',
        'post_date',
        'image'
    ];

    protected $dates = ['post_date'];

    protected $casts = [
        'post_date' => 'datetime',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function getLocalizedTitleAttribute()
    {
        $locale = App::getLocale();
        Log::info("Getting localized title. App Locale: " . $locale);
        return $locale == 'en' ? $this->title_en : $this->title_fr;
    }

    public function getLocalizedContentAttribute()
    {
        $locale = App::getLocale();
        Log::info("Getting localized content. App Locale: " . $locale);
        return $locale == 'en' ? $this->content_en : $this->content_fr;
    }

    public function getImageUrlAttribute()
    {
        if ($this->image && Storage::disk('public')->exists($this->image)) {
            return asset('storage/' . $this->image);
        }
        return asset('images/default-image.png'); // Adjust this path as needed
    }

    public function getExcerptAttribute($length = 100)
    {
        return Str::limit(strip_tags($this->localized_content), $length);
    }

    public function scopePublished($query)
    {
        return $query->where('post_date', '<=', now());
    }

    public function scopeRecent($query, $limit = 5)
    {
        return $query->orderBy('post_date', 'desc')->limit($limit);
    }

    public function isPublished()
    {
        return $this->post_date <= now();
    }

    public function getRouteKeyName()
    {
        return 'id';
    }
}