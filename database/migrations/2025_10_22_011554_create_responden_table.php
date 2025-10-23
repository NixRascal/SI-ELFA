<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('responden', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('npm')->nullable();
            $table->string('email')->nullable();
            $table->enum('jenis_responden', ['mahasiswa', 'dosen', 'staff', 'alumni', 'stakeholder']);
            $table->string('fakultas')->nullable();
            $table->string('jurusan')->nullable();
            $table->string('sesi_token')->unique();
            $table->timestamp('waktu_pengisian')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('responden');
    }
};
