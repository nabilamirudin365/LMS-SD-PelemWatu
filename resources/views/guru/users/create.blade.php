@extends('layouts.app')

@section('title', 'Tambah User Baru')

@section('content')
<div class="max-w-xl mx-auto p-6 bg-white shadow-lg rounded-lg mt-10">
    <h2 class="text-2xl font-bold text-indigo-800 mb-6">➕ Tambah User Baru</h2>

    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        {{-- Nama, Email --}}
        <div class="mb-4">
            <label for="name" class="block font-semibold mb-1">Nama Lengkap</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full border rounded px-3 py-2 @error('name') border-red-500 @enderror" required>
            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div class="mb-4">
            <label for="email" class="block font-semibold mb-1">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" class="w-full border rounded px-3 py-2 @error('email') border-red-500 @enderror" required>
            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Role --}}
        <div class="mb-4">
            <label for="role" class="block font-semibold mb-1">Role</label>
            <select name="role" id="role" class="w-full border rounded px-3 py-2 @error('role') border-red-500 @enderror" required>
                <option value="murid" @if(old('role') == 'murid') selected @endif>Murid</option>
                <option value="guru" @if(old('role') == 'guru') selected @endif>Guru</option>
            </select>
            @error('role') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Dropdown Kelas (Awalnya Tersembunyi) --}}
        <div id="kelas-container" class="mb-4" style="display: {{ old('role', 'guru') == 'murid' ? 'block' : 'none' }};">
            <label for="kelas_id" class="block font-semibold mb-1">Kelas</label>
            <select name="kelas_id" id="kelas_id" class="w-full border rounded px-3 py-2 @error('kelas_id') border-red-500 @enderror">
                <option value="">-- Pilih Kelas --</option>
                @foreach($kelasList as $kelas)
                <option value="{{ $kelas->id }}" @if(old('kelas_id') == $kelas->id) selected @endif>{{ $kelas->nama_kelas }}</option>
                @endforeach
            </select>
            @error('kelas_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Password & Konfirmasi --}}
        <div class="mb-6">
            <label for="password" class="block font-semibold mb-1">Password</label>
            <input type="password" name="password" id="password" class="w-full border rounded px-3 py-2 @error('password') border-red-500 @enderror" required>
            @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div class="mb-6">
            <label for="password_confirmation" class="block font-semibold mb-1">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="w-full border rounded px-3 py-2" required>
        </div>

        <div class="flex justify-between items-center">
            <a href="{{ route('users.index') }}" class="text-gray-600 hover:underline">← Batal</a>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded shadow">Simpan User</button>
        </div>
    </form>
</div>

{{-- JAVASCRIPT UNTUK LOGIKA TAMPIL/SEMBUNYI --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const roleSelect = document.getElementById('role');
        const kelasContainer = document.getElementById('kelas-container');

        roleSelect.addEventListener('change', function() {
            if (this.value === 'murid') {
                kelasContainer.style.display = 'block';
            } else {
                kelasContainer.style.display = 'none';
            }
        });
    });
</script>
@endsection