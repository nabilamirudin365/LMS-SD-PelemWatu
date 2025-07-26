<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nilai_kuis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('murid_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('kuis_id')->constrained('kuis')->onDelete('cascade');
            $table->integer('skor');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nilai_kuis');
    }
};