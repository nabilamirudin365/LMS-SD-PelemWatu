@extends('layouts.app')

@section('title', 'Detail Nilai Kuis')

@section('content')
<div class="max-w-4xl mx-auto mt-10 bg-white p-6 rounded shadow">
  <h2 class="text-2xl font-bold text-indigo-800 mb-4">📊 Hasil Kuis: {{ $kuis->judul }}</h2>
  <p class="text-lg mb-4">Nilai: <span class="font-bold">{{ $nilai->skor ?? '-' }}/100</span></p>

  <div class="space-y-4">
    @foreach($kuis->soal as $index => $soal)
      <div class="p-4 border rounded {{ $jawaban[$soal->id] == $soal->jawaban_benar ? 'bg-green-50' : 'bg-red-50' }}">
        <p class="font-semibold">{{ $index + 1 }}. {{ $soal->pertanyaan }}</p>
        @foreach(['a','b','c','d'] as $opsi)
          <p class="ml-4 {{ $soal->jawaban_benar == $opsi ? 'font-bold text-green-600' : '' }}">
            {{ strtoupper($opsi) }}. {{ $soal->{'opsi_'.$opsi} }}
            @if($jawaban[$soal->id] == $opsi)
              <span class="text-blue-600"> ← Jawabanmu</span>
            @endif
          </p>
        @endforeach
      </div>
    @endforeach
  </div>

  <div class="mt-6">
    <a href="{{ route('murid.nilai.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">← Kembali</a>
  </div>
</div>
@endsection
