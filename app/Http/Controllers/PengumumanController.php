<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengumumanController extends Controller
{
    public function index()
    {
        // tampilkan hanya yang masih aktif
        $pengumuman = Pengumuman::whereDate('tanggal_berakhir', '>=', now())
            ->orderByDesc('tanggal_terbit')
            ->get();

        return view('dashboard.pengumuman.index', compact('pengumuman'));
    }

    public function create()
    {
        return view('dashboard.pengumuman.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'judul' => 'required|max:255',
                'tanggal_berakhir' => 'required|date',
                'konten' => 'required'
            ]);

            if (trim(strip_tags($request->konten)) === '') {
                return back()->withInput()->with('error', 'Konten pengumuman kosong');
            }

            // pastikan user login
            $penulis = Auth::check() ? Auth::user()->name : 'Admin';

            Pengumuman::create([
                'judul' => $request->judul,
                'konten' => $request->konten,
                'tanggal_berakhir' => $request->tanggal_berakhir,
                'slug' => Str::slug($request->judul),
                'tanggal_terbit' => now(),
                'penulis' => $penulis,
            ]);

            return back()->with('success', 'Pengumuman berhasil disimpan');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048'
        ]);

        $path = $request->file('image')->store('pengumuman/images', 'public');

        return response()->json([
            'url' => asset('storage/' . $path)
        ]);
    }

    public function uploadVideo(Request $request)
    {
        $request->validate([
            'video' => 'required|mimes:mp4,mov,avi,webm|max:20480'
        ]);

        $path = $request->file('video')->store('pengumuman/videos', 'public');

        return response()->json([
            'url' => asset('storage/' . $path)
        ]);
    }

    public function show(string $slug)
    {
        $pengumuman = Pengumuman::where('slug', $slug)->first();

        if (!$pengumuman) {
            abort(404, 'Pengumuman tidak ditemukan');
        }

        return view('pengumuman.show', compact('pengumuman'));
    }
    // Edit halaman
    public function edit($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        return view('dashboard.pengumuman.edit', compact('pengumuman'));
    }

    // Update action
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'judul' => 'required|max:255',
                'tanggal_berakhir' => 'required|date',
                'konten' => 'required',
            ]);

            if (trim(strip_tags($request->konten)) === '') {
                return back()->withInput()->with('error', 'Konten pengumuman kosong');
            }

            $penulis = Auth::check() ? Auth::user()->name : 'Admin';

            $pengumuman = Pengumuman::findOrFail($id);
            $pengumuman->update([
                'judul' => $request->judul,
                'konten' => $request->konten,
                'tanggal_berakhir' => $request->tanggal_berakhir,
                'penulis' => $penulis,
                'slug' => Str::slug($request->judul),
            ]);

            return redirect()->route('admin.pengumuman.index')
                ->with('success', 'Pengumuman berhasil diperbarui');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal memperbarui: ' . $e->getMessage());
        }
    }
    public function destroy($id)
    {
        try {
            $pengumuman = Pengumuman::findOrFail($id);
            $pengumuman->delete();

            return redirect()->route('admin.pengumuman.index')
                ->with('success', 'Pengumuman berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('admin.pengumuman.index')
                ->with('error', 'Gagal menghapus pengumuman: ' . $e->getMessage());
        }
    }
}
