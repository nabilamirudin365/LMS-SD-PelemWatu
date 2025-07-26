<?php

namespace App\Http\Controllers;

use App\Models\Kuis;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\SoalKuis;
use App\Models\JawabanMurid;
use App\Models\NilaiKuis;

class KuisSiswaController extends Controller {

public function index()
{
    $murid = Auth::user();
    $kelas = $murid->kelas->first(); // ambil kelas pertama yang dia ikuti

    $kuisList = Kuis::with(['nilaiKuis','kelas'])
        ->where('kelas_id', $kelas?->id)
        ->whereDate('tanggal_mulai', '<=', Carbon::now())
        ->whereDate('tanggal_selesai', '>=', Carbon::now())
        ->latest()
        ->get();

    return view('murid.kuis_index', compact('kuisList'));
}

public function show($id)
{
    $kuis = Kuis::with('soal')->findOrFail($id);
    $murid = Auth::user();

    $sudahMengerjakan = NilaiKuis::where('murid_id', $murid->id)
                        ->where('kuis_id', $id)
                        ->exists();

    if ($sudahMengerjakan) {
        return redirect()
            ->route('murid.nilai.detail', $id)
            ->with('info', 'Kamu sudah mengerjakan kuis ini.');
    }

    return view('murid.kuis_show', compact('kuis'));
}


public function submit(Request $request, $id)
{
    $kuis = Kuis::with('soal')->findOrFail($id);
    $murid = Auth::user();

    $jawabanUser = $request->input('jawaban');
    $jumlahBenar = 0;

    foreach ($kuis->soal as $soal) {
        $jawaban = $jawabanUser[$soal->id] ?? null;

        $isBenar = $jawaban && $jawaban === $soal->jawaban_benar;
        if ($isBenar) $jumlahBenar++;

        JawabanMurid::updateOrCreate(
            [
                'murid_id'      => $murid->id,
                'soal_id'       => $soal->id, // pastikan kolom ini ada di tabel
            ],
            [
                'jawaban_dipilih'       => $jawaban,
                'benar'         => $isBenar ? 1 : 0,
            ]
        );
    }

    $totalSoal = $kuis->soal->count();
    $skor = $totalSoal > 0 ? round(($jumlahBenar / $totalSoal) * 100) : 0;

    NilaiKuis::updateOrCreate(
        ['murid_id' => $murid->id, 'kuis_id' => $kuis->id],
        ['skor' => $skor]
    );

    return redirect()
        ->route('murid.nilai.index') // konsisten dengan namanya di route
        ->with('success', 'Kuis berhasil dikerjakan! Nilai Anda: ' . $skor);
}

public function nilai()
{
    $murid = Auth::user();

    $nilaiList = NilaiKuis::with('kuis')
        ->where('murid_id', $murid->id)
        ->orderByDesc('updated_at')
        ->get();

    return view('murid.kuis_nilai', compact('nilaiList'));
}

public function detailNilai($kuis_id)
{
    $murid = Auth::user();

    $kuis = Kuis::with(['soal'])->findOrFail($kuis_id);

    // Ambil jawaban murid
    $jawaban = JawabanMurid::where('murid_id', $murid->id)
                ->whereIn('soal_id', $kuis->soal->pluck('id'))
                ->pluck('jawaban_dipilih', 'soal_id');

    // Ambil nilai
    $nilai = NilaiKuis::where('murid_id', $murid->id)
                ->where('kuis_id', $kuis_id)
                ->first();

    if (!$nilai) {
        return redirect()->route('murid.nilai.index')
            ->with('info', 'Belum ada data nilai untuk kuis ini.');
    }

    return view('murid.nilai_detail', compact('kuis', 'jawaban', 'nilai'));
}


}