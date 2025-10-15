<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Selamat Datang di LMS SD Ceria</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
    html { scroll-behavior: smooth; }
    body { font-family: 'Inter', sans-serif; }

    /* CSS untuk animasi fade-in saat scroll */
    .fade-in-section {
      opacity: 0;
      transform: translateY(20px);
      transition: opacity 0.6s ease-out, transform 0.6s ease-out;
    }
    .fade-in-section.is-visible {
      opacity: 1;
      transform: translateY(0);
    }
    /* Efek hover pada tombol agar terasa lebih interaktif */
.btn-hover-effect {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}
.btn-hover-effect:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

/* Efek hover pada ikon keunggulan agar sedikit "memantul" */
.icon-hover-effect {
    transition: transform 0.3s cubic-bezier(0.68, -0.55, 0.27, 1.55);
}
.icon-hover-effect:hover {
    transform: scale(1.1) rotate(-10deg);
}

  </style>
</head>
<body class="bg-slate-50 text-slate-800">

  <header class="bg-white/80 backdrop-blur-lg sticky top-0 z-50 shadow-sm">
    <div class="container mx-auto px-6 py-4 flex justify-between items-center">
      <div class="flex items-center gap-3">
        <span class="bg-sky-500 p-2 rounded-lg text-white font-bold">🎓</span>
        <h1 class="text-xl font-bold text-slate-800">LMS UPT SD NEGERI 231 GRESIK</h1>
      </div>
      <a href="{{ route('login') }}" class="bg-sky-500 text-white px-5 py-2 rounded-lg font-semibold hover:bg-sky-600 transition-colors btn-hover-effect">
        Login Murid & Guru
      </a>
    </div>
  </header>

  <main>
    <section class="container mx-auto px-6 py-20 lg:py-32">
      <div class="grid lg:grid-cols-2 gap-12 items-center">
        <div class="text-center lg:text-left">
          <h2 class="text-4xl lg:text-5xl font-bold text-slate-900 leading-tight">
            Pembelajaran Informatika Modern untuk Generasi Digital
          </h2>
          <p class="mt-4 text-lg text-slate-800">
            Platform pembelajaran digital kami dirancang untuk mengembangkan kemampuan computational thinking, coding, dan literasi digital yang interaktif, menyenangkan, dan sesuai kurikulum terkini.
          </p>
          <a href="{{ route('login') }}" class="mt-8 inline-block bg-sky-500 text-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-sky-600 transition-colors">
            Masuk ke Kelas Digital
          </a>
        </div>
        <div>
          <img src="{{ asset('images/gambarlabupt.jpg') }}" alt="Siswa belajar di UPT SD Negeri 231 Gresik" class="rounded-2xl shadow-xl">
        </div>
      </div>
    </section>

    {{-- Latar Belakang Blur --}}
<div class="fixed inset-0 -z-10">
  {{-- Gambar Sekolah dengan Efek Blur --}}
  <div 
  class="absolute inset-0 bg-cover bg-center" 
  style="background-image: url('{{ asset('images/bgsekolah.jpg') }}');">
</div>

  {{-- Lapisan Overlay untuk Keterbacaan --}}
  <div class="absolute inset-0 bg-white/80"></div>
</div>

    <section id="keunggulan" class="bg-white py-20">
      <div class="container mx-auto px-6 text-center">
        <h3 class="text-3xl font-bold text-slate-900">Mengapa Memilih Kami?</h3>
        <p class="text-slate-600 mt-2">Tiga pilar utama dalam sistem pendidikan kami.</p>
        <div class="mt-12 grid md:grid-cols-3 gap-8">
          <div class="p-8 border border-slate-200 rounded-xl fade-in-section">
            <div class="bg-sky-100 text-sky-600 w-16 h-16 rounded-full inline-flex items-center justify-center icon-hover-effect">
              <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            </div>
            <h4 class="mt-4 text-xl font-semibold">Kurikulum Modern</h4>
            <p class="mt-2 text-slate-600">Mengikuti perkembangan zaman untuk hasil belajar yang relevan.</p>
          </div>
          <div class="p-8 border border-slate-200 rounded-xl fade-in-section">
            <div class="bg-emerald-100 text-emerald-600 w-16 h-16 rounded-full inline-flex items-center justify-center">
              <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            </div>
            <h4 class="mt-4 text-xl font-semibold">Materi Interaktif</h4>
            <p class="mt-2 text-slate-600">Materi disajikan dalam format yang menarik dan mudah dipahami.</p>
          </div>
          <div class="p-8 border border-slate-200 rounded-xl fade-in-section">
            <div class="bg-amber-100 text-amber-600 w-16 h-16 rounded-full inline-flex items-center justify-center">
              <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <h4 class="mt-4 text-xl font-semibold">Guru Profesional</h4>
            <p class="mt-2 text-slate-600">Didukung oleh tenaga pengajar yang berpengalaman dan berdedikasi.</p>
          </div>
        </div>
      </div>
    </section>

  </main>

  <footer class="bg-slate-800 text-white py-10">
    <div class="container mx-auto px-6 text-center">
      <p>&copy; {{ date('Y') }} LMS SD Ceria. Semua Hak Cipta Dilindungi.</p>
      <p class="text-sm text-slate-400 mt-1">Jl. Pendidikan No. 123, Kota Harapan, Indonesia</p>
    </div>
  </footer>


  <script>
    document.addEventListener("DOMContentLoaded", function() {
        const sections = document.querySelectorAll('.fade-in-section');

        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1 // Elemen akan muncul saat 10% bagiannya terlihat
        });

        sections.forEach(section => {
            observer.observe(section);
        });
    });
</script>
</body>
</html>