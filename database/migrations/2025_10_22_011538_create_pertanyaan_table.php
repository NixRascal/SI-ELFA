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
        Schema::create('pertanyaan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kuesioner_id')->constrained('kuesioner')->onDelete('cascade');
            $table->text('teks_pertanyaan');
            $table->enum('jenis_pertanyaan', ['likert', 'pilihan_ganda', 'isian']);
            $table->json('opsi_jawaban')->nullable();
            $table->integer('urutan');
            $table->boolean('wajib_diisi')->default(true);
            $table->string('kategori')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pertanyaan');
    }
};
