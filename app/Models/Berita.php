<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    protected $table = 'beritas';
    protected $fillable = [
        'judul',
        'slug',
        'konten',
        'thumbnail',
        'tanggal_terbit',
    ];
    protected $casts = [
        'tanggal_terbit' => 'date',
    ];
    protected static function booted()
    {
        static::creating(function ($model) {
            $model->slug = Str::slug($model->judul);
            $model->tanggal_terbit = now();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
