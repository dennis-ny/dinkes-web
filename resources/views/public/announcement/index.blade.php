@extends('layouts.public')

@section('title', 'Pusat Pengumuman - Dinas Kesehatan Kota Kediri')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header Section --}}
        <div class="mb-12 text-center">
            <span class="inline-block px-4 py-1.5 bg-orange-100 text-orange-700 text-xs font-bold rounded-full mb-4 tracking-widest uppercase">Pusat Informasi</span>
            <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight sm:text-5xl mb-4">
                Pengumuman Resmi
            </h1>
            <p class="max-w-2xl mx-auto text-lg text-gray-600">
                Informasi penting, edaran, dan pengumuman terbaru dari Dinas Kesehatan Kota Kediri.
            </p>
        </div>

        {{-- Search Bar --}}
        <div class="mb-12">
            <form action="{{ route('public.announcement.index') }}" method="GET" class="relative group">
                <input type="text" name="search" value="{{ request('search') }}" 
                    placeholder="Cari kata kunci pengumuman..." 
                    class="w-full pl-16 pr-6 py-5 bg-white border-2 border-transparent shadow-xl shadow-gray-200/50 rounded-3xl focus:ring-0 focus:border-brand transition-all text-lg placeholder-gray-400">
                <div class="absolute left-6 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-brand transition-colors">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
            </form>
        </div>

        {{-- Announcement List --}}
        <div class="space-y-6">
            @forelse($announcements as $announcement)
                <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100 hover:shadow-xl hover:border-brand/20 transition-all duration-300 group relative overflow-hidden">
                    {{-- Decorative Accent --}}
                    <div class="absolute top-0 left-0 w-2 h-full bg-orange-400 group-hover:bg-brand transition-colors"></div>

                    <div class="flex flex-col md:flex-row md:items-start justify-between gap-6">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-4">
                                <span class="text-xs font-bold text-gray-400 flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    {{ $announcement->created_at->format('d M Y') }}
                                </span>
                                <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                                <span class="bg-orange-50 text-orange-600 text-[10px] font-extrabold px-2 py-0.5 rounded tracking-wide uppercase">PENTING</span>
                            </div>

                            <h2 class="text-2xl font-bold text-gray-900 group-hover:text-brand transition-colors mb-3 leading-tight">
                                <a href="{{ route('announcement.show', $announcement) }}">{{ $announcement->title }}</a>
                            </h2>

                            <p class="text-gray-500 line-clamp-2 mb-6 leading-relaxed">
                                {{ Str::limit(strip_tags($announcement->content), 180) }}
                            </p>

                            <div class="flex flex-wrap items-center gap-4 text-sm">
                                <div class="flex items-center gap-2 px-3 py-1.5 bg-gray-50 rounded-xl text-gray-500 border border-gray-100">
                                    <svg class="w-4 h-4 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span class="font-medium">Berlaku sampai:</span>
                                    <span class="font-bold text-gray-700">{{ $announcement->expires_at->format('d M Y') }}</span>
                                </div>
                                <a href="{{ route('announcement.show', $announcement) }}" class="inline-flex items-center gap-2 text-brand font-bold hover:gap-3 transition-all">
                                    Baca Selengkapnya
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="py-20 text-center bg-white rounded-3xl border border-dashed border-gray-200">
                    <svg class="w-20 h-20 text-gray-200 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Tidak ada pengumuman</h3>
                    <p class="text-gray-500">Saat ini tidak ditemukan pengumuman aktif untuk kriteria tersebut.</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-12">
            {{ $announcements->links() }}
        </div>
    </div>
</div>
@endsection
