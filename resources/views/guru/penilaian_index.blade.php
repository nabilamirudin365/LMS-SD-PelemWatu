@extends('layouts.app')

@section('title', 'Penilaian Kuis')

@section('content')
<div class="max-w-6xl mx-auto p-6 bg-white shadow rounded-lg mt-10">
  <h2 class="text-2xl font-bold text-indigo-800 mb-6">📊 Rekap Penilaian </h2>

  {{-- === Filter Kelas === --}}
  <form method="GET" action="{{ route('penilaian.index') }}" class="mb-8">
    <label class="block font-semibold mb-1">Pilih Kelas:</label>
    <div class="flex gap-4">
      <select name="kelas_id" id="kelas_id"
              class="border px-4 py-2 rounded w-60" required>
        <option value="">-- Pilih Kelas --</option>
        @foreach($kelasList as $kelas)
          <option value="{{ $kelas->id }}"
                  {{ request('kelas_id') == $kelas->id ? 'selected' : '' }}>
            {{ $kelas->nama_kelas }}
          </option>
        @endforeach
      </select>

      <button type="submit"
              class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded shadow">
        🔍 Tampilkan
      </button>
    </div>
  </form>

  {{-- === Tabel Rekap (hanya jika kelas dipilih) === --}}
  @if($kelasTerpilih)
    <h3 class="text-lg font-semibold mb-4">
      Kelas: {{ $kelasTerpilih->nama_kelas }}
    </h3>

    @if($muridList->isEmpty())
      <p class="text-gray-600">Belum ada murid atau nilai di kelas ini.</p>
    @else
      <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-300 text-sm">
          <thead class="bg-indigo-100">
            <tr>
              <th class="px-4 py-2 text-left">Nama Murid</th>
              @foreach($kuisList as $kuis)
                <th class="px-4 py-2 text-center">Kuis {{ $loop->iteration }}</th>
              @endforeach
              <th class="px-4 py-2 text-center">Rata-rata</th>
            </tr>
          </thead>
          <tbody>
            @foreach($muridList as $murid)
              @php
                $total = 0; $count = 0;
              @endphp
              <tr class="border-b hover:bg-gray-50">
                <td class="px-4 py-2 font-medium">{{ $murid->name }}</td>

                @foreach($kuisList as $kuis)
                  @php
                    $nilaiObj = $murid->nilaiKuis->firstWhere('kuis_id', $kuis->id);
                    $skor = $nilaiObj?->skor;
                    if(!is_null($skor)){
                      $total += $skor; $count++;
                    }
                  @endphp
                  <td class="px-4 py-2 text-center">
                    {{ $skor ?? '-' }}
                  </td>
                @endforeach

                <td class="px-4 py-2 text-center font-semibold">
                  {{ $count ? round($total / $count, 1) : '-' }}
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
        <a href="{{ route('penilaian.export', ['kelas_id' => $kelasTerpilih->id]) }}"
        class="inline-block mb-4 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow">
        📥 Ekspor ke Excel
        </a>

      </div>
    @endif
  @endif

  <div class="mt-6">
    <a href="{{ route('dashboard') }}"
       class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded shadow">
      ← Kembali ke Dashboard
    </a>
  </div>
</div>
@endsection
