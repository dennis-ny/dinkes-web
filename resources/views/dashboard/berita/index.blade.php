@extends('layouts.dashboard')

@section('title','Berita')
@section('heading','Berita')

@section('content')
<div class="min-h-screen">

    {{-- TOAST --}}
    @if(session('success'))
        <div id="toast-success"
            class="fixed bottom-5 right-5 z-50 flex items-center w-full max-w-sm p-4 bg-green-100 border border-green-400 rounded shadow-sm">
            <div class="text-sm font-normal">
                ✅ {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div id="toast-error"
            class="fixed bottom-5 right-5 z-50 flex items-center w-full max-w-sm p-4 bg-red-100 border border-red-400 rounded shadow-sm">
            <div class="text-sm font-normal">
                ❌ {{ session('error') }}
            </div>
        </div>
    @endif

    <div class="bg-white border border-gray-200 rounded shadow-sm">

        {{-- HEADER --}}
        <div class="flex items-center justify-between p-4">
            <h2 class="text-lg font-semibold">Daftar Berita</h2>
            <a href="{{ route('admin.berita.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
               + Tambah Berita
            </a>
        </div>

        {{-- TABLE --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3">No</th>
                        <th class="px-6 py-3">Judul</th>
                        <th class="px-6 py-3">Thumbnail</th>
                        <th class="px-6 py-3 text-center">Tanggal Terbit</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($beritas as $b)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4">{{ $b->judul }}</td>
                            <td class="px-6 py-4">
                                @if($b->thumbnail)
                                    <img src="{{ asset('storage/'.$b->thumbnail) }}" alt="Thumbnail" class="w-20 h-12 object-cover rounded">
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">{{ $b->tanggal_terbit->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-center flex justify-center gap-2">
                                <a href="{{ route('admin.berita.edit', $b->id) }}"
                                   class="text-yellow-600 hover:underline">Edit</a>
                                <button type="button"
                                        data-modal-toggle="modalDelete-{{ $b->id }}"
                                        class="text-red-600 hover:underline">
                                    Hapus
                                </button>
                            </td>
                        </tr>

                        {{-- MODAL DELETE --}}
                        <div id="modalDelete-{{ $b->id }}" tabindex="-1"
                            class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40">
                            <div class="bg-white rounded p-6 w-full max-w-sm text-center">
                                <h3 class="text-lg mb-4 font-medium">
                                    Hapus berita <b>{{ $b->judul }}</b>?
                                </h3>
                                <form action="{{ route('admin.berita.destroy', $b->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                                        Ya, Hapus
                                    </button>
                                    <button type="button"
                                        data-modal-hide="modalDelete-{{ $b->id }}"
                                        class="ml-2 bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">
                                        Batal
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-6 text-center text-gray-500">
                                Belum ada berita
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

{{-- AUTO HIDE TOAST --}}
<script>
    setTimeout(() => {
        document.getElementById('toast-success')?.remove();
        document.getElementById('toast-error')?.remove();
    }, 3000);
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-modal-toggle]').forEach(button => {
        button.addEventListener('click', function () {
            const modalId = this.getAttribute('data-modal-toggle');
            const modal = document.getElementById(modalId);
            if (modal) modal.classList.remove('hidden');
        });
    });

    document.querySelectorAll('[data-modal-hide]').forEach(button => {
        button.addEventListener('click', function () {
            const modalId = this.getAttribute('data-modal-hide');
            const modal = document.getElementById(modalId);
            if (modal) modal.classList.add('hidden');
        });
    });
});
</script>
@endsection
