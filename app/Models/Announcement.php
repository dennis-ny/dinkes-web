<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'expires_at',
        'user_id',
    ];

    protected $casts = [
        'expires_at' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessor to check if announcement is active
    public function getIsActiveAttribute()
    {
        return $this->expires_at >= now()->toDateString();
    }

    // Scope to get only active announcements
    public function scopeActive($query)
    {
        return $query->where('expires_at', '>=', now()->toDateString());
    }
}
