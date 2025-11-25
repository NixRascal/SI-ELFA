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
        Schema::create('kuesioner', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->string('icon')->nullable();
            $table->json('target_responden')->default('["mahasiswa"]');
            $table->boolean('status_aktif')->default(true);
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->foreignId('dibuat_oleh')->constrained('admin')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kuesioner');
    }
};
