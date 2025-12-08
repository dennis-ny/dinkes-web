<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Submenu extends Model
{
    use HasFactory;

    protected $table = 'submenus';

    protected $fillable = [
        'nama_submenu',
        'link',
        'urutan',
        'menu_id',
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
