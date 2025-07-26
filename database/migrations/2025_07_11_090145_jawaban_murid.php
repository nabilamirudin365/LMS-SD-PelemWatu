<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jawaban_murid', function (Blueprint $table) {
            $table->id();
            $table->foreignId('murid_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('soal_id')->constrained('soal_kuis')->onDelete('cascade');
            $table->enum('jawaban_dipilih', ['a', 'b', 'c', 'd']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jawaban_murid');
    }
};