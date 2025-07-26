<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Kuis;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PenilaianExport;        // asumsi model murid = User dengan role 'murid'

class PenilaianController extends Controller
{
    public function index(Request $request)
    {
        // ----- Dropdown Kelas -----
        $kelasList = Kelas::orderBy('nama_kelas')->get();     // semua kelas

        // ----- Kelas yang dipilih (jika ada) -----
        $kelas_id       = $request->kelas_id;
        $kelasTerpilih  = $kelas_id ? Kelas::find($kelas_id) : null;

        // ----- Data Murid & Kuis -----
        $muridList = collect();   // default kosong
        $kuisList  = collect();

        if ($kelasTerpilih) {
            // murid dalam kelas tsb + relasi nilai
            $muridList = User::where('role', 'murid')
                ->whereHas('kelas', fn ($q) => $q->where('kelas.id', $kelas_id))
                ->with('nilaiKuis')   // relasi nilaiKuis pada model User
                ->orderBy('name')
                ->get();

            // semua kuis untuk kelas tsb
            $kuisList = Kuis::where('kelas_id', $kelas_id)
                ->orderBy('tanggal_mulai')
                ->get();
        }

        return view('guru.penilaian_index', compact(
            'kelasList',
            'kelasTerpilih',
            'muridList',
            'kuisList'
        ));
    }

    public function export(Request $request)
{
    $kelas_id = $request->kelas_id;

    if (!$kelas_id) {
        return redirect()->route('penilaian.index')
            ->with('error', 'Pilih kelas terlebih dahulu.');
    }

    return Excel::download(new PenilaianExport($kelas_id), 'penilaian_kelas_'.$kelas_id.'.xlsx');
}
}
