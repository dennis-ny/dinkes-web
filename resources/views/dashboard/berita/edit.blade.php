@extends('layouts.dashboard')

@section('title','Edit Berita')

@section('content')
<div class="w-full bg-white rounded shadow p-6">

    <h1 class="text-2xl font-semibold mb-6 border-b pb-3">
        Edit Berita
    </h1>

    <form id="article-form" method="POST" action="{{ route('admin.berita.update', $berita->id) }}" enctype="multipart/form-data" class="space-y-5">
        @csrf
        @method('PUT')

        {{-- JUDUL --}}
        <div>
            <label class="block text-sm font-medium mb-1">Judul Berita</label>
            <input type="text" name="judul" value="{{ old('judul', $berita->judul) }}"
                class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200"
                required>
        </div>

        {{-- TANGGAL TERBIT --}}
        <div>
            <label class="block text-sm font-medium mb-1">Tanggal Terbit</label>
            <input type="date" name="tanggal_terbit"
                   class="w-full border rounded px-3 py-2 bg-gray-100"
                   value="{{ $berita->tanggal_terbit->format('Y-m-d') }}" readonly>
        </div>

        {{-- THUMBNAIL --}}
        <div>
            <label class="block text-sm font-medium mb-1">Thumbnail</label>
            <input type="file" name="thumbnail" class="w-full">
            @if($berita->thumbnail)
                <img src="{{ asset('storage/'.$berita->thumbnail) }}" class="mt-2 w-32 h-20 object-cover rounded">
            @endif
        </div>

        {{-- KONTEN --}}
        <div>
            <label class="block text-sm font-medium mb-2">Konten Berita</label>
            <div id="editor-container" class="border rounded min-h-[350px] bg-white"></div>
            <input type="hidden" name="konten" id="content">
        </div>

        {{-- TOMBOL --}}
        <div class="flex justify-end gap-3 pt-4 border-t">
            <a href="{{ route('admin.berita.index') }}" class="px-4 py-2 rounded border text-gray-600 hover:bg-gray-100">
                Batal
            </a>
            <button type="submit" class="px-6 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">
                Update Berita
            </button>
        </div>
    </form>
</div>
@endsection

@push('styles')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const quill = new Quill('#editor-container', {
        theme: 'snow',
        modules: { toolbar: [[{ header: [1, 2, 3, false] }],['bold','italic','underline'],['link','image','video'],['clean']] }
    });

    quill.root.innerHTML = @json(old('konten', $berita->konten));

    document.querySelector('#article-form').onsubmit = function () {
        document.querySelector('#content').value = quill.root.innerHTML;
    };
});
</script>
@endpush
