<?php

namespace App\Exports;

use App\Models\PresensiSiswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RekapAbsensiExport implements FromCollection, WithHeadings
{
    protected $kelas_id;
    protected $bulan;
    protected $tahun;

    public function __construct($kelas_id = null, $bulan = null, $tahun = null)
    {
        $this->kelas_id = $kelas_id;
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function collection()
    {
        $query = PresensiSiswa::with(['murid', 'absensi.kelas']);

        if ($this->kelas_id) {
            $query->whereHas('absensi', function ($q) {
                $q->where('kelas_id', $this->kelas_id);
            });
        }

        if ($this->bulan && $this->tahun) {
            $query->whereHas('absensi', function ($q) {
                $q->whereMonth('tanggal', $this->bulan)
                  ->whereYear('tanggal', $this->tahun);
            });
        }

        return $query->get()->map(function ($item) {
            return [
                'Nama' => $item->murid->name,
                'Kelas' => $item->absensi->kelas->nama_kelas,
                'Tanggal' => $item->absensi->tanggal,
                'Status' => ucfirst($item->status),
                'Keterangan' => $item->keterangan,
            ];
        });
    }

    public function headings(): array
    {
        return ['Nama', 'Kelas', 'Tanggal', 'Status', 'Keterangan'];
    }
}

