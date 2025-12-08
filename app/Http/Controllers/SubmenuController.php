<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Submenu;
use Illuminate\Http\Request;

class SubmenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $submenus = Submenu::join('menus', 'submenus.menu_id', '=', 'menus.id')
            ->when($search, function ($query) use ($search) {
                $query->where('submenus.nama_submenu', 'like', "%{$search}%")
                    ->orWhere('submenus.link', 'like', "%{$search}%")
                    ->orWhere('menus.nama_menu', 'like', "%{$search}%");
            })
            ->orderBy('menus.urutan', 'asc')
            ->orderBy('submenus.urutan', 'asc')
            ->select('submenus.*')
            ->paginate(10)
            ->withQueryString();

        $menus = Menu::whereNull('link')
            ->orWhere('link', '')
            ->orderBy('urutan')
            ->get();

        return view('dashboard.submenu', compact('search', 'submenus', 'menus'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_submenu' => 'required|string|max:255',
            'link' => 'required|string|max:255',
            'urutan' => 'required|integer',
            'menu_id' => 'required|exists:menus,id',
        ]);

        Submenu::create([
            'nama_submenu' => $request->nama_submenu,
            'link' => $request->link,
            'urutan' => $request->urutan,
            'menu_id' => $request->menu_id,
        ]);

        return redirect()->route('admin.submenu.index')->with('success', 'Submenu berhasil ditambahkan.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Submenu $submenu)
    {
        $request->validate([
            'nama_submenu' => 'required|string|max:255',
            'link' => 'required|string|max:255',
            'urutan' => 'required|integer',
            'menu_id' => 'required|exists:menus,id',
        ]);

        $submenu->update([
            'nama_submenu' => $request->nama_submenu,
            'link' => $request->link,
            'urutan' => $request->urutan,
            'menu_id' => $request->menu_id,
        ]);

        return redirect()->route('admin.submenu.index')->with('success', 'Submenu berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Submenu $submenu)
    {
        $submenu->delete();
        return redirect()->route('admin.submenu.index')->with('success', 'Submenu berhasil dihapus.');
    }
}