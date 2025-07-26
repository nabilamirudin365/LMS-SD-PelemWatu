@extends('layouts.app')

@section('title', 'Detail Materi')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white shadow rounded-lg mt-10">
  <h2 class="text-2xl font-bold text-indigo-800 mb-4">{{ $materi->judul }}</h2>
  <p class="mb-4 text-gray-700">{{ $materi->deskripsi ?? 'Tidak ada deskripsi.' }}</p>

  @if($materi->file_path)
    @php
      $fileUrl = asset('storage/' . $materi->file_path);
      $extension = pathinfo($fileUrl, PATHINFO_EXTENSION);
    @endphp

    <div class="mt-6">
      <h3 class="text-lg font-semibold mb-2">📎 File Materi:</h3>

      @if($extension === 'pdf')
        <iframe src="{{ $fileUrl }}" class="w-full h-[600px] border rounded-lg shadow" frameborder="0"></iframe>
      @else
        <a href="{{ $fileUrl }}" target="_blank" class="text-blue-600 underline">📥 Unduh File</a>
      @endif
    </div>
  @else
    <p class="text-gray-500 italic">Tidak ada file terlampir.</p>
  @endif

  <div class="mt-6">
    <a href="{{ route('materi.index') }}" class="inline-block bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded shadow">
      ← Kembali ke Daftar Materi
    </a>
  </div>
</div>
@endsection
