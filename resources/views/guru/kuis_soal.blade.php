@extends('layouts.app')

@section('title', 'Kelola Soal Kuis')

@section('content')
<div class="max-w-6xl mx-auto p-6 bg-white shadow-lg rounded-lg mt-10">
  {{-- Judul & Ringkasan Kuis --}}
  <h2 class="text-2xl font-bold text-indigo-800 mb-1">📝 Kelola Soal: {{ $kuis->judul }}</h2>
  <p class="text-sm text-gray-600 mb-6">
    Kelas: <strong>{{ $kuis->kelas->nama_kelas }}</strong> •
    Periode: {{ \Carbon\Carbon::parse($kuis->tanggal_mulai)->translatedFormat('d M Y') }}
    – {{ \Carbon\Carbon::parse($kuis->tanggal_selesai)->translatedFormat('d M Y') }}
  </p>

  {{-- Form Tambah Soal --}}
  <div class="mb-10 bg-gray-50 p-6 rounded-lg shadow-inner">
    <h3 class="text-lg font-semibold mb-4">➕ Tambah Soal Baru</h3>
    <form action="{{ route('soal.store', $kuis->id) }}" method="POST">
      @csrf
      <div class="mb-4">
        <label class="font-semibold block mb-1">Pertanyaan:</label>
        <textarea name="pertanyaan" class="w-full border px-4 py-2 rounded" required>{{ old('pertanyaan') }}</textarea>
      </div>

      @foreach(['a','b','c','d'] as $opsi)
      <div class="mb-3">
        <label class="font-semibold">Opsi {{ strtoupper($opsi) }}:</label>
        <input type="text" name="opsi_{{ $opsi }}" value="{{ old('opsi_'.$opsi) }}" class="w-full border px-4 py-2 rounded" required>
      </div>
      @endforeach

      <div class="mb-6">
        <label class="font-semibold block mb-1">Jawaban Benar:</label>
        <select name="jawaban_benar" class="border px-3 py-2 rounded" required>
          <option value="">-- Pilih Jawaban --</option>
          @foreach(['a','b','c','d'] as $opsi)
            <option value="{{ $opsi }}" {{ old('jawaban_benar') == $opsi ? 'selected' : '' }}>
              Opsi {{ strtoupper($opsi) }}
            </option>
          @endforeach
        </select>
      </div>

      <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded shadow">
        💾 Simpan Soal
      </button>
    </form>
  </div>

  {{-- Tabel Soal yang Sudah Ada --}}
  <h3 class="text-lg font-semibold mb-4">📋 Daftar Soal</h3>
  <div class="overflow-x-auto">
    <table class="min-w-full table-auto border border-gray-300">
      <thead class="bg-indigo-100">
        <tr>
          <th class="px-4 py-2 text-left">Pertanyaan</th>
          <th class="px-4 py-2 text-left">Jawaban Benar</th>
          <th class="px-4 py-2 text-center">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($kuis->soal as $soal)
          <tr class="border-b hover:bg-gray-50">
            <td class="px-4 py-2 max-w-lg">{{ Str::limit($soal->pertanyaan, 120) }}</td>
            <td class="px-4 py-2 text-center font-bold">{{ strtoupper($soal->jawaban_benar) }}</td>
            <td class="px-4 py-2 text-center">
              <div class="flex gap-2 justify-center">
                <a href="{{ route('soal.edit', $soal->id) }}" class="text-yellow-600 hover:underline">✏️ Edit</a>
                <form action="{{ route('soal.destroy', $soal->id) }}" method="POST" onsubmit="return confirm('Hapus soal ini?')">
                  @csrf @method('DELETE')
                  <button type="submit" class="text-red-600 hover:underline">🗑 Hapus</button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr><td colspan="3" class="text-center text-gray-500 py-4">Belum ada soal.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- Tombol kembali --}}
  <div class="mt-8 text-left">
    <a href="{{ route('kuis.index') }}" class="inline-flex items-center bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded shadow">
      ← Kembali ke Daftar Kuis
    </a>
  </div>
</div>
@endsection
