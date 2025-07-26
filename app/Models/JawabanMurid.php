<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanMurid extends Model
{
    use HasFactory;

    protected $table = 'jawaban_murid';
    protected $fillable = [
        'murid_id', 'soal_id', 'jawaban_dipilih'
    ];

    public function siswa()
    {
        return $this->belongsTo(User::class, 'murid_id');
    }

    public function soal()
    {
        return $this->belongsTo(SoalKuis::class, 'soal_id');
    }
}
