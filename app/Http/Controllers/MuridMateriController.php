<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Materi;
use App\Models\KategoriMateri;

class MuridMateriController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        $kategori_id = $request->input('kategori_id');

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

        $kategoriList = KategoriMateri::all();

        return view('murid.materi_index', compact('materiList', 'kategoriList'));
    }

    public function show($id)
    {
        $materi = Materi::with('kategori')->findOrFail($id);
        return view('murid.materi_show', compact('materi'));
    }

}
