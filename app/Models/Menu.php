<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menus';

    protected $fillable = [
        'nama_menu',
        'urutan',
        'link',
    ];

    public function submenus()
    {
        return $this->hasMany(Submenu::class, 'menu_id');
    }
}
