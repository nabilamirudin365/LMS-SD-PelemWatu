@extends('layouts.app')

@section('title', 'Daftar Kuis')

@section('content')
<div class="max-w-6xl mx-auto p-6 bg-white shadow-lg rounded-lg mt-10">
  <h2 class="text-2xl font-bold text-indigo-800 mb-6">🧠 Daftar Kuis</h2>

  {{-- Tombol tambah kuis --}}
  <div class="mb-4 text-right">
    <a href="{{ route('kuis.create') }}" class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded shadow">
      ➕ Buat Kuis Baru
    </a>
  </div>

  <table class="w-full table-auto border border-gray-300">
    <thead class="bg-indigo-100">
      <tr>
        <th class="px-4 py-2 text-left">Judul</th>
        <th class="px-4 py-2 text-left">Kelas</th>
        <th class="px-4 py-2 text-left">Periode</th>
        <th class="px-4 py-2 text-left">Deskripsi</th>
        <th class="px-4 py-2 text-center">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($kuisList as $kuis)
        <tr class="border-b hover:bg-gray-50">
          <td class="px-4 py-2 font-semibold">{{ $kuis->judul }}</td>
          <td class="px-4 py-2">{{ $kuis->kelas->nama_kelas }}</td>
          <td class="px-4 py-2">
            {{ \Carbon\Carbon::parse($kuis->tanggal_mulai)->translatedFormat('d M Y') }} - 
            {{ \Carbon\Carbon::parse($kuis->tanggal_selesai)->translatedFormat('d M Y') }}
          </td>
          <td class="px-4 py-2 truncate max-w-xs">{{ $kuis->deskripsi ?? '-' }}</td>
          <td class="px-4 py-2 text-center">
            <div class="flex gap-2 justify-center">
              <a href="{{ route('soal.index', $kuis->id) }}" class="text-blue-600 hover:underline">📝 Soal</a>
              <a href="{{ route('kuis.edit', $kuis->id) }}" class="text-yellow-600 hover:underline">✏️ Edit</a>
              <a href="{{ route('kuis.nilai', $kuis->id) }}" class="text-indigo-600 hover:underline">📊 Nilai</a>
              <form action="{{ route('kuis.destroy', $kuis->id) }}" method="POST" onsubmit="return confirm('Yakin hapus kuis ini?')">
                @csrf @method('DELETE')
                <button type="submit" class="text-red-600 hover:underline">🗑 Hapus</button>
              </form>
            </div>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="5" class="text-center text-gray-500 py-4">Belum ada kuis.</td>
        </tr>
      @endforelse
    </tbody>
  </table>

  {{-- Pagination --}}
  <div class="mt-6 flex justify-center">
    {{ $kuisList->links() }}
  </div>

  {{-- Tombol kembali --}}
  <div class="mt-6 text-left">
    <a href="{{ route('dashboard') }}" class="inline-flex items-center bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded shadow">
      ← Kembali ke Dashboard
    </a>
  </div>
</div>
@endsection
