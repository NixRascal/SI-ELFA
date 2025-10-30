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
        Schema::create('jawaban', function (Blueprint $table) {
            $table->id();
            $table->foreignId('responden_id')->constrained('responden')->onDelete('cascade');
            $table->foreignId('kuesioner_id')->constrained('kuesioner')->onDelete('cascade');
            $table->foreignId('pertanyaan_id')->constrained('pertanyaan')->onDelete('cascade');
            $table->text('isi_jawaban');
            $table->integer('nilai_likert')->nullable();
            $table->timestamps();

            // Index untuk performa query
            $table->index(['responden_id', 'kuesioner_id']);
            
            // UNIQUE CONSTRAINT: Satu responden hanya bisa menjawab satu pertanyaan satu kali
            // Mencegah duplicate jawaban untuk pertanyaan yang sama
            $table->unique(['responden_id', 'pertanyaan_id'], 'unique_jawaban_per_pertanyaan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawaban');
    }
};
