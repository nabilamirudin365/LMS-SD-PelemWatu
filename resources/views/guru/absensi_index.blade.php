@extends('layouts.app')

@section('title', 'Daftar Absensi')

@section('content')
<div class="max-w-5xl mx-auto p-6 bg-white shadow-lg rounded-lg mt-10">
  <h2 class="text-2xl font-bold text-indigo-800 mb-4">📋 Daftar Sesi Absensi</h2>

  <div class="mb-6 flex justify-between items-center">
    <a href="{{ route('absensi.create') }}" class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded shadow-md">
      ➕ Tambah Sesi Absensi
    </a>
    <a href="{{ route('absensi.rekapan') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded shadow-md">
      📊 Rekapan Absensi
    </a>
  </div>

  <table class="w-full table-auto border border-gray-300">
    <thead class="bg-indigo-100">
      <tr>
        <th class="px-4 py-2 text-left">Tanggal</th>
        <th class="px-4 py-2 text-left">Kelas</th>
        <th class="px-4 py-2 text-left">Keterangan</th>
        <th class="px-4 py-2 text-center">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @foreach($absensiList as $absen)
      <tr class="border-b">
        <td class="px-4 py-2">{{ $absen->tanggal }}</td>
        <td class="px-4 py-2">{{ $absen->kelas->nama_kelas }}</td>
        <td class="px-4 py-2">{{ $absen->keterangan }}</td>
        <td class="px-4 py-2">
    <div class="flex items-center justify-center gap-x-2">
        
        {{-- Tombol Input --}}
        <a href="{{ route('absensi.input', ['id' => $absen->id]) }}" class="bg-sky-500 hover:bg-sky-600 text-white px-3 py-1 rounded text-sm font-semibold">
            Input
        </a>

        {{-- Tombol Hapus --}}
        <form action="{{ route('absensi.destroy', $absen->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus sesi absensi ini? Semua data kehadiran siswa pada sesi ini juga akan terhapus.');">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm font-semibold">
                Hapus
            </button>
        </form>

    </div>
</td>
      </tr>
      @endforeach
    </tbody>
  </table>

  <div class="mt-6">
    <a href="{{ route('dashboard') }}"
       class="inline-flex items-center bg-indigo-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg shadow transition duration-200">
      ← Kembali ke Dashboard
    </a>
  </div>
</div>
@endsection
