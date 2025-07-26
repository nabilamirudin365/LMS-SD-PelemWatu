@extends('layouts.app')

@section('title', 'Rekapan Absensi')

@section('content')
<div class="max-w-6xl mx-auto p-6 bg-white shadow-lg rounded-lg mt-10">
  <h2 class="text-2xl font-bold text-indigo-800 mb-6">📊 Rekapan Absensi Sementara</h2>

  <form method="GET" action="{{ route('absensi.rekapan') }}" class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
    <div>
      <label class="block text-sm font-semibold">Filter Kelas:</label>
      <select name="kelas_id" class="w-full border rounded px-3 py-2">
        <option value="">-- Semua Kelas --</option>
        @foreach($kelasList as $kelas)
          <option value="{{ $kelas->id }}" {{ request('kelas_id') == $kelas->id ? 'selected' : '' }}>{{ $kelas->nama_kelas }}</option>
        @endforeach
      </select>
    </div>
    <div>
      <label class="block text-sm font-semibold">Bulan:</label>
      <select name="bulan" class="w-full border rounded px-3 py-2">
        @php
          $bulanIndonesia = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        @endphp
        @for ($i = 1; $i <= 12; $i++)
          <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>{{ $bulanIndonesia[$i - 1] }}</option>
        @endfor
      </select>
    </div>
    <div>
      <label class="block text-sm font-semibold">Tahun:</label>
      <select name="tahun" class="w-full border rounded px-3 py-2">
        @for ($y = 2023; $y <= now()->year; $y++)
          <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
        @endfor
      </select>
    </div>
    <div class="flex items-end">
      <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded shadow-md">🔍 Tampilkan</button>
    </div>
  </form>
  <a href="{{ route('absensi.export', request()->query()) }}"
   class="inline-block mb-4 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow">
  📥 Ekspor ke Excel
  </a>

  <div class="overflow-x-auto">
    <table class="min-w-full border border-gray-300">
      <thead class="bg-indigo-100">
        <tr>
          <th class="px-4 py-2 text-left">Tanggal</th>
          <th class="px-4 py-2 text-left">Nama Siswa</th>
          <th class="px-4 py-2 text-left">Kelas</th>
          <th class="px-4 py-2 text-center">Status</th>
          <th class="px-4 py-2 text-left">Keterangan</th>
        </tr>
      </thead>
      <tbody>
        @forelse($rekapList as $rekap)
        <tr class="border-b hover:bg-gray-50">
          <td class="px-4 py-2">{{ $rekap->absensi->tanggal ?? '-' }}</td>
          <td class="px-4 py-2">{{ $rekap->murid->name }}</td>
          <td class="px-4 py-2">{{ $rekap->murid->kelas->first()->nama_kelas ?? '-' }}</td>
          <td class="px-4 py-2 text-center">
            <span class="inline-block px-3 py-1 text-sm rounded-full 
              {{
                $rekap->status == 'hadir' ? 'bg-green-100 text-green-800' :
                ($rekap->status == 'izin' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800')
              }}">
              {{ ucfirst($rekap->status) }}
            </span>
          </td>
          <td class="px-4 py-2">{{ $rekap->keterangan }}</td>
        </tr>
        @empty
        <tr>
          <td colspan="5" class="text-center text-gray-500 py-4">Tidak ada data absensi.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-8">
    <a href="{{ route('absensi.index') }}"
       class="inline-flex items-center bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded-lg shadow transition duration-200">
      ← Kembali ke Daftar Absensi
    </a>
  </div>
</div>
@endsection
