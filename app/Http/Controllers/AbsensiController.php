<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Absensi;
use App\Models\PresensiSiswa;
use App\Models\Kelas;
use App\Models\KelasMurid;
use App\Exports\RekapAbsensiExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
Carbon::setLocale('id');
setlocale(LC_TIME, 'id_ID.UTF-8');


class AbsensiController extends Controller
{
    public function index()
    {
        $absensiList = Absensi::with('kelas')->orderBy('tanggal', 'desc')->get ();
        return view('guru.absensi_index', compact('absensiList'));
    }

    public function create()
    {
        $kelasList = Kelas::all();
        return view('guru.absensi_create', compact('kelasList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        $absensi = Absensi::create([
            'kelas_id' => $request->kelas_id,
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
            'guru_id' => Auth::id(),
        ]);

        return redirect()->route('absensi.input', ['id' => $absensi->id])->with('success','Sesi Absensi berhasil ditambahkan');
    }

    public function input($id)
    {
        $absensi = Absensi::with('kelas')->findOrFail($id);
        $murid = User::whereHas('kelas', function ($query) use ($absensi) {
            $query->where('kelas.id', $absensi->kelas_id);
        })->get();

        return view('guru.absensi_input', [
            'absensi_id' => $absensi->id,
            'tanggal_absensi' => $absensi->tanggal,
            'kelas_nama' => $absensi->kelas->nama_kelas,
            'murid' => $murid,
        ]);
    }

    public function simpan(Request $request)
    {
        $absensi_id = $request->input('absensi_id');
        $data = $request->input('presensi');

        foreach ($data as $murid_id => $info) {
            PresensiSiswa::updateOrCreate(
                [
                    'absensi_id' => $absensi_id,
                    'murid_id' => $murid_id
                ],
                [
                    'status' => $info['status'],
                    'keterangan' => $info['keterangan'] ?? null
                ]
            );
        }

        return redirect()->route('absensi.input', ['id' => $absensi_id])->with('success', 'Absensi berhasil disimpan.');
    }

    public function rekapan(Request $request)
{
    $kelas_id = $request->input('kelas_id');
    $bulan = $request->input('bulan');
    $tahun = $request->input('tahun');

    $kelasList = Kelas::all();

    $query = PresensiSiswa::with(['murid.kelas', 'absensi.kelas', 'absensi']);

    if ($kelas_id) {
        $query->whereHas('absensi', function ($q) use ($kelas_id) {
            $q->where('kelas_id', $kelas_id);
        });
    }

    if ($bulan && $tahun) {
        $query->whereHas('absensi', function ($q) use ($bulan, $tahun) {
            $q->whereMonth('tanggal', $bulan)
              ->whereYear('tanggal', $tahun);
        });
    }

    $rekapList = $query->orderByDesc('absensi_id')->get();

    return view('guru.absensi_rekapan', compact('rekapList', 'kelasList', 'kelas_id', 'bulan', 'tahun'));
}

    public function export(Request $request)
{
    $kelas_id = $request->input('kelas_id');
    $bulan = $request->input('bulan');
    $tahun = $request->input('tahun');

    $kelas = null;
    if ($kelas_id) {
        $kelas = Kelas::find($kelas_id);
    }

    $namaKelas = $kelas ? $kelas->nama_kelas : 'Semua-Kelas';

    // Format nama bulan Indonesia dari angka
    $namaBulan = $bulan ? Carbon::createFromDate($tahun, $bulan, 1)->translatedFormat('F') : 'Semua-Bulan';
    $fileName = 'rekap-absensi-' . $namaKelas . '-' . $namaBulan . '-' . $tahun . '.xlsx';

    return Excel::download(new RekapAbsensiExport($kelas_id, $bulan, $tahun), $fileName);
}

public function destroy($id)
{
    $absensi = Absensi::findOrFail($id);
    
    // Dengan onDelete('cascade'), baris ini akan otomatis menghapus
    // semua data presensi_siswa yang terkait.
    $absensi->delete();

    return redirect()->route('absensi.index')->with('success', 'Sesi absensi berhasil dihapus.');
}


}
