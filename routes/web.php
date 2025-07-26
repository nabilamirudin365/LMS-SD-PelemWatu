<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\MuridMateriController;
use App\Http\Controllers\KuisController;
use App\Http\Controllers\SoalKuisController;
use App\Http\Controllers\KuisSiswaController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\DashboardController;

// Route::get('/', function () {
//     return redirect()->route('login');
// });

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    // Menampilkan form login
    Route::get('login', function () {
        return view('auth.login');
    })->name('login');

    // Memproses data dari form login
    Route::post('login', [LoginController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    // Halaman dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard'); // <-- UBAH BARIS INI

    // Memproses logout
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});

Route::middleware(['auth', 'guru'])->prefix('guru')->group(function () {
    /* manajemen absensi */
    Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
    Route::get('/absensi/create', [AbsensiController::class, 'create'])->name('absensi.create');
    Route::post('/absensi', [AbsensiController::class, 'store'])->name('absensi.store');
    Route::get('/absensi/{id}/input', [AbsensiController::class, 'input'])->name('absensi.input');
    Route::post('/absensi/simpan', [AbsensiController::class, 'simpan'])->name('absensi.simpan');
    Route::get('/absensi/rekapan', [AbsensiController::class, 'rekapan'])->name('absensi.rekapan');
    Route::get('/absensi/rekap/export', [AbsensiController::class, 'export'])->name('absensi.export');
    Route::delete('/absensi/{id}', [AbsensiController::class, 'destroy'])->name('absensi.destroy');
    /* manajemen materi */
    Route::get('/materi/create', [MateriController::class, 'create'])->name('materi.create');
    Route::get('/materi', [MateriController::class, 'index'])->name('materi.index');
    Route::post('/materi/store', [MateriController::class, 'store'])->name('materi.store');
    Route::get('/materi/{id}', [MateriController::class, 'show'])->name('materi.show');
    Route::get('/materi/{id}/edit', [MateriController::class, 'edit'])->name('materi.edit');
    Route::put('/materi/{id}', [MateriController::class, 'update'])->name('materi.update');
    Route::delete('/materi/{id}', [MateriController::class, 'destroy'])->name('materi.destroy');
    /* manajemen kuis */
    Route::get('/kuis',            [KuisController::class,'index'])->name('kuis.index');
    Route::get('/kuis/create',     [KuisController::class,'create'])->name('kuis.create');
    Route::post('/kuis',           [KuisController::class,'store'])->name('kuis.store');
    Route::get('/kuis/{id}/edit',  [KuisController::class,'edit'])->name('kuis.edit');
    Route::put('/kuis/{id}',       [KuisController::class,'update'])->name('kuis.update');
    Route::delete('/kuis/{id}',    [KuisController::class,'destroy'])->name('kuis.destroy');
    Route::get('/kuis/{id}/nilai', [KuisController::class, 'daftarNilai'])->name('kuis.nilai');
    Route::delete('/kuis/{kuis_id}/reset/{murid_id}', [KuisController::class, 'resetKuis'])->name('kuis.reset');

    /* manajemen soal per-kuis */
    Route::get('/kuis/{id}/soal',          [SoalKuisController::class,'index'])->name('soal.index');
    Route::get('/kuis/{id}/soal/create',   [SoalKuisController::class,'create'])->name('soal.create');
    Route::post('/kuis/{id}/soal',         [SoalKuisController::class,'store'])->name('soal.store');
    Route::get('/soal/{soal}/edit',        [SoalKuisController::class,'edit'])->name('soal.edit');
    Route::put('/soal/{soal}',             [SoalKuisController::class,'update'])->name('soal.update');
    Route::delete('/soal/{soal}',          [SoalKuisController::class,'destroy'])->name('soal.destroy');

    /* rekapan nilai kuis*/
     Route::get('/kuis/{id}/nilai/export', [KuisController::class, 'exportNilai'])->name('kuis.rekap.export');

    /* route penilaian */
    Route::get('/penilaian', [PenilaianController::class, 'index'])->name('penilaian.index');
    Route::get('/penilaian/export', [PenilaianController::class, 'export'])->name('penilaian.export');



});

Route::middleware(['auth', 'murid'])->prefix('murid')->group(function () {
    Route::get('/materi', [MuridMateriController::class, 'index'])->name('murid.materi.index');
    Route::get('/materi/{id}', [MuridMateriController::class,'show' ])->name('murid.materi.show');

    Route::get('/kuis',        [KuisSiswaController::class,'index'])->name('murid.kuis.index');     
    Route::get('/kuis/{id}',   [KuisSiswaController::class,'show'])->name('murid.kuis.show');        
    Route::post('/kuis/{id}',  [KuisSiswaController::class,'submit'])->name('murid.kuis.submit');    

    Route::get('/nilai',       [KuisSiswaController::class,'nilai'])->name('murid.nilai.index');     
    Route::get('/nilai/{kuis_id}', [KuisSiswaController::class, 'detailNilai'])->name('murid.nilai.detail');

});
