<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kuis;
use App\Models\Kelas;          
use Carbon\Carbon;
use App\Models\JawabanMurid;
use App\Models\NilaiKuis;
use App\Exports\RekapNilaiExport;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class KuisController extends Controller
{
    /* ======================== INDEX ======================== */
    public function index()
    {
        // daftar kuis milik semua kelas (bisa difilter nanti)
        $kuisList = Kuis::with('kelas')
                        ->latest()
                        ->paginate(10);

        return view('guru.kuis_index', compact('kuisList'));
    }

    /* ======================== CREATE ======================= */
    public function create()
    {
        $kelasList = Kelas::orderBy('nama_kelas')->get();
        return view('guru.kuis_create', compact('kelasList'));
    }

    /* ========================= STORE ======================= */
    public function store(Request $request)
    {
        $request->validate([
            'judul'           => 'required|string|max:255',
            'kelas_id'        => 'required|exists:kelas,id',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'deskripsi'       => 'nullable|string',
        ]);

        $kuis = Kuis::create([
            'judul'           => $request->judul,
            'kelas_id'        => $request->kelas_id,
            'deskripsi'       => $request->deskripsi,
            'tanggal_mulai'   => Carbon::parse($request->tanggal_mulai),
            'tanggal_selesai' => Carbon::parse($request->tanggal_selesai),
        ]);

        return redirect()
            ->route('soal.index', $kuis->id)
            ->with('success', 'Kuis berhasil dibuat. Silakan tambahkan soal.');
    }

    /* ========================= EDIT ======================== */
    public function edit($id)
    {
        $kuis       = Kuis::findOrFail($id);
        $kelasList  = Kelas::orderBy('nama_kelas')->get();

        return view('guru.kuis_edit', compact('kuis', 'kelasList'));
    }

    /* ======================== UPDATE ======================= */
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul'           => 'required|string|max:255',
            'kelas_id'        => 'required|exists:kelas,id',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'deskripsi'       => 'nullable|string',
        ]);

        $kuis = Kuis::findOrFail($id);
        $kuis->update([
            'judul'           => $request->judul,
            'kelas_id'        => $request->kelas_id,
            'deskripsi'       => $request->deskripsi,
            'tanggal_mulai'   => Carbon::parse($request->tanggal_mulai),
            'tanggal_selesai' => Carbon::parse($request->tanggal_selesai),
        ]);

        return redirect()
            ->route('kuis.index')
            ->with('success', 'Kuis berhasil diperbarui.');
    }

    /* ======================= DESTROY ======================= */
    public function destroy($id)
    {
        $kuis = Kuis::findOrFail($id);
        $kuis->delete();

        return redirect()
            ->route('kuis.index')
            ->with('success', 'Kuis berhasil dihapus.');
    }

public function resetKuis($kuis_id, $murid_id)
{
    // Hapus semua jawaban murid untuk kuis ini
    JawabanMurid::where('murid_id', $murid_id)
        ->whereHas('soal', function ($query) use ($kuis_id) {
            $query->where('kuis_id', $kuis_id);
        })->delete();

    // Hapus nilai
    NilaiKuis::where('murid_id', $murid_id)
        ->where('kuis_id', $kuis_id)
        ->delete();

    return back()->with('success', 'Nilai dan jawaban murid berhasil direset.');
}


public function daftarNilai($id)
{
    $kuis = Kuis::with('kelas')->findOrFail($id);

    // Ambil semua nilai untuk kuis ini
    $nilaiList = NilaiKuis::with('murid')
        ->where('kuis_id', $id)
        ->get();

    return view('guru.kuis_nilai', compact('kuis', 'nilaiList'));
}

public function exportNilai($id)
{
    $kuis = Kuis::findOrFail($id);

    // nama file: nilai-kuis-nama-kelas-judul.xlsx
    $fileName = 'nilai-kuis-' . Str::slug($kuis->kelas->nama_kelas) .
                '-' . Str::slug($kuis->judul) . '.xlsx';

    return Excel::download(new RekapNilaiExport($kuis->id), $fileName);
}

}
