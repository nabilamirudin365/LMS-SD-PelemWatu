@extends('layouts.app')

@section('title', 'Edit Kuis')

@section('content')
<div class="max-w-3xl mx-auto mt-10 bg-white p-6 rounded shadow">
  <h2 class="text-2xl font-bold text-indigo-700 mb-6">✏️ Edit Kuis</h2>

  {{-- Tampilkan error validasi --}}
  @if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
      <strong>Ups!</strong> Ada kesalahan pengisian:
      <ul class="list-disc list-inside mt-2">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('kuis.update', $kuis->id) }}">
    @csrf
    @method('PUT')

    {{-- Judul --}}
    <div class="mb-4">
      <label class="block font-semibold text-gray-700">Judul Kuis</label>
      <input type="text" name="judul" value="{{ old('judul', $kuis->judul) }}"
             class="w-full border px-4 py-2 rounded mt-1 focus:ring-2 focus:ring-indigo-400" required>
    </div>

    {{-- Deskripsi --}}
    <div class="mb-4">
      <label class="block font-semibold text-gray-700">Deskripsi</label>
      <textarea name="deskripsi" rows="4"
                class="w-full border px-4 py-2 rounded mt-1 focus:ring-2 focus:ring-indigo-400">{{ old('deskripsi', $kuis->deskripsi) }}</textarea>
    </div>

    {{-- Kelas --}}
    <div class="mb-4">
      <label class="block font-semibold text-gray-700">Kelas</label>
      <select name="kelas_id" class="w-full border px-4 py-2 rounded focus:ring-2 focus:ring-indigo-400" required>
        @foreach($kelasList as $kelas)
          <option value="{{ $kelas->id }}" {{ $kuis->kelas_id == $kelas->id ? 'selected' : '' }}>
            {{ $kelas->nama_kelas }}
          </option>
        @endforeach
      </select>
    </div>

    {{-- Tanggal mulai & selesai --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <label class="block font-semibold text-gray-700">Tanggal Mulai</label>
        <input type="date" name="tanggal_mulai"
               value="{{ old('tanggal_mulai', \Carbon\Carbon::parse($kuis->tanggal_mulai)->format('Y-m-d')) }}"
               class="w-full border px-4 py-2 rounded mt-1 focus:ring-2 focus:ring-indigo-400" required>
      </div>
      <div>
        <label class="block font-semibold text-gray-700">Tanggal Selesai</label>
        <input type="date" name="tanggal_selesai"
               value="{{ old('tanggal_selesai', \Carbon\Carbon::parse($kuis->tanggal_selesai)->format('Y-m-d')) }}"
               class="w-full border px-4 py-2 rounded mt-1 focus:ring-2 focus:ring-indigo-400" required>
      </div>
    </div>

    {{-- Tombol --}}
    <div class="flex justify-between mt-6">
      <a href="{{ route('kuis.index') }}" class="text-gray-600 hover:underline">← Kembali</a>
      <button type="submit"
              class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded shadow">
        💾 Simpan Perubahan
      </button>
    </div>
  </form>
</div>
@endsection
