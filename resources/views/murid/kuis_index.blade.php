@extends('layouts.app')

@section('title', 'Kuis Tersedia')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white shadow rounded-lg mt-10">
  <h2 class="text-2xl font-bold text-indigo-800 mb-6">📝 Daftar Kuis yang Bisa Dikerjakan</h2>

  @if($kuisList->isEmpty())
    <p class="text-gray-600">Belum ada kuis yang tersedia saat ini.</p>
  @else
    <table class="w-full table-auto border border-gray-300">
      <thead class="bg-indigo-100">
        <tr>
          <th class="px-4 py-2 text-left">Judul</th>
          <th class="px-4 py-2 text-left">Deskripsi</th>
          <th class="px-4 py-2 text-left">Tanggal</th>
          <th class="px-4 py-2 text-center">Status</th>
          <th class="px-4 py-2 text-center">Aksi</th>
        </tr>
      </thead>
      <tbody>
  @foreach($kuisList as $kuis)
    @php
      $nilai = $kuis->nilaiKuis->firstWhere('murid_id', Auth::id());
    @endphp
    <tr class="border-b hover:bg-gray-50">
      <td class="px-4 py-2 font-semibold text-indigo-800">{{ $kuis->judul }}</td>

      <td class="px-4 py-2 text-gray-700">{{ $kuis->deskripsi ?? '-' }}</td>

      <td class="px-4 py-2">
        {{ \Carbon\Carbon::parse($kuis->tanggal_mulai)->translatedFormat('d M Y') }} –
        {{ \Carbon\Carbon::parse($kuis->tanggal_selesai)->translatedFormat('d M Y') }}
      </td>

      <td class="px-4 py-2 text-center">
        @if($nilai)
          <div class="text-green-700 font-semibold">✅ Sudah dikerjakan</div>
        @else
          <div class="text-red-600 font-semibold">❌ Belum dikerjakan</div>
        @endif
      </td>

      <td class="px-4 py-2 text-center">
        @if(!$nilai)
          <a href="{{ route('murid.kuis.show', $kuis->id) }}"
             class="bg-indigo-500 hover:bg-indigo-600 text-white px-3 py-1 rounded shadow text-sm">
            Kerjakan
          </a>
        @endif
      </td>
    </tr>
  @endforeach
</tbody>
    </table>
  @endif

  <div class="mt-6 text-left">
    <a href="{{ route('dashboard') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
      ← Kembali ke Dashboard
    </a>
  </div>
</div>
@endsection
