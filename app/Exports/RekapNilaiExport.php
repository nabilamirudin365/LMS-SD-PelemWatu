<?php
namespace App\Exports;

use App\Models\NilaiKuis;
use App\Models\Kuis;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RekapNilaiExport implements FromCollection, WithHeadings
{
    protected $kuis_id;

    public function __construct($kuis_id)
    {
        $this->kuis_id = $kuis_id;
    }

    public function collection()
    {
        return NilaiKuis::with('murid')
            ->where('kuis_id', $this->kuis_id)
            ->get()
            ->map(function ($nilai) {
                return [
                    'Nama Murid' => $nilai->murid->name,
                    'Skor' => $nilai->skor,
                ];
            });
    }

    public function headings(): array
    {
        return ['Nama Murid', 'Skor'];
    }
}
