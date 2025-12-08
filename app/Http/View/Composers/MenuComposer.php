<?php

namespace App\Http\View\Composers;

use App\Models\Menu;
use Illuminate\View\View;

class MenuComposer
{
    public function compose(View $view)
    {
        $menus = Menu::with([
            'submenus' => function ($query) {
                $query->orderBy('urutan', 'asc');
            }
        ])
            ->orderBy('urutan', 'asc')
            ->get();

        $view->with('menus', $menus);
    }
}