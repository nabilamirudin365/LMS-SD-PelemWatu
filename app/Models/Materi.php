<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    use HasFactory;

    protected $table = 'materi';

    protected $fillable = [
        'judul',
        'kategori_id',
        'deskripsi',
        'file_path',
    ];

    // app/Models/Materi.php
public function kategori()
{
    return $this->belongsTo(KategoriMateri::class, 'kategori_id');
}

}
