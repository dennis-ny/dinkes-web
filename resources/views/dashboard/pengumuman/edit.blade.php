@extends('layouts.dashboard')

@section('title','Edit Pengumuman')

@section('content')
<div class="w-full bg-white rounded shadow p-6">

    <h1 class="text-2xl font-semibold mb-6 border-b pb-3">Edit Pengumuman</h1>

    {{-- Notifikasi --}}
    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            ✅ {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            ❌ {{ session('error') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            <ul class="list-disc ml-5">
                @foreach ($errors->all() as $error)
                    <li>⚠️ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="article-form" method="POST" action="{{ route('admin.pengumuman.update', $pengumuman->id) }}">
        @csrf
        @method('PUT')

        {{-- Judul --}}
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Judul</label>
            <input type="text" name="judul"
                   class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200"
                   value="{{ old('judul', $pengumuman->judul) }}" required>
        </div>

        {{-- Penulis --}}
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Penulis</label>
            <input type="text" name="penulis"
                   class="w-full border rounded px-3 py-2 bg-gray-100"
                   value="{{ auth()->user()->name ?? $pengumuman->penulis }}" readonly>
        </div>

        {{-- Tanggal Berakhir --}}
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Tanggal Berakhir</label>
            <input type="date" name="tanggal_berakhir"
                   class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200"
                   value="{{ old('tanggal_berakhir', $pengumuman->tanggal_berakhir->format('Y-m-d')) }}" required>
        </div>

        {{-- Konten --}}
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Konten</label>
            <div id="editor-container" class="border rounded min-h-[350px] bg-white">
                {!! old('konten', $pengumuman->konten) !!}
            </div>
            <input type="hidden" name="konten" id="content">
        </div>

        {{-- Tombol --}}
        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.pengumuman.index') }}"
               class="px-4 py-2 rounded border hover:bg-gray-100">Batal</a>
            <button type="submit" class="px-6 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">
                Simpan
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
<script src="https://unpkg.com/quill-image-resize-module@3.0.0/image-resize.min.js"></script>

<script>
let BlockEmbed = Quill.import('blots/block/embed');

class VideoBlot extends BlockEmbed {
    static create(url) {
        let node = super.create();
        node.setAttribute('src', url);
        node.setAttribute('controls', '');
        node.style.width = '100%';
        return node;
    }
    static value(node) {
        return node.getAttribute('src');
    }
}

VideoBlot.blotName = 'video';
VideoBlot.tagName = 'video';
Quill.register(VideoBlot);

const quill = new Quill('#editor-container', {
    theme: 'snow',
    modules: {
        imageResize: { displaySize: true },
        toolbar: {
            container: [
                [{ header: [1,2,3,false] }],
                ['bold','italic','underline','strike'],
                ['blockquote','code-block'],
                [{ list:'ordered'},{list:'bullet' }],
                [{ align: [] }],
                ['link','image','video'],
                ['clean']
            ],
            handlers: {
                image: () => selectFile('image'),
                video: () => selectFile('video')
            }
        }
    }
});

function selectFile(type) {
    const input = document.createElement('input');
    input.type = 'file';
    input.accept = type + '/*';
    input.click();

    input.onchange = () => {
        const file = input.files[0];
        if (!file || !file.type.startsWith(type)) {
            alert('File tidak valid');
            return;
        }
        uploadFile(file, type);
    };
}

function uploadFile(file, type) {
    const fd = new FormData();
    fd.append(type, file);
    fd.append('_token', '{{ csrf_token() }}');

    let url = '{{ route("admin.pengumuman.upload_image") }}';
    if (type === 'video') {
        url = '{{ route("admin.pengumuman.upload_video") }}';
    }

    fetch(url, { method: 'POST', body: fd })
    .then(res => res.json())
    .then(data => {
        const range = quill.getSelection(true);
        quill.insertEmbed(range.index, type, data.url);
    })
    .catch(() => alert('Upload gagal'));
}

document.querySelector('#article-form').onsubmit = function() {
    document.querySelector('#content').value = quill.root.innerHTML;
};
</script>
@endpush
