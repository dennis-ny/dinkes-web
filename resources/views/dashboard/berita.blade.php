@extends('layouts.dashboard')

@section('title', 'Berita')

@section('content')
<div class="p-6">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-semibold">Manajemen Berita</h1>
        <button onclick="openModal()"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg">
            + Tambah Berita
        </button>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="mb-3 p-3 bg-green-100 border border-green-400 rounded">
            {{ session('success') }}
        </div>
    @endif

    {{-- TABLE --}}
    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left">Judul</th>
                    <th class="p-3 text-center">Tanggal Terbit</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($beritas as $b)
                <tr class="border-t">
                    <td class="p-3">{{ $b->judul }}</td>
                    <td class="p-3 text-center">{{ $b->tanggal_terbit->format('d-m-Y') }}</td>
                    <td class="p-3 text-center space-x-2">
                        <button onclick='editBerita(@json($b))'
                            class="text-blue-600">Edit</button>

                        <form action="{{ route('admin.berita.destroy', $b->id) }}"
                              method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Hapus?')"
                                class="text-red-600">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- MODAL --}}
<div id="modal" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50">
    <div class="bg-white w-full max-w-3xl rounded-lg p-6">
        <h2 id="modalTitle" class="text-lg font-semibold mb-4">Tambah Berita</h2>

        <form id="form" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" id="method" value="POST">

            <div class="space-y-3">
                <input type="text" name="judul" id="judul"
                    class="w-full border rounded px-3 py-2" placeholder="Judul">

                {{-- Quill Editor --}}
                <div id="editor" class="border rounded min-h-[250px]"></div>
                <input type="hidden" name="konten" id="konten">

                <input type="file" name="thumbnail" id="thumbnail"
                    class="w-full border rounded px-3 py-2">

                <input type="date" name="tanggal_terbit" id="tanggal_terbit"
                    class="w-full border rounded px-3 py-2">
            </div>

            <div class="flex justify-end gap-2 mt-4">
                <button type="button" onclick="closeModal()"
                    class="px-4 py-2 border rounded">Batal</button>
                <button class="bg-blue-600 text-white px-4 py-2 rounded">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- QUILL --}}
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

<script>
let quill;

function openModal() {
    document.getElementById('modal').classList.remove('hidden');
    document.getElementById('form').action = "{{ route('admin.berita.store') }}";
    document.getElementById('method').value = 'POST';
    document.getElementById('modalTitle').innerText = 'Tambah Berita';
    document.getElementById('form').reset();
    if(quill) quill.root.innerHTML = '';
}

function closeModal() {
    document.getElementById('modal').classList.add('hidden');
}

function editBerita(data) {
    openModal();
    document.getElementById('modalTitle').innerText = 'Edit Berita';
    document.getElementById('form').action = `/admin/berita/${data.id}`;
    document.getElementById('method').value = 'PUT';

    document.getElementById('judul').value = data.judul;
    if(quill) quill.root.innerHTML = data.konten;
    document.getElementById('tanggal_terbit').value = data.tanggal_terbit;
}

document.addEventListener('DOMContentLoaded', function () {
    quill = new Quill('#editor', {
        theme: 'snow',
        placeholder: 'Tulis konten berita...',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'header': [1,2,3,4,5,6,false] }],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'align': [] }],
                ['link', 'image', 'video'],
                ['clean']
            ]
        }
    });

    // Image upload handler
    function imageHandler() {
        const input = document.createElement('input');
        input.setAttribute('type', 'file');
        input.setAttribute('accept', 'image/*');
        input.click();

        input.onchange = async () => {
            const file = input.files[0];
            if(file){
                const formData = new FormData();
                formData.append('image', file);
                formData.append('_token', '{{ csrf_token() }}');

                const res = await fetch('{{ route("admin.berita.upload_image") }}', {
                    method: 'POST',
                    body: formData
                });
                const data = await res.json();
                if(data.url){
                    const range = quill.getSelection();
                    quill.insertEmbed(range.index, 'image', data.url);
                }
            }
        };
    }

    quill.getModule('toolbar').addHandler('image', imageHandler);

    const form = document.getElementById('form');
    form.onsubmit = function() {
        document.getElementById('konten').value = quill.root.innerHTML;
    };
});
</script>
@endsection
