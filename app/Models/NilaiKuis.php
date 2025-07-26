<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiKuis extends Model
{
    use HasFactory;

    protected $table = 'nilai_kuis';
    protected $fillable = [
        'murid_id', 'kuis_id', 'skor'
    ];

    public function kuis()
    {
        return $this->belongsTo(Kuis::class, 'kuis_id');
    }

    public function murid()
    {
        return $this->belongsTo(User::class, 'murid_id');
    }
}
