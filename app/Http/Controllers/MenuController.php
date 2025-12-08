<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $menus = Menu::when($search, function ($query, $search) {
            $query->where('nama_menu', 'like', "%{$search}%")
                ->orWhere('link', 'like', "%{$search}%");
        })
            ->orderBy('urutan', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view('dashboard.menu', compact('search', 'menus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_menu' => 'required|string|max:255',
            'urutan' => 'required|integer',
            'link' => 'nullable|string|max:255',
        ]);

        Menu::create([
            'nama_menu' => $request->nama_menu,
            'urutan' => $request->urutan,
            'link' => $request->link,
        ]);

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'nama_menu' => 'required|string|max:255',
            'urutan' => 'required|integer',
            'link' => 'nullable|string|max:255',
        ]);

        $menu->update([
            'nama_menu' => $request->nama_menu,
            'urutan' => $request->urutan,
            'link' => $request->link,
        ]);

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();
        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil dihapus.');
    }
}
