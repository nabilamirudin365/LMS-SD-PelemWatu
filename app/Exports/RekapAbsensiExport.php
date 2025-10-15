<?php

namespace App\Exports;

use App\Models\Kelas;
use App\Models\User;
use App\Models\PresensiSiswa;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Carbon\Carbon;

class RekapAbsensiExport implements FromView, WithTitle, WithEvents
{
    protected $kelas_id;
    protected $bulan;
    protected $tahun;

    // Pastikan constructor menerima nilai default null
    public function __construct($kelas_id = null, $bulan = null, $tahun = null)
    {
        $this->kelas_id = $kelas_id;
        $this->bulan = (int) ($bulan ?? Carbon::now()->month);
        $this->tahun = (int) ($tahun ?? Carbon::now()->year);
    }

    public function view(): View
    {
        $kelas = Kelas::find($this->kelas_id);
        $daysInMonth = Carbon::createFromDate($this->tahun, $this->bulan)->daysInMonth;
        
        // ... (Logika untuk mengambil $rekapData tetap sama seperti sebelumnya)
        $muridDiKelas = User::whereHas('kelas', function ($q) {
            $q->where('kelas.id', $this->kelas_id);
        })->orderBy('name')->get();

        $presensi = PresensiSiswa::with('absensi')
            ->whereHas('absensi', function ($q) {
                $q->where('kelas_id', $this->kelas_id)
                    ->whereMonth('tanggal', $this->bulan)
                    ->whereYear('tanggal', $this->tahun);
            })->get();

        $rekapData = [];
        foreach ($muridDiKelas as $murid) {
            $kehadiran = [];
            $rekapSiswa = ['H' => 0, 'S' => 0, 'I' => 0, 'A' => 0];

            for ($i = 1; $i <= $daysInMonth; $i++) {
                $tanggalCek = Carbon::createFromDate($this->tahun, $this->bulan, $i)->format('Y-m-d');
                $presensiHariIni = $presensi->first(function ($p) use ($murid, $tanggalCek) {
                    return $p->murid_id == $murid->id && $p->absensi->tanggal == $tanggalCek;
                });
                
                $status = '';
                if ($presensiHariIni) {
                    $status = strtoupper(substr($presensiHariIni->status, 0, 1));
                    if (isset($rekapSiswa[$status])) {
                        $rekapSiswa[$status]++;
                    }
                }
                $kehadiran[$i] = $status;
            }
            $rekapData[$murid->id] = [
                'nama' => $murid->name,
                'kehadiran' => $kehadiran,
                'rekapSiswa' => $rekapSiswa
            ];
        }


        return view('guru.absensi_export', [
            'rekapData' => $rekapData,
            'kelas' => $kelas,
            // Menggunakan Carbon untuk mengubah angka bulan menjadi nama bulan (string)
            'bulan' => Carbon::create()->month($this->bulan)->translatedFormat('F'),
            'tahun' => $this->tahun,
            'daysInMonth' => $daysInMonth
        ]);
    }

    public function title(): string
    {
        // PERBAIKAN DI SINI:
        // Gunakan $this->bulan (angka) untuk membuat objek Carbon
        $namaBulan = Carbon::create()->month($this->bulan)->format('M');
        return 'Absensi ' . $namaBulan . ' ' . $this->tahun;
    }

    public function registerEvents(): array
    {
        // ... (kode events tetap sama)
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getDelegate()->getStyle('A1:AJ100')->getAlignment()->setVertical('center');
                $event->sheet->getDelegate()->getStyle('A1:AJ100')->getAlignment()->setHorizontal('center');
            },
        ];
    }
}