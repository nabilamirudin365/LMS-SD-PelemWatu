<?php

namespace App\Exports;

use App\Models\Kuis;
use App\Models\User;
use App\Models\Kelas;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PenilaianExport implements FromView
{
    protected $kelas_id;

    public function __construct($kelas_id)
    {
        $this->kelas_id = $kelas_id;
    }

    public function view(): View
    {
        $kelas = Kelas::findOrFail($this->kelas_id);
        $kuisList = Kuis::where('kelas_id', $kelas->id)->orderBy('tanggal_mulai')->get();
        $muridList = User::where('role', 'murid')
            ->whereHas('kelas', fn($q) => $q->where('kelas.id', $kelas->id))
            ->with('nilaiKuis')
            ->orderBy('name')
            ->get();

        return view('exports.penilaian_excel', [
            'kelas' => $kelas,
            'kuisList' => $kuisList,
            'muridList' => $muridList
        ]);
    }
}
