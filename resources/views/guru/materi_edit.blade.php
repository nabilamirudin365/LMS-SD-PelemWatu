@extends('layouts.app')

@section('title', 'Edit Materi')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white shadow rounded-lg mt-10">
  <h2 class="text-2xl font-bold text-indigo-800 mb-6">✏️ Edit Materi</h2>

  <form method="POST" action="{{ route('materi.update', $materi->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-4">
      <label class="block font-semibold mb-1">Judul</label>
      <input type="text" name="judul" value="{{ $materi->judul }}" class="w-full border rounded px-3 py-2" required>
    </div>

    <div class="mb-4">
      <label for="kategori_id" class="block font-semibold mb-1">Kategori</label>
      <select name="kategori_id" id="kategori_id" class="w-full border rounded px-3 py-2" required>
        @foreach($kategoriList as $kategori)
          <option value="{{ $kategori->id }}" @if(old('kategori_id', $materi->kategori_id) == $kategori->id) selected @endif>
            {{ $kategori->nama_kategori }}
          </option>
        @endforeach
      </select>
    </div>

    <div class="mb-4">
      <label class="block font-semibold mb-1">Deskripsi</label>
      <textarea name="deskripsi" class="w-full border rounded px-3 py-2">{{ $materi->deskripsi }}</textarea>
    </div>

    <div class="mb-4">
      <label class="block font-semibold mb-1">Ganti File (jika perlu)</label>
      <input type="file" name="file" class="w-full border rounded px-3 py-2">
      @if($materi->file_path)
        <p class="text-sm text-gray-600 mt-1">📄 File saat ini: <a href="{{ asset('storage/' . $materi->file_path) }}" class="text-blue-600 underline" target="_blank">Lihat</a></p>
      @endif
    </div>

    <div class="flex justify-between">
      <a href="{{ route('materi.index') }}" class="text-gray-600 hover:underline">← Kembali</a>
      <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded shadow">
        💾 Simpan Perubahan
      </button>
    </div>
  </form>
</div>
@endsection
