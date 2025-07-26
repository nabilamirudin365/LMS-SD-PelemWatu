<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kuis extends Model
{
    protected $table = 'kuis';
    protected $fillable = ['judul', 'deskripsi', 'kelas_id', 'tanggal_mulai', 'tanggal_selesai'];

    public function kelas() {
        return $this->belongsTo(Kelas::class);
    }

    public function soal() {
        return $this->hasMany(SoalKuis::class);
    }

    public function nilai() {
        return $this->hasMany(NilaiKuis::class);
    }

    public function nilaiKuis()   // <─ nama relasi konsisten
    {
        return $this->hasMany(NilaiKuis::class, 'kuis_id');
    }
    
}
