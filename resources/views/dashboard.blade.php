<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard | LMS SD</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    /* Opsi: Tambahkan font kustom jika diinginkan */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
    body {
      font-family: 'Inter', sans-serif;
    }
  </style>
</head>
<body class="bg-slate-50 text-slate-800">
  <div class="min-h-screen flex">
    <aside class="w-64 bg-white border-r border-slate-200 flex flex-col">
      <div class="p-6 text-center border-b border-slate-200">
        <h2 class="text-2xl font-bold text-sky-600">🎓 LMS SD</h2>
      </div>
      <nav class="flex-1 p-4 space-y-2">
        <a href="/dashboard" class="flex items-center gap-3 px-4 py-2 rounded-lg bg-sky-100 text-sky-700 font-semibold">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
          <span>Dashboard</span>
        </a>
        
        @auth
          @if(in_array(Auth::user()->role, ['murid', 'guru']))
            <a href="{{ Auth::user()->role === 'guru' ? route('materi.index') : route('murid.materi.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-slate-600 hover:bg-slate-100 hover:font-semibold">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"></path></svg>
              <span>Materi</span>
            </a>
          @endif
        @endauth
        
        @if(Auth::user()->role == 'guru')
          <a href="{{ route('absensi.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-slate-600 hover:bg-slate-100 hover:font-semibold">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path><path fill-rule="evenodd" d="M7 3a1 1 0 011-1h4a1 1 0 110 2H8a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
            <span>Absensi</span>
          </a>
          <a href="{{ route('kuis.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-slate-600 hover:bg-slate-100 hover:font-semibold">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M10 2a6 6 0 00-6 6v3.586l-1.707 1.707A1 1 0 003 15v1a1 1 0 001 1h12a1 1 0 001-1v-1a1 1 0 00-.293-.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path></svg>
            <span>Kelola Kuis</span>
          </a>
          <a href="{{ route('penilaian.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-slate-600 hover:bg-slate-100 hover:font-semibold">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M2 11h14v2H2v-2zM2 5h14v2H2V5zm0 12h14v2H2v-2z"></path></svg>
            <span>Penilaian</span>
          </a>
        @endif

        @if(Auth::user()->role == 'murid')
          <a href="{{ route('murid.kuis.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-slate-600 hover:bg-slate-100 hover:font-semibold">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path></svg>
            <span>Kerjakan Kuis</span>
          </a>
          <a href="{{ route('murid.nilai.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-slate-600 hover:bg-slate-100 hover:font-semibold">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5 3a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V5a2 2 0 00-2-2H5zm9 4a1 1 0 10-2 0v6a1 1 0 102 0V7zm-3 2a1 1 0 10-2 0v4a1 1 0 102 0V9zm-3 3a1 1 0 10-2 0v1a1 1 0 102 0v-1z" clip-rule="evenodd"></path></svg>
            <span>Nilai Kuis</span>
          </a>
        @endif
        
      </nav>
      <div class="p-4 mt-auto">
        <form method="POST" action="/logout">
          @csrf
          <button type="submit" class="w-full flex items-center gap-3 px-4 py-2 rounded-lg text-slate-600 hover:bg-slate-100 hover:font-semibold">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd"></path></svg>
            <span>Logout</span>
          </button>
        </form>
      </div>
    </aside>

    <main class="flex-1 p-8">
      <header class="mb-8">
        <h1 class="text-3xl font-bold text-slate-900">👋 Selamat Datang, {{ Auth::user()->name }}</h1>
      </header>

      @if(Auth::user()->role == 'guru')
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-sky-500 hover:shadow-lg transition-shadow">
            <h2 class="text-lg font-semibold text-slate-600">👥 Jumlah Murid</h2>
            <p class="mt-2 text-3xl font-bold text-slate-800">{{ $jumlahMurid }} Siswa</p>
          </div>
          <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-amber-500 hover:shadow-lg transition-shadow">
            <h2 class="text-lg font-semibold text-slate-600">📆 Absensi Hari Ini</h2>
            @if($absensiHariIni)
            <p class="mt-2 text-green-700 text-lg">Sudah diisi</p>
            @else
            <p class="mt-2 text-amber-700 text-lg">Belum diisi</p>
            @endif
          </div>
        </div>
      @endif

      @if(Auth::user()->role == 'murid')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-sky-500">
            <h3 class="text-slate-500 font-semibold">Kuis Dikerjakan</h3>
            <p class="text-3xl font-bold text-slate-800 mt-2">{{ $kuisDikerjakan }}</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-emerald-500">
            <h3 class="text-slate-500 font-semibold">Rata-rata Nilai</h3>
            <p class="text-3xl font-bold text-slate-800 mt-2">{{ round($rataRataNilai, 1) }}</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-amber-500">
            <h3 class="text-slate-500 font-semibold">Kehadiran Bulan Ini</h3>
            <p class="text-3xl font-bold text-slate-800 mt-2">{{ $kehadiranBulanIni }} Hari</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white p-6 rounded-xl shadow-md">
                <h3 class="text-xl font-bold text-slate-800 mb-4">📝 Kuis yang Harus Dikerjakan</h3>
                <div class="space-y-4">
                    @forelse ($kuisTersedia as $kuis)
                        <div class="flex justify-between items-center p-4 rounded-lg border border-slate-200 hover:bg-slate-50">
                            <div>
                                <p class="font-semibold text-slate-700">{{ $kuis->judul }}</p>
                                <p class="text-sm text-slate-500">Deadline: {{ \Carbon\Carbon::parse($kuis->tanggal_selesai)->translatedFormat('l, d F Y') }}</p>
                            </div>
                            <a href="{{ route('murid.kuis.index', $kuis->id) }}" class="bg-sky-500 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-sky-600">
                                Kerjakan
                            </a>
                        </div>
                    @empty
                        <p class="text-slate-500 text-center p-4">🎉 Hebat! Tidak ada kuis yang perlu dikerjakan saat ini.</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-md">
                <h3 class="text-xl font-bold text-slate-800 mb-4">📚 Materi Terbaru</h3>
                <div class="space-y-3">
                    @foreach($materiTerbaru as $materi)
                    <a href="{{ route('murid.materi.show', $materi->id) }}" class="block p-4 rounded-lg border border-slate-200 hover:bg-slate-50">
                        <p class="font-semibold text-slate-700">{{ $materi->judul }}</p>
                        <p class="text-sm text-slate-500">{{ $materi->kategori->nama_kategori }}</p>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="bg-white p-6 rounded-xl shadow-md">
                <h3 class="text-xl font-bold text-slate-800 mb-4">🏆 Nilai Terakhir Kamu</h3>
                @if($nilaiTerakhir)
                    <div class="text-center bg-emerald-50 border-2 border-dashed border-emerald-300 p-6 rounded-lg">
                        <p class="text-slate-600 text-sm">{{ $nilaiTerakhir->kuis->judul }}</p>
                        <p class="text-6xl font-bold text-emerald-600 my-2">{{ $nilaiTerakhir->skor }}</p>
                        <p class="text-slate-500 text-sm">Dikerjakan pada {{ $nilaiTerakhir->created_at->translatedFormat('d M Y') }}</p>
                    </div>
                @else
                    <p class="text-slate-500 text-center py-10">Kamu belum pernah mengerjakan kuis.</p>
                @endif
            </div>
        </div>
    </div>
    @endif
    </main>
  </div>
</body>
</html>