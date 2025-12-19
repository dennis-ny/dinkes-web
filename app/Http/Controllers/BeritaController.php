<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function index()
    {
        $beritas = Berita::orderByDesc('tanggal_terbit')->get();
        return view('dashboard.berita.index', compact('beritas'));
    }

    public function create()
    {
        return view('dashboard.berita.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|max:255',
            'konten' => 'required',
            'thumbnail' => 'nullable|image|max:2048'
        ]);

        if (trim(strip_tags($request->konten)) === '') {
            return back()->withInput()->with('error', 'Konten berita kosong');
        }

        $thumbnailPath = $request->file('thumbnail')
            ? $request->file('thumbnail')->store('berita/thumbnails', 'public')
            : null;

        Berita::create([
            'judul' => $request->judul,
            'konten' => $request->konten,
            'thumbnail' => $thumbnailPath,
            'tanggal_terbit' => now(),
            'slug' => Str::slug($request->judul),
        ]);

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dibuat');
    }

    public function edit($id)
    {
        $berita = Berita::findOrFail($id);
        return view('dashboard.berita.edit', compact('berita'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|max:255',
            'konten' => 'required',
            'thumbnail' => 'nullable|image|max:2048'
        ]);

        if (trim(strip_tags($request->konten)) === '') {
            return back()->withInput()->with('error', 'Konten berita kosong');
        }

        $berita = Berita::findOrFail($id);

        $thumbnailPath = $request->file('thumbnail')
            ? $request->file('thumbnail')->store('berita/thumbnails', 'public')
            : $berita->thumbnail;

        $berita->update([
            'judul' => $request->judul,
            'konten' => $request->konten,
            'thumbnail' => $thumbnailPath,
            'slug' => Str::slug($request->judul),
        ]);

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diperbarui');
    }

    public function destroy($id)
    {
        $berita = Berita::findOrFail($id);
        $berita->delete();

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dihapus');
    }

    public function uploadImage(Request $request)
    {
        $request->validate(['image' => 'required|image|max:2048']);
        $path = $request->file('image')->store('berita/images', 'public');
        return response()->json(['url' => asset('storage/' . $path)]);
    }

    public function uploadVideo(Request $request)
    {
        $request->validate(['video' => 'required|mimes:mp4,mov,avi,webm|max:20480']);
        $path = $request->file('video')->store('berita/videos', 'public');
        return response()->json(['url' => asset('storage/' . $path)]);
    }

    public function show(string $slug)
    {
        $berita = Berita::where('slug', $slug)->firstOrFail();
        return view('berita.show', compact('berita'));
    }
}
