@extends('layouts.app')

@section('title', 'Buat Kuis')

@section('content')
<div class="max-w-xl mx-auto p-6 bg-white shadow-md rounded-lg mt-10">
  <h2 class="text-2xl font-bold text-indigo-800 mb-6">➕ Buat Kuis Baru</h2>

  <form action="{{ route('kuis.store') }}" method="POST">
    @csrf

    <div class="mb-4">
      <label class="block font-semibold mb-1">Judul Kuis:</label>
      <input type="text" name="judul" value="{{ old('judul') }}" class="w-full border px-4 py-2 rounded focus:ring-indigo-400" required>
    </div>

    <div class="mb-4">
      <label class="block font-semibold mb-1">Kelas:</label>
      <select name="kelas_id" class="w-full border px-4 py-2 rounded focus:ring-indigo-400" required>
        <option value="">-- Pilih Kelas --</option>
        @foreach($kelasList as $kelas)
          <option value="{{ $kelas->id }}" {{ old('kelas_id') == $kelas->id ? 'selected' : '' }}>{{ $kelas->nama_kelas }}</option>
        @endforeach
      </select>
    </div>

    <div class="mb-4">
      <label class="block font-semibold mb-1">Tanggal Mulai:</label>
      <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" class="w-full border px-4 py-2 rounded focus:ring-indigo-400" required>
    </div>

    <div class="mb-4">
      <label class="block font-semibold mb-1">Tanggal Selesai:</label>
      <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" class="w-full border px-4 py-2 rounded focus:ring-indigo-400" required>
    </div>

    <div class="mb-6">
      <label class="block font-semibold mb-1">Deskripsi (opsional):</label>
      <textarea name="deskripsi" class="w-full border px-4 py-2 rounded focus:ring-indigo-400">{{ old('deskripsi') }}</textarea>
    </div>

    <div class="flex justify-between">
      <a href="{{ route('kuis.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">← Batal</a>
      <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded shadow">💾 Simpan</button>
    </div>
  </form>
</div>
@endsection
