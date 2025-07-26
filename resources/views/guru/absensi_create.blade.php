@extends('layouts.app')

@section('title', 'Tambah Sesi Absensi')

@section('content')
<div class="max-w-xl mx-auto p-6 bg-white shadow-lg rounded-lg mt-10">
  <h2 class="text-2xl font-bold text-indigo-800 mb-6">➕ Tambah Sesi Absensi</h2>

  <form method="POST" action="{{ route('absensi.store') }}">
    @csrf

    <div class="mb-4">
      <label class="block font-semibold mb-1">Pilih Kelas</label>
      <select name="kelas_id" class="w-full border border-gray-300 rounded px-3 py-2">
        @foreach($kelasList as $kelas)
          <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
        @endforeach
      </select>
    </div>

    <div class="mb-4">
      <label class="block font-semibold mb-1">Tanggal</label>
      <input type="date" name="tanggal" class="w-full border border-gray-300 rounded px-3 py-2" required>
    </div>

    <div class="mb-6">
      <label class="block font-semibold mb-1">Keterangan (opsional)</label>
      <input type="text" name="keterangan" class="w-full border border-gray-300 rounded px-3 py-2">
    </div>

    <div class="text-right">
      <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded shadow">
        💾 Simpan Sesi
      </button>
    </div>
  </form>
</div>
@endsection
