@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="max-w-xl mx-auto p-6 bg-white shadow-lg rounded-lg mt-10">
    <h2 class="text-2xl font-bold text-indigo-800 mb-6">✏️ Edit User: {{ $user->name }}</h2>

    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Nama & Email --}}
        <div class="mb-4">
            <label for="name" class="block font-semibold mb-1">Nama Lengkap</label>
            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="w-full border rounded px-3 py-2 @error('name') border-red-500 @enderror" required>
            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div class="mb-4">
            <label for="email" class="block font-semibold mb-1">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="w-full border rounded px-3 py-2 @error('email') border-red-500 @enderror" required>
            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Input Role (hanya untuk guru) atau Kelas (hanya untuk murid) --}}
        @if ($user->role == 'guru')
            <div class="mb-4">
                <label for="role" class="block font-semibold mb-1">Role</label>
                <select name="role" id="role" class="w-full border rounded px-3 py-2 bg-slate-100" readonly>
                    <option value="guru" selected>Guru</option>
                </select>
                <p class="text-slate-500 text-xs mt-1">Role guru tidak dapat diubah.</p>
            </div>
        @else
            <div class="mb-4">
                <label for="kelas_id" class="block font-semibold mb-1">Kelas</label>
                <select name="kelas_id" id="kelas_id" class="w-full border rounded px-3 py-2 @error('kelas_id') border-red-500 @enderror">
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($kelasList as $kelas)
                        {{-- Cek apakah user sudah ada di kelas ini --}}
                        <option value="{{ $kelas->id }}" {{ old('kelas_id', $user->kelas->first()->id ?? '') == $kelas->id ? 'selected' : '' }}>
                            {{ $kelas->nama_kelas }}
                        </option>
                    @endforeach
                </select>
                @error('kelas_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        @endif

        {{-- Password & Konfirmasi --}}
        <div class="mb-6">
            <label for="password" class="block font-semibold mb-1">Password Baru</label>
            <input type="password" name="password" id="password" class="w-full border rounded px-3 py-2 @error('password') border-red-500 @enderror">
            <p class="text-slate-500 text-xs mt-1">Kosongkan jika tidak ingin mengubah password.</p>
            @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div class="mb-6">
            <label for="password_confirmation" class="block font-semibold mb-1">Konfirmasi Password Baru</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="w-full border rounded px-3 py-2">
        </div>

        <div class="flex justify-between items-center">
            <a href="{{ route('users.index') }}" class="text-gray-600 hover:underline">← Batal</a>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded shadow">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection