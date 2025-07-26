@extends('layouts.app')

@section('title', 'Kerjakan Kuis')

@section('content')
<div class="max-w-5xl mx-auto p-6 bg-white shadow rounded-lg mt-10">
  <h2 class="text-2xl font-bold text-indigo-800 mb-2">📘 {{ $kuis->judul }}</h2>
  <p class="mb-6 text-sm text-gray-600">
    {{ $kuis->deskripsi ?? 'Tidak ada deskripsi.' }}<br>
    Periode: <strong>{{ \Carbon\Carbon::parse($kuis->tanggal_mulai)->translatedFormat('d M Y') }}</strong>
    s.d. <strong>{{ \Carbon\Carbon::parse($kuis->tanggal_selesai)->translatedFormat('d M Y') }}</strong>
  </p>

  <form method="POST" action="{{ route('murid.kuis.submit', $kuis->id) }}">
    @csrf

    @foreach($kuis->soal as $index => $soal)
      <div class="mb-6 border p-4 rounded shadow-sm">
        <p class="font-semibold mb-2">Soal {{ $index + 1 }}: {{ $soal->pertanyaan }}</p>

        @foreach (['a','b','c','d'] as $opsi)
          <label class="block mb-1">
            <input type="radio" name="jawaban[{{ $soal->id }}]" value="{{ $opsi }}" required>
            {{ strtoupper($opsi) }}. {{ $soal->{'opsi_'.$opsi} }}
          </label>
        @endforeach
      </div>
    @endforeach

    <div class="mt-6 text-right">
      <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded shadow">
        ✅ Kirim Jawaban
      </button>
    </div>
  </form>

  <div class="mt-4">
    <a href="{{ route('murid.kuis.index') }}" class="text-indigo-600 hover:underline">
      ← Kembali ke daftar kuis
    </a>
  </div>
</div>
@endsection
