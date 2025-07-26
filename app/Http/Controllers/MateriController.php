<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Materi;
use Illuminate\Support\Facades\Storage;
use App\Models\KategoriMateri;


class MateriController extends Controller
{

    public function index(Request $request)
{
    $keyword     = $request->input('keyword');
    $kategori_id = $request->input('kategori_id');

    // ambil semua kategori untuk dropdown
    $kategoriList = KategoriMateri::orderBy('nama_kategori')->get();

    $materiList = Materi::with('kategori')
    ->when($keyword, function ($query) use ($keyword) {
        $query->where(function ($sub) use ($keyword) {
            $sub->where('judul', 'like', "%$keyword%")
                ->orWhere('deskripsi', 'like', "%$keyword%");
        });
    })
    ->when($kategori_id, function ($query) use ($kategori_id) {
        $query->where('kategori_id', $kategori_id);
    })
    ->latest()
    ->paginate(10);


    return view('guru.materi_index', compact('materiList', 'kategoriList'));
}



    public function create()
{
    $kategoriList = KategoriMateri::orderBy('nama_kategori')->get();
    return view('guru.materi_create', compact('kategoriList'));
}

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori_materi,id',
            'deskripsi' => 'nullable|string',
            'file_path' => 'nullable|file|mimes:pdf,jpg,jpeg,png,gif,pptx|max:20048',
        ]);

        $filePath = null;

        if ($request->hasFile('file_path')) {
            $filePath = $request->file('file_path')->store('materi', 'public');
        }

        Materi::create([
            'judul' => $request->judul,
            'kategori_id' => $request->kategori_id,
            'deskripsi' => $request->deskripsi,
            'file_path' => $filePath,
        ]);

        return redirect()->route('materi.index')->with('success', 'Materi berhasil ditambahkan.');
    }

    public function show($id){
        $materi = Materi::findOrFail($id);
        return view('guru.materi_show', compact('materi'));
    }

    public function edit($id)
{
    $materi        = Materi::findOrFail($id);
    $kategoriList  = KategoriMateri::orderBy('nama_kategori')->get();
    return view('guru.materi_edit', compact('materi', 'kategoriList'));
}

    public function update(Request $request, $id)
{
    $request->validate([
        'judul' => 'required|string|max:255',
        'kategori_id' => 'required|exists:kategori_materi,id',
        'deskripsi' => 'nullable|string',
        'file' => 'nullable|file|mimes:pdf,docx,pptx,png,jpg,jpeg,gif|max:20048',
    ]);

    $materi = Materi::findOrFail($id);
    $materi->judul = $request->judul;
    $materi->kategori_id = $request->kategori_id;
    $materi->deskripsi = $request->deskripsi;

    if ($request->hasFile('file')) {
    // Hapus file lama
    if ($materi->file_path && Storage::exists('public/' . $materi->file_path)) {
        Storage::delete('public/' . $materi->file_path);
    }

    // Simpan file baru
    $filePath = $request->file('file')->store('materi', 'public');
    $materi->file_path = $filePath;
}

    $materi->save();

    return redirect()->route('materi.index')->with('success', 'Materi berhasil diperbarui.');
}

    public function destroy($id)
    {
    $materi = Materi::findOrFail($id);
    if ($materi->file_path && \Storage::disk('public')->exists($materi->file_path)) {
        \Storage::disk('public')->delete($materi->file_path);
    }
    $materi->delete();

    return redirect()->route('materi.index')->with('success', 'Materi berhasil dihapus.');
    }


}
