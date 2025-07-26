<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Absensi;
use App\Models\Kuis;
use App\Models\Materi;
use App\Models\NilaiKuis;
use App\Models\PresensiSiswa;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
Carbon::setLocale('id');
setlocale(LC_TIME, 'id_ID.UTF-8');

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data = [];

        if ($user->role === 'guru') {
            // ... (logika untuk guru yang sudah ada)
            $data['jumlahMurid'] = User::where('role', 'murid')->count();
            $data['absensiHariIni'] = Absensi::where('guru_id', $user->id)
                                             ->whereDate('tanggal', Carbon::today())
                                             ->exists();
        }

        if ($user->role === 'murid') {
            // 1. Ambil ID kuis yang sudah dikerjakan murid
            $kuisSudahDikerjakanIds = NilaiKuis::where('murid_id', $user->id)->pluck('kuis_id');

            // 2. Data untuk Kartu Statistik
            $data['kuisDikerjakan'] = $kuisSudahDikerjakanIds->count();
            $data['rataRataNilai'] = NilaiKuis::where('murid_id', $user->id)->avg('skor') ?? 0;
            $data['kehadiranBulanIni'] = PresensiSiswa::where('murid_id', $user->id)
                                        ->where('status', 'hadir')
                                        ->whereMonth('created_at', Carbon::now()->month)
                                        ->count();
            
            // 3. Ambil Kuis yang Tersedia (belum dikerjakan)
            $data['kuisTersedia'] = Kuis::whereNotIn('id', $kuisSudahDikerjakanIds)
                                      ->where('tanggal_selesai', '>=', Carbon::now()) // Hanya yang masih aktif
                                      ->latest()
                                      ->take(5)
                                      ->get();

            // 4. Ambil Materi Terbaru
            $data['materiTerbaru'] = Materi::latest()->take(3)->get();

            // 5. Ambil Nilai Terakhir
            $data['nilaiTerakhir'] = NilaiKuis::where('murid_id', $user->id)
                                       ->with('kuis') // ambil juga data kuisnya
                                       ->latest()
                                       ->first();
        }

        return view('dashboard', $data);
    }
}