@extends('layouts.app')

@section('title', 'Daftar Materi')

@section('content')
<div class="max-w-5xl mx-auto p-6 bg-white shadow rounded-lg mt-10">
  <h2 class="text-2xl font-bold text-indigo-800 mb-6">📘 Daftar Materi Pembelajaran</h2>

  {{-- Bar atas: tombol tambah, filter kategori, dan pencarian --}}
  <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    {{-- Tombol tambah --}}
    <a href="{{ route('materi.create') }}" class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded shadow whitespace-nowrap">
      ➕ Tambah Materi
    </a>

    {{-- Filter + Search --}}
    <form method="GET" action="{{ route('materi.index') }}" class="flex flex-col md:flex-row gap-2 w-full md:w-auto">
      {{-- Dropdown kategori --}}
      <select name="kategori_id" class="border border-gray-300 px-3 py-2 rounded md:w-48 focus:outline-none focus:ring-2 focus:ring-indigo-400">
        <option value="">Semua Kategori</option>
        @foreach($kategoriList as $kat)
          <option value="{{ $kat->id }}" {{ request('kategori_id') == $kat->id ? 'selected' : '' }}>
            {{ $kat->nama_kategori }}
          </option>
        @endforeach
      </select>

      {{-- Input keyword --}}
      <div class="flex flex-row gap-0 md:gap-0 w-full md:w-auto">
        <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Cari materi…" class="flex-1 md:w-56 border border-gray-300 px-4 py-2 rounded-l-md focus:outline-none focus:ring-2 focus:ring-indigo-400" />
        <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded-r-md">🔍</button>
      </div>
    </form>
  </div>

  {{-- Tabel materi --}}
  <div class="overflow-x-auto">
    <table class="min-w-full table-auto border border-gray-300">
      <thead class="bg-indigo-100">
        <tr>
          <th class="px-4 py-2 text-left">Judul</th>
          <th class="px-4 py-2 text-left">Kategori</th>
          <th class="px-4 py-2 text-left">Deskripsi</th>
          <th class="px-4 py-2 text-left">File</th>
          <th class="px-4 py-2 text-center">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($materiList as $materi)
          <tr class="border-b hover:bg-gray-50">
            <td class="px-4 py-2 font-semibold">{{ $materi->judul }}</td>
            <td class="px-4 py-2">{{ $materi->kategori->nama_kategori ?? '-' }}</td>
            <td class="px-4 py-2 max-w-xs truncate">{{ $materi->deskripsi ?? '-' }}</td>
            <td class="px-4 py-2">
              @if($materi->file_path)
                <a href="{{ asset('storage/' . $materi->file_path) }}" target="_blank" class="text-blue-600 hover:underline">📄 Lihat</a>
              @else
                <span class="text-gray-500 italic">Tidak ada file</span>
              @endif
            </td>
            <td class="px-4 py-2 text-center">
              <div class="flex justify-center gap-3">
                <a href="{{ route('materi.show', $materi->id) }}" class="text-indigo-600 hover:underline">🔍 Detail</a>
                <a href="{{ route('materi.edit', $materi->id) }}" class="text-yellow-600 hover:underline">✏️ Edit</a>
                <form method="POST" action="{{ route('materi.destroy', $materi->id) }}" onsubmit="return confirm('Yakin ingin menghapus materi ini?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="text-red-600 hover:underline">🗑 Hapus</button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="text-center text-gray-500 py-4">Belum ada materi.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- Pagination --}}
  <div class="mt-6 flex justify-center">
    {{ $materiList->appends(request()->except('page'))->links() }}
  </div>

  {{-- Back button --}}
  <div class="mt-8 text-left">
    <a href="{{ route('dashboard') }}" class="inline-flex items-center bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg shadow transition duration-200">
      ← Kembali ke Dashboard
    </a>
  </div>
</div>
@endsection
