@extends('layouts.app')

@section('title', 'Nilai Kuis')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white shadow rounded-lg mt-10">
  <h2 class="text-2xl font-bold text-indigo-800 mb-6">📊 Nilai Kuis Saya</h2>

  @if (session('success'))
  
  @endif

  <table class="w-full table-auto border border-gray-300">
    <thead class="bg-indigo-100">
      <tr>
        <th class="px-4 py-2 text-left">Judul Kuis</th>
        <th class="px-4 py-2 text-left">Kelas</th>
        <th class="px-4 py-2 text-center">Nilai</th>
        <th class="px-4 py-2 text-left">Dikerjakan</th>
        <th class="px-4 py-2 text-left">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($nilaiList as $nilai)
      <tr class="border-b hover:bg-gray-50">
        <td class="px-4 py-2 font-semibold">{{ $nilai->kuis->judul }}</td>
        <td class="px-4 py-2">{{ $nilai->kuis->kelas->nama_kelas ?? '-' }}</td>
        <td class="px-4 py-2 text-center font-bold text-indigo-700">{{ $nilai->skor }}</td>
        <td class="px-4 py-2">{{ $nilai->updated_at->translatedFormat('d F Y H:i') }}</td>
        <td class="px-4 py-2">
            <a href="{{ route('murid.nilai.detail', $nilai->kuis_id) }}" class="text-indigo-600 hover:underline">
              🔍 Lihat Detail
            </a>
          </td>
      </tr>
      @empty
      <tr>
        <td colspan="4" class="text-center text-gray-500 py-4">Belum ada nilai kuis.</td>
      </tr>
      @endforelse
    </tbody>
  </table>

  <div class="mt-6 text-left">
    <a href="{{ route('dashboard') }}"
       class="inline-flex items-center bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg shadow transition duration-200">
      ← Kembali ke Dashboard
    </a>
  </div>
</div>
@endsection
