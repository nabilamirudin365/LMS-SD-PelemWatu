@extends('layouts.app')

@section('title', 'Input Absensi')

@section('content')
<div class="max-w-5xl mx-auto p-6 bg-white shadow-lg rounded-lg mt-10">
  <h2 class="text-2xl font-bold text-indigo-800 mb-4">📝 Input Absensi - {{ $kelas_nama }}</h2>

  <div class="mb-6">
    <p class="text-sm text-gray-600"><strong>Tanggal:</strong> {{ $tanggal_absensi }}</p>
  </div>

  <form method="POST" action="{{ route('absensi.simpan') }}">
    @csrf
    <input type="hidden" name="absensi_id" value="{{ $absensi_id }}">

    <div class="overflow-x-auto">
      <table class="w-full text-sm border border-gray-300">
        <thead class="bg-gray-100">
          <tr>
            <th class="px-4 py-2 text-left">Nama Siswa</th>
            <th class="px-4 py-2 text-center">Status</th>
            <th class="px-4 py-2 text-left">Keterangan</th>
          </tr>
        </thead>
        <tbody>
          @foreach($murid as $siswa)
          <tr class="border-b hover:bg-gray-50">
            <td class="px-4 py-2">{{ $siswa->name }}</td>
            <td class="px-4 py-2 text-center">
              <select name="presensi[{{ $siswa->id }}][status]" class="border border-gray-300 rounded px-2 py-1">
                <option value="hadir">Hadir</option>
                <option value="tidak_hadir">Tidak Hadir</option>
                <option value="izin">Izin</option>
              </select>
            </td>
            <td class="px-4 py-2">
              <input type="text" name="presensi[{{ $siswa->id }}][keterangan]" class="w-full border border-gray-300 rounded px-2 py-1" placeholder="Opsional">
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="mt-6 text-right">
      <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded shadow">
        💾 Simpan Absensi
      </button>
    </div>
    <div class="mt-6">
    <a href="{{ route('absensi.index') }}"
       class="inline-flex items-center bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded-lg shadow transition duration-200">
      ← Kembali 
    </a>
  </div>
  </form>
</div>
@endsection
