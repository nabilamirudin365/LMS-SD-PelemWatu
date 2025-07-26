@extends('layouts.app')

@section('title', 'Kerjakan Kuis')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded shadow mt-10">
  <h2 class="text-2xl font-bold text-indigo-800 mb-4">{{ $kuis->judul }}</h2>
  <p class="text-sm text-gray-500 mb-6">🧑‍🏫 Kelas: {{ $kuis->kelas->nama_kelas }} | 📅 {{ $kuis->tanggal_mulai->translatedFormat('d F Y') }} - {{ $kuis->tanggal_selesai->translatedFormat('d F Y') }}</p>

  <form action="{{ route('murid.kuis.submit', $kuis->id) }}" method="POST">
    @csrf

    @foreach ($kuis->soal as $index => $soal)
      <div class="mb-6">
        <p class="font-semibold">{{ $index+1 }}. {{ $soal->pertanyaan }}</p>

        @foreach (['a','b','c','d'] as $opsi)
          <div class="mt-1">
            <label class="inline-flex items-center">
              <input type="radio" name="jawaban[{{ $soal->id }}]" value="{{ $opsi }}" required>
              <span class="ml-2">{{ strtoupper($opsi) }}. {{ $soal->{'opsi_'.$opsi} }}</span>
            </label>
          </div>
        @endforeach
      </div>
    @endforeach

    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
      ✅ Selesai & Kirim Jawaban
    </button>
  </form>
</div>
@endsection
