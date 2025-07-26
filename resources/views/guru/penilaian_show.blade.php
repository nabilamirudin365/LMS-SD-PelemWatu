@extends('layouts.app')

@section('title', 'Rekap Nilai Kuis')

@section('content')
<div class="max-w-6xl mx-auto p-6 bg-white shadow rounded-lg mt-10">
  <h2 class="text-2xl font-bold text-indigo-800 mb-4">📄 Rekap Nilai Kuis</h2>
  <p class="text-gray-700 mb-4">Kelas: <strong>{{ $kelas->nama_kelas }}</strong></p>

  @if($muridList->isEmpty())
    <p class="text-gray-600">Belum ada murid dalam kelas ini.</p>
  @else
    <div class="overflow-x-auto">
      <table class="w-full table-auto border border-gray-300">
        <thead class="bg-indigo-100">
          <tr>
            <th class="px-4 py-2 text-left">#</th>
            <th class="px-4 py-2 text-left">Nama Murid</th>
            @foreach($kuisList as $kuis)
              <th class="px-4 py-2 text-center">Kuis {{ $loop->iteration }}</th>
            @endforeach
            <th class="px-4 py-2 text-center">Rata-Rata</th>
          </tr>
        </thead>
        <tbody>
          @foreach($muridList as $index => $murid)
          <tr class="border-b">
            <td class="px-4 py-2">{{ $index + 1 }}</td>
            <td class="px-4 py-2">{{ $murid->name }}</td>
            @php
              $totalNilai = 0;
              $jumlahKuis = $kuisList->count();
            @endphp
            @foreach($kuisList as $kuis)
              @php
                $nilai = $murid->nilaiKuis->firstWhere('kuis_id', $kuis->id);
                $skor = $nilai ? $nilai->skor : 0;
                $totalNilai += $skor;
              @endphp
              <td class="px-4 py-2 text-center">{{ $skor }}</td>
            @endforeach
            <td class="px-4 py-2 text-center font-semibold text-indigo-700">
              {{ $jumlahKuis > 0 ? round($totalNilai / $jumlahKuis) : 0 }}
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @endif

  <div class="mt-6">
    <a href="{{ route('penilaian.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded shadow">
      ← Kembali Pilih Kelas
    </a>
  </div>
</div>
@endsection
