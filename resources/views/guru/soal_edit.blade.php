@extends('layouts.app')

@section('title', 'Edit Soal Kuis')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white shadow rounded-lg mt-10">
  {{-- Header --}}
  <h2 class="text-2xl font-bold text-indigo-800 mb-2">✏️ Edit Soal</h2>
  <p class="text-sm text-gray-600 mb-6">
    Kuis: <strong>{{ $kuis->judul }}</strong> • Kelas: <strong>{{ $kuis->kelas->nama_kelas }}</strong>
  </p>

  {{-- Notifikasi error --}}
  @if ($errors->any())
    <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
      <strong>Ups!</strong> Ada kesalahan pengisian:<br>
      <ul class="list-disc list-inside">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  {{-- Form edit soal --}}
  <form method="POST" action="{{ route('soal.update', $soal->id) }}">
    @csrf
    @method('PUT')

    {{-- Pertanyaan --}}
    <div class="mb-4">
      <label class="block font-semibold mb-1">Pertanyaan:</label>
      <textarea name="pertanyaan" rows="3" class="w-full border px-4 py-2 rounded focus:ring-indigo-400" required>{{ old('pertanyaan', $soal->pertanyaan) }}</textarea>
    </div>

    {{-- Opsi A–D --}}
    @foreach (['a','b','c','d'] as $opsi)
      <div class="mb-4">
        <label class="block font-semibold mb-1">Opsi {{ strtoupper($opsi) }}:</label>
        <input type="text"
               name="opsi_{{ $opsi }}"
               value="{{ old('opsi_'.$opsi, $soal->{'opsi_'.$opsi}) }}"
               class="w-full border px-4 py-2 rounded focus:ring-indigo-400"
               required>
      </div>
    @endforeach

    {{-- Jawaban benar --}}
    <div class="mb-6">
      <label class="block font-semibold mb-1">Jawaban Benar:</label>
      <select name="jawaban_benar" class="border px-3 py-2 rounded focus:ring-indigo-400" required>
        <option value="">-- Pilih Jawaban --</option>
        @foreach (['a','b','c','d'] as $opsi)
          <option value="{{ $opsi }}" {{ old('jawaban_benar', $soal->jawaban_benar) == $opsi ? 'selected' : '' }}>
            Opsi {{ strtoupper($opsi) }}
          </option>
        @endforeach
      </select>
    </div>

    {{-- Tombol --}}
    <div class="flex justify-between">
      <a href="{{ route('soal.index', $kuis->id) }}"
         class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
        ← Batal
      </a>

      <button type="submit"
              class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded shadow">
        💾 Simpan Perubahan
      </button>
    </div>
  </form>
</div>
@endsection
