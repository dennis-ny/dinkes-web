@extends('layouts.public')

@section('title', 'Daftar Berita - Dinas Kesehatan Kota Kediri')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header Section --}}
        <div class="mb-12 text-center">
            <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight sm:text-5xl mb-4 text-brand">
                Berita Terbaru
            </h1>
            <p class="max-w-2xl mx-auto text-lg text-gray-600">
                Update informasi terkini seputar kegiatan dan layanan Dinas Kesehatan Kota Kediri.
            </p>
        </div>

        {{-- Top Bar: Search & Sort --}}
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 mb-12">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-6">
                {{-- Search --}}
                <div class="w-full lg:max-w-md relative">
                    <form action="{{ route('public.news.index') }}" method="GET">
                        <input type="text" name="search" value="{{ request('search') }}" 
                            placeholder="Cari berita..." 
                            class="w-full pl-12 pr-4 py-3 bg-gray-50 border-gray-200 rounded-2xl focus:ring-brand focus:border-brand transition-all">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                    </form>
                </div>

                {{-- Stats & Sort --}}
                <div class="flex items-center gap-6 w-full lg:w-auto">
                    <p class="text-gray-500 text-sm hidden sm:block">
                        Menampilkan <span class="font-bold text-gray-900">{{ $news->total() }}</span> berita
                    </p>
                    <div class="flex items-center gap-3 ml-auto lg:ml-0">
                        <span class="text-sm font-semibold text-gray-700">Urutkan:</span>
                        <div class="relative inline-block">
                            <form action="{{ route('public.news.index') }}" method="GET" id="sortForm">
                                <input type="hidden" name="search" value="{{ request('search') }}">
                                <select name="sort" onchange="document.getElementById('sortForm').submit()"
                                    class="bg-gray-50 border border-gray-100 text-gray-700 text-sm rounded-2xl focus:ring-brand focus:border-brand block w-40 p-3 pr-10 appearance-none shadow-sm cursor-pointer transition-all">
                                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                                    <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Terpopuler</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- News Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            @forelse($news as $item)
                <article class="flex flex-col group h-full">
                    <div class="relative aspect-[16/10] rounded-3xl overflow-hidden mb-6 shadow-lg shadow-gray-200/50">
                        @if($item->thumbnail)
                            <img src="{{ Storage::url($item->thumbnail) }}" alt="{{ $item->title }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        @else
                            <div class="w-full h-full bg-emerald-50 flex items-center justify-center">
                                <svg class="w-16 h-16 text-emerald-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                            </div>
                        @endif
                        <div class="absolute bottom-4 right-4 translate-y-12 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300">
                            <a href="{{ route('news.show', $item) }}" class="p-3 bg-white text-brand rounded-2xl shadow-xl flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 text-sm text-gray-400 mb-4 font-medium">
                        <span class="px-3 py-1 bg-brand/10 text-brand rounded-full text-xs font-bold leading-none">BERITA</span>
                        <span>•</span>
                        <span>{{ $item->created_at->format('d M Y') }}</span>
                        <span>•</span>
                        <span>{{ number_format($item->views) }} Views</span>
                    </div>

                    <h2 class="text-2xl font-bold text-gray-900 mb-4 line-clamp-2 leading-tight group-hover:text-brand transition-colors">
                        <a href="{{ route('news.show', $item) }}">{{ $item->title }}</a>
                    </h2>

                    <p class="text-gray-500 mb-6 line-clamp-3 leading-relaxed">
                        {{ Str::limit(strip_tags($item->content), 120) }}
                    </p>

                    <div class="mt-auto flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-emerald-100 border-2 border-white shadow-sm flex items-center justify-center text-emerald-600 font-bold text-sm">
                            {{ substr($item->user->name ?? 'A', 0, 1) }}
                        </div>
                        <div class="flex flex-col">
                            <span class="text-sm font-bold text-gray-900 leading-tight">{{ $item->user->name ?? 'Admin' }}</span>
                            <span class="text-xs text-gray-500">Kontributor</span>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-full py-24 text-center">
                    <div class="max-w-md mx-auto">
                        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2"/></svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Belum ada berita</h3>
                        <p class="text-gray-500 mb-8">Tidak ditemukan berita untuk kriteria pencarian Anda.</p>
                        <a href="{{ route('public.news.index') }}" class="inline-flex items-center px-8 py-3 bg-brand text-white rounded-2xl font-bold hover:bg-brand-dark transition-all">
                            Kembali ke Semua Berita
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-20">
            {{ $news->links() }}
        </div>
    </div>
</div>
@endsection
