<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // Tambah kelas
        DB::table('kelas')->insert([
            ['nama_kelas' => '5A', 'deskripsi' => 'Kelas 5A', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kelas' => '5B', 'deskripsi' => 'Kelas 5B', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kelas' => '5C', 'deskripsi' => 'Kelas 5C', 'created_at' => now(), 'updated_at' => now()]
        ]);

        // Tambah murid
        DB::table('users')->insert([
            ['name' => 'Ani', 'email' => 'ani@gmail.com', 'password' => Hash::make('123'), 'role' => 'murid', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Budi', 'email' => 'budi@gmail.com', 'password' => Hash::make('123'), 'role' => 'murid', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Joko', 'email' => 'joko@gmail.com', 'password' => Hash::make('123'), 'role' => 'murid', 'created_at' => now(), 'updated_at' => now()]
        ]);

        // Tambah relasi kelas murid
        DB::table('kelas_murid')->insert([
            ['kelas_id' => 1, 'murid_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['kelas_id' => 1, 'murid_id' => 3, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Tambah sesi absensi
        DB::table('absensi')->insert([
            ['kelas_id' => 1, 'tanggal' => Carbon::today(), 'keterangan' => 'Pertemuan 1', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Tambah presensi siswa
        DB::table('presensi_siswa')->insert([
            ['absensi_id' => 1, 'murid_id' => 2, 'status' => 'hadir', 'keterangan' => '', 'created_at' => now(), 'updated_at' => now()],
            ['absensi_id' => 1, 'murid_id' => 3, 'status' => 'izin', 'keterangan' => 'Sakit', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
