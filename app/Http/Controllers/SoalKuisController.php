<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kuis;
use App\Models\SoalKuis;

class SoalKuisController extends Controller
{
    /* =====================================================
     *  INDEX – daftar semua soal untuk 1 kuis
     *  GET  /guru/kuis/{id}/soal
     *  Name : soal.index
     * ===================================================== */
    public function index($id)
    {
        $kuis = Kuis::with('soal')->with('kelas')->findOrFail($id);
        return view('guru.kuis_soal', compact('kuis'));
    }

    /* =====================================================
     *  CREATE – form tambah soal
     *  GET  /guru/kuis/{id}/soal/create
     *  Name : soal.create
     * ===================================================== */
    public function create($id)
    {
        $kuis = Kuis::findOrFail($id);
        return view('guru.soal_create', compact('kuis'));          // (buat view terpisah jika mau wizard)
    }

    /* =====================================================
     *  STORE – simpan soal baru
     *  POST /guru/kuis/{id}/soal
     *  Name : soal.store
     * ===================================================== */
    public function store(Request $request, $id)
    {
        $request->validate([
            'pertanyaan'     => 'required|string',
            'opsi_a'         => 'required|string',
            'opsi_b'         => 'required|string',
            'opsi_c'         => 'required|string',
            'opsi_d'         => 'required|string',
            'jawaban_benar'  => 'required|in:a,b,c,d',
        ]);

        SoalKuis::create([
            'kuis_id'       => $id,
            'pertanyaan'    => $request->pertanyaan,
            'opsi_a'        => $request->opsi_a,
            'opsi_b'        => $request->opsi_b,
            'opsi_c'        => $request->opsi_c,
            'opsi_d'        => $request->opsi_d,
            'jawaban_benar' => $request->jawaban_benar,
        ]);

        return redirect()
            ->route('soal.index', $id)
            ->with('success', 'Soal berhasil ditambahkan.');
    }

    /* =====================================================
     *  EDIT – form edit soal
     *  GET  /soal/{soal}/edit
     *  Name : soal.edit
     * ===================================================== */
    public function edit(SoalKuis $soal)
{
    $kuis = $soal->kuis;          // relasi belongsTo di model SoalKuis

    return view('guru.soal_edit', compact('soal', 'kuis'));
}

    /* =====================================================
     *  UPDATE – simpan perubahan soal
     *  PUT /soal/{soal}
     *  Name : soal.update
     * ===================================================== */
    public function update(Request $request, SoalKuis $soal)
    {
        $request->validate([
            'pertanyaan'     => 'required|string',
            'opsi_a'         => 'required|string',
            'opsi_b'         => 'required|string',
            'opsi_c'         => 'required|string',
            'opsi_d'         => 'required|string',
            'jawaban_benar'  => 'required|in:a,b,c,d',
        ]);

        $soal->update($request->only([
            'pertanyaan','opsi_a','opsi_b','opsi_c','opsi_d','jawaban_benar'
        ]));

        return redirect()
            ->route('soal.index', $soal->kuis_id)
            ->with('success', 'Soal berhasil diperbarui.');
    }

    /* =====================================================
     *  DESTROY – hapus soal
     *  DELETE /soal/{soal}
     *  Name : soal.destroy
     * ===================================================== */
    public function destroy(SoalKuis $soal)
    {
        $kuis_id = $soal->kuis_id;
        $soal->delete();

        return redirect()
            ->route('soal.index', $kuis_id)
            ->with('success', 'Soal berhasil dihapus.');
    }
}
