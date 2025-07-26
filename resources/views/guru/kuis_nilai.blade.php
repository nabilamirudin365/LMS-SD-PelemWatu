@extends('layouts.app')

@section('title', 'Nilai Kuis')

@section('content')
<div class="max-w-5xl mx-auto p-6 bg-white shadow rounded-lg mt-10">
  <h2 class="text-2xl font-bold text-indigo-800 mb-4">📊 Nilai Kuis</h2>
  <p class="text-gray-700 mb-6">
    <strong>{{ $kuis->judul }}</strong> • Kelas: {{ $kuis->kelas->nama_kelas }}
  </p>

  @if(session('success'))
  @endif
  <div class="mb-4 text-right">
  <a href="{{ route('kuis.rekap.export', $kuis->id) }}"
     class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded shadow">
    ⬇️ Export ke Excel
  </a>
  </div>
  <table class="w-full border border-gray-300 table-auto">
    <thead class="bg-indigo-100">
      <tr>
        <th class="px-4 py-2 text-left">Nama Murid</th>
        <th class="px-4 py-2 text-center">Nilai</th>
        <th class="px-4 py-2 text-center">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($nilaiList as $nilai)
      <tr class="border-b">
        <td class="px-4 py-2">{{ $nilai->murid->name }}</td>
        <td class="px-4 py-2 text-center">{{ $nilai->skor }}</td>
        <td class="px-4 py-2 text-center">
          <form action="{{ route('kuis.reset', [$kuis->id, $nilai->murid->id]) }}" method="POST" onsubmit="return confirm('Yakin ingin reset nilai ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-red-600 hover:underline">🔄 Reset</button>
          </form>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="3" class="text-center text-gray-500 py-4">Belum ada nilai untuk kuis ini.</td>
      </tr>
      @endforelse
    </tbody>
  </table>

  <div class="mt-6">
    <a href="{{ route('kuis.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded shadow">
      ← Kembali ke Daftar Kuis
    </a>
  </div>
</div>
@endsection
