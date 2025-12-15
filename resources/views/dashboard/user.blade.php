@extends('layouts.dashboard')

@section('title', 'Manajemen User')
@section('heading', 'Manajemen User')

@section('content')
<div class="min-h-screen">

    {{-- TOAST --}}
    @if(session('success'))
        <div id="toast-success"
            class="fixed bottom-5 right-5 z-50 flex items-center w-full max-w-sm p-4 bg-neutral-primary-soft border border-default rounded-base shadow-xs">
            <div class="text-sm font-normal">
                {{ session('success') }}
            </div>
        </div>
    @endif

    <div class="bg-neutral-primary-soft border border-default rounded-base shadow-xs">

        {{-- HEADER --}}
        <div class="flex items-center justify-between p-4">
            <form method="GET">
                <input type="text" name="search" value="{{ request('search') }}"
                    class="bg-neutral-secondary-medium border border-default-medium rounded-base px-3 py-2 text-sm"
                    placeholder="Cari user...">
            </form>

            <button data-modal-toggle="modalTambahUser"
                class="bg-brand hover:bg-brand-strong text-white px-4 py-2 rounded-base text-sm">
                + Tambah User
            </button>
        </div>

        {{-- TABLE --}}
        <table class="w-full text-sm text-left">
            <thead class="bg-neutral-secondary-medium border-b border-default">
                <tr>
                    <th class="px-6 py-3">No</th>
                    <th class="px-6 py-3">Nama</th>
                    <th class="px-6 py-3">Username</th>
                    <th class="px-6 py-3">Role</th>
                    <th class="px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr class="border-b border-default hover:bg-neutral-secondary-medium">
                        <td class="px-6 py-4">
                            {{ $loop->iteration + ($users->currentPage()-1) * $users->perPage() }}
                        </td>
                        <td class="px-6 py-4">{{ $user->name }}</td>
                        <td class="px-6 py-4">{{ $user->username }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded-full text-xs bg-brand/10 text-brand">
                                {{ strtoupper($user->role) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 flex gap-3">
                            <button type="button"
                                data-modal-toggle="modalEditUser-{{ $user->id }}"
                                class="text-brand hover:underline">
                                Edit
                            </button>
                            <button type="button"
                                data-modal-toggle="modalDeleteUser-{{ $user->id }}"
                                class="text-red-600 hover:underline">
                                Hapus
                            </button>
                        </td>
                    </tr>

                    {{-- MODAL EDIT --}}
                    <div id="modalEditUser-{{ $user->id }}" tabindex="-1"
                        class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40">
                        <div class="bg-neutral-primary-soft rounded-base p-6 w-full max-w-md">
                            <h3 class="text-lg font-medium mb-4">Edit User</h3>

                            <form action="{{ route('admin.user.update', $user->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <input name="name" value="{{ $user->name }}"
                                    class="input" required>
                                <input name="username" value="{{ $user->username }}"
                                    class="input mt-3" required>

                                <input type="password" name="password"
                                    class="input mt-3"
                                    placeholder="Password (kosongkan jika tidak diubah)">

                                <select name="role" class="input mt-3">
                                    <option value="admin" @selected($user->role=='admin')>Admin</option>
                                    <option value="upt" @selected($user->role=='upt')>UPT</option>
                                </select>

                                <input name="alamat" value="{{ $user->alamat }}"
                                    class="input mt-3" placeholder="Alamat">

                                <input name="no_telp" value="{{ $user->no_telp }}"
                                    class="input mt-4" placeholder="No Telp">

                                <div class="flex justify-end gap-2 mt-4">
                                    <button class="bg-brand text-white px-4 py-2 rounded-base">
                                        Update
                                    </button>
                                    <button type="button"
                                        data-modal-hide="modalEditUser-{{ $user->id }}"
                                        class="bg-neutral-secondary-medium px-4 py-2 rounded-base">
                                        Batal
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- MODAL DELETE --}}
                    <div id="modalDeleteUser-{{ $user->id }}" tabindex="-1"
                        class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40">
                        <div class="bg-neutral-primary-soft rounded-base p-6 w-full max-w-md text-center">
                            <h3 class="text-lg mb-4">
                                Hapus user <b>{{ $user->name }}</b>?
                            </h3>

                            <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST">
                                @csrf
                                @method('DELETE')

                                <button
                                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-base">
                                    Ya, Hapus
                                </button>

                                <button type="button"
                                    data-modal-hide="modalDeleteUser-{{ $user->id }}"
                                    class="ml-2 bg-neutral-secondary-medium px-4 py-2 rounded-base">
                                    Batal
                                </button>
                            </form>
                        </div>
                    </div>

                @empty
                    <tr>
                        <td colspan="5" class="text-center px-6 py-6 text-body">
                            Data user belum tersedia
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="p-4">
            {{ $users->links() }}
        </div>
    </div>
</div>

{{-- MODAL TAMBAH USER --}}
<div id="modalTambahUser" tabindex="-1"
    class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40">
    <div class="bg-neutral-primary-soft rounded-base p-6 w-full max-w-md">
        <h3 class="text-lg font-medium mb-4">Tambah User</h3>

        <form action="{{ route('admin.user.store') }}" method="POST">
            @csrf

            <input name="name" class="input" placeholder="Nama Lengkap" autocomplete="off" required>
            <input name="username" class="input mt-3" placeholder="Username" autocomplete="new-password" required>
            <input type="password" name="password" class="input mt-3" placeholder="Password" required>

            <select name="role" class="input mt-3">
                <option value="upt">UPT</option>
                <option value="admin">Admin</option>
            </select>

            <input name="alamat" class="input mt-3" placeholder="Alamat">
            <input name="no_telp" class="input mt-4" placeholder="No Telp">

            <div class="flex justify-end gap-2 mt-4">
                <button class="bg-brand text-white px-4 py-2 rounded-base">
                    Simpan
                </button>
                <button type="button" data-modal-hide="modalTambahUser"
                    class="bg-neutral-secondary-medium px-4 py-2 rounded-base">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

{{-- AUTO HIDE TOAST --}}
<script>
    setTimeout(() => {
        document.getElementById('toast-success')?.remove();
    }, 3000);
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // BUKA MODAL
    document.querySelectorAll('[data-modal-toggle]').forEach(button => {
        button.addEventListener('click', function () {
            const modalId = this.getAttribute('data-modal-toggle');
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('hidden');
            }
        });
    });

    // TUTUP MODAL
    document.querySelectorAll('[data-modal-hide]').forEach(button => {
        button.addEventListener('click', function () {
            const modalId = this.getAttribute('data-modal-hide');
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.add('hidden');
            }
        });
    });

});
</script>

@endsection
