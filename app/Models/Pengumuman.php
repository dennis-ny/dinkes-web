<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Pengumuman extends Model
{
    protected $table = 'pengumumen';

    protected $fillable = [
        'judul',
        'konten',
        'penulis',
        'slug',
        'tanggal_terbit',
        'tanggal_berakhir',
    ];

    protected $casts = [
        'tanggal_terbit' => 'date',
        'tanggal_berakhir' => 'date',
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
