<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Notifications\Notifiable;

class NewsletterSubscription extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'newsletter_subscriptions';

    protected $fillable = ['user_id', 'email', 'token', 'subscription_date', 'is_active'];

    protected $casts = [
        'subscription_date' => 'date',
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($subscription) {
            $subscription->token = Str::random(32);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function findByEmail($email)
    {
        return self::where('email', $email)->first();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}