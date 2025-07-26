<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // 1. Tabel kelas
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kelas');
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });

        // 2. Tabel kelas_murid (pivot)
        Schema::create('kelas_murid', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
            $table->foreignId('murid_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        // 3. Tabel absensi
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
            $table->date('tanggal');
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });

        // 4. Tabel presensi_siswa
        Schema::create('presensi_siswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('absensi_id')->constrained('absensi')->onDelete('cascade');
            $table->foreignId('murid_id')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['hadir', 'tidak_hadir', 'izin'])->default('hadir');
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('presensi_siswa');
        Schema::dropIfExists('absensi');
        Schema::dropIfExists('kelas_murid');
        Schema::dropIfExists('kelas');
    }
};
