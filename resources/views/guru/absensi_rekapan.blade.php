@extends('layouts.app')

@section('title', 'Rekapan Absensi')

@section('content')
<div class="max-w-7xl mx-auto p-6 bg-white shadow-lg rounded-lg mt-10">
    <h2 class="text-2xl font-bold text-indigo-800 mb-4">📊 Rekapan Absensi Bulanan</h2>

    {{-- Form Filter --}}
    <form method="GET" action="{{ route('absensi.rekapan') }}" class="mb-6 p-4 bg-slate-50 rounded-lg flex items-end gap-4">
        <div>
            <label for="kelas_id" class="block font-semibold mb-1">Kelas</label>
            <select name="kelas_id" id="kelas_id" class="w-full border rounded px-3 py-2">
                <option value="">-- Pilih Kelas --</option>
                @foreach($kelasList as $kelas)
                <option value="{{ $kelas->id }}" {{ $kelas_id == $kelas->id ? 'selected' : '' }}>{{ $kelas->nama_kelas }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="bulan" class="block font-semibold mb-1">Bulan</label>
            <select name="bulan" id="bulan" class="w-full border rounded px-3 py-2">
                @for ($i = 1; $i <= 12; $i++)
                <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}</option>
                @endfor
            </select>
        </div>
        <div>
            <label for="tahun" class="block font-semibold mb-1">Tahun</label>
            <input type="number" name="tahun" value="{{ $tahun }}" class="w-full border rounded px-3 py-2">
        </div>
        <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded shadow-md">Tampilkan</button>
        @if($rekapData)
          <a href="{{ route('absensi.export', ['kelas_id' => $kelas_id, 'bulan' => $bulan, 'tahun' => $tahun]) }}" class="bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded shadow-md flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M2 5a2 2 0 012-2h12a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V5zm2-1a1 1 0 00-1 1v1h14V5a1 1 0 00-1-1H4zM3 9v7h14V9H3z"></path></svg>
            Ekspor Excel
          </a>
    @endif
    </form>

    @if($rekapData)
    <div class="overflow-x-auto">
        <table class="w-full table-auto border border-gray-400 text-center text-sm">
            <thead class="bg-slate-200 font-bold">
                <tr>
                    <th rowspan="2" class="border border-gray-400 p-2">No</th>
                    <th rowspan="2" class="border border-gray-400 p-2">Nama Siswa</th>
                    <th colspan="{{ $daysInMonth }}" class="border border-gray-400 p-2">Tanggal</th>
                    <th colspan="4" class="border border-gray-400 p-2">Jumlah</th>
                </tr>
                <tr>
                    @for ($i = 1; $i <= $daysInMonth; $i++)
                    <th class="border border-gray-400 p-1 w-8">{{ $i }}</th>
                    @endfor
                    <th class="border border-gray-400 p-1">H</th>
                    <th class="border border-gray-400 p-1">S</th>
                    <th class="border border-gray-400 p-1">I</th>
                    <th class="border border-gray-400 p-1">A</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach($rekapData as $data)
                <tr class="border-b">
                    <td class="border border-gray-400 p-1">{{ $no++ }}</td>
                    <td class="border border-gray-400 p-1 text-left">{{ $data['nama'] }}</td>
                    @foreach($data['kehadiran'] as $status)
                    <td class="border border-gray-400 p-1">{{ $status }}</td>
                    @endforeach
                    <td class="border border-gray-400 p-1 font-semibold">{{ $data['rekapSiswa']['H'] }}</td>
                    <td class="border border-gray-400 p-1 font-semibold">{{ $data['rekapSiswa']['S'] }}</td>
                    <td class="border border-gray-400 p-1 font-semibold">{{ $data['rekapSiswa']['I'] }}</td>
                    <td class="border border-gray-400 p-1 font-semibold">{{ $data['rekapSiswa']['A'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{ route('absensi.index') }}"
       class="inline-flex items-center bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded-lg shadow transition duration-200">
      ← Kembali 
    </a>
    </div>
    @else
        <p class="text-center text-gray-500 mt-8">Silakan pilih kelas, bulan, dan tahun untuk menampilkan rekap absensi.</p>
    @endif
</div>
@endsection