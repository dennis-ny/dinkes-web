@extends('layouts.public')

@section('title', $pengumuman->judul)

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white rounded shadow">

    <h1 class="text-3xl font-bold mb-2">
        {{ $pengumuman->judul }}
    </h1>

    <div class="text-sm text-gray-600 mb-4">
        Ditulis oleh <b>{{ $pengumuman->penulis }}</b> |
        Terbit: {{ $pengumuman->tanggal_terbit->format('d M Y') }}
    </div>

    <hr class="mb-4">

    {{-- KONTEN DARI QUILL --}}
    <div class="prose max-w-none">
        {!! $pengumuman->konten !!}
    </div>

    <div class="mt-6 text-sm text-gray-500">
        Berlaku sampai: {{ $pengumuman->tanggal_berakhir->format('d M Y') }}
    </div>
</div>
@endsection
