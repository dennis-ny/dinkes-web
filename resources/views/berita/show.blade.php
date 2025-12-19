@extends('layouts.public')

@section('title', $berita->judul)

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white rounded shadow">
    {{-- Thumbnail --}}
    @if($berita->thumbnail)
        <div class="mb-4">
            <img src="{{ asset('storage/'.$berita->thumbnail) }}" 
                 alt="Thumbnail {{ $berita->judul }}" 
                 class="w-full h-auto rounded shadow-sm object-cover">
        </div>
    @endif
     {{-- Judul --}}
    <h1 class="text-3xl font-bold mb-4">
        {{ $berita->judul }}
    </h1>{{-- Info --}}
    <div class="text-sm text-gray-600 mb-4">
        Terbit: {{ $berita->tanggal_terbit->format('d M Y') }}
    </div>
    
    <hr class="mb-4">

    {{-- Konten --}}
    <div class="prose max-w-none">
        {!! $berita->konten !!}
    </div>

</div>
@endsection
