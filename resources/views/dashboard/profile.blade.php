@extends('layouts.dashboard')

@section('title', 'Profil Saya')
@section('heading', 'Profil Saya')

@section('content')
<div class="min-h-screen flex justify-center items-start pt-20">

    <div class="bg-white dark:bg-gray-800 shadow rounded-xl w-full max-w-lg p-6">

        {{-- TOAST --}}
        @if(session('success'))
            <div id="toast-success"
                class="fixed bottom-5 right-5 z-50 flex items-center w-full max-w-sm p-4 bg-green-100 border border-green-400 rounded-lg shadow">
                <div class="text-sm font-normal">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <h3 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-100">Update Profil</h3>

        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            {{-- Nama --}}
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nama Lengkap</label>
                <input type="text" name="name" id="name"
                    value="{{ old('name', auth()->user()->name) }}"
                    class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
                @error('name')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            {{-- User --}}
            <div>
    <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Username</label>
    <input type="text" name="username" id="username"
        value="{{ old('username', auth()->user()->username) }}"
        class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
        required>
    @error('username')
        <span class="text-sm text-red-600">{{ $message }}</span>
    @enderror
</div>


            {{-- Password Lama --}}
<div>
    <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Password Lama</label>
    <input type="password" name="current_password" id="current_password"
        class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
        placeholder="Masukkan password lama jika ingin ganti password">
    @error('current_password')
        <span class="text-sm text-red-600">{{ $message }}</span>
    @enderror
</div>

{{-- Password Baru --}}
<div>
    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Password Baru</label>
    <input type="password" name="password" id="password"
        class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
        placeholder="Kosongkan jika tidak ingin diubah">
    @error('password')
        <span class="text-sm text-red-600">{{ $message }}</span>
    @enderror
</div>


            {{-- Foto Profil --}}
            <div>
                <label for="avatar" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Foto Profil</label>
                <input type="file" name="avatar" id="avatar"
                    class="mt-1 block w-full text-sm text-gray-900 dark:text-gray-100 file:border file:border-gray-300 dark:file:border-gray-600 file:rounded-lg file:px-3 file:py-2 file:text-sm file:bg-gray-50 dark:file:bg-gray-700 file:text-gray-700 dark:file:text-gray-100">
                @error('avatar')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            {{-- Submit --}}
            <div class="flex justify-end">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg focus:outline-none">
                    Update Profil
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
@endsection
