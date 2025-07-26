@extends('layouts.app')

@section('title','Detail Materi')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white shadow rounded-lg mt-10">
  <h2 class="text-2xl font-bold text-indigo-800 mb-4">{{ $materi->judul }}</h2>
  <p class="text-sm text-gray-600 mb-2">Kategori: <strong>{{ $materi->kategori->nama_kategori ?? '-' }}</strong></p>
  <p class="mb-6">{{ $materi->deskripsi ?? 'Tidak ada deskripsi.' }}</p>

  @php $url = asset('storage/'.$materi->file_path); @endphp
  @if(Str::endsWith($materi->file_path, '.pdf'))
    <iframe src="{{ $url }}" class="w-full h-[600px] rounded shadow" frameborder="0"></iframe>
  @elseif($materi->file_path)
    <a href="{{ $url }}" target="_blank" class="text-blue-600 underline">📥 Unduh / Lihat File</a>
  @else
    <p class="italic text-gray-500">Tidak ada file terlampir.</p>
  @endif

  <div class="mt-8">
    <a href="{{ route('murid.materi.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded shadow">
      ← Kembali
    </a>
  </div>
</div>
@endsection
