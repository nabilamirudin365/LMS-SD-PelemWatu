<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PresensiSiswa extends Model
{
    protected $table = 'presensi_siswa';
    protected $fillable = ['absensi_id', 'murid_id', 'status', 'keterangan'];

    public function absensi(): BelongsTo
    {
        return $this->belongsTo(Absensi::class);
    }

    public function murid(): BelongsTo
    {
        return $this->belongsTo(User::class, 'murid_id');
    }
}