<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriMateri extends Model
{
    use HasFactory;

    protected $table = 'kategori_materi';      // ← nama tabel
    protected $fillable = ['nama_kategori', 'deskripsi'];

    /* Relasi: satu kategori punya banyak materi */
    public function materi()
    {
        return $this->hasMany(Materi::class, 'kategori_id');
    }
}
