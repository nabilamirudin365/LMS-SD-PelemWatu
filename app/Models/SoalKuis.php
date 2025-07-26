<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoalKuis extends Model
{
    use HasFactory;

    protected $table = 'soal_kuis';
    protected $fillable = [
        'kuis_id', 'pertanyaan',
        'opsi_a', 'opsi_b', 'opsi_c', 'opsi_d',
        'jawaban_benar'
    ];

    /* relasi */
    public function kuis()
    {
        return $this->belongsTo(Kuis::class, 'kuis_id');
    }

    public function jawabanSiswa()
    {
        return $this->hasMany(JawabanSiswa::class, 'soal_id');
    }
}
