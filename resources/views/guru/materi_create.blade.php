@extends('layouts.app')

@section('title', 'Tambah Materi')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white shadow-lg rounded-lg mt-10">
  <h2 class="text-2xl font-bold text-indigo-800 mb-6">📘 Tambah Materi Baru</h2>

  @if ($errors->any())
    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
      <ul class="list-disc list-inside text-sm">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('materi.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="mb-4">
      <label class="block font-semibold mb-1">Judul Materi</label>
      <input type="text" name="judul" class="w-full border rounded px-3 py-2" required>
    </div>

    {{-- Dropdown kategori --}}
<select name="kategori_id" class="w-full border rounded px-3 py-2" required>
  <option value="">-- Pilih Kategori --</option>
  @foreach($kategoriList as $kat)
    <option value="{{ $kat->id }}"
      {{ old('kategori_id', $materi->kategori_id ?? '') == $kat->id ? 'selected' : '' }}>
      {{ $kat->nama_kategori }}
    </option>
  @endforeach
</select>


    <div class="mb-4">
      <label class="block font-semibold mb-1">Deskripsi</label>
      <textarea name="deskripsi" rows="4" class="w-full border rounded px-3 py-2"></textarea>
    </div>

    <div class="mb-6">
      <label class="block font-semibold mb-1">Upload File (PDF / Gambar)</label>
      <input type="file" name="file_path" accept=".pdf,.jpg,.jpeg,.png,.gif" class="block mt-1">
    </div>

    <div class="flex justify-between">
      <a href="{{ route('materi.index') }}" class="text-gray-600 hover:underline">← Kembali</a>
      <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded shadow">
        💾 Simpan Materi
      </button>
    </div>
  </form>
</div>
@endsection