<?php

// Quick debug script
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$kuesioner = App\Models\Kuesioner::first();
echo "Kuesioner: {$kuesioner->judul}\n";
echo "Target Responden: " . implode(',', $kuesioner->target_responden) . "\n";
echo "Pertanyaan count: " . $kuesioner->pertanyaan->count() . "\n";

$responden = App\Models\Responden::where('jenis_responden', 'mahasiswa')->first();
echo "\nSample Responden:\n";
echo "Nama: {$responden->nama}\n";
echo "Jenis: {$responden->jenis_responden}\n";

// Try create simple jawaban
$pertanyaan = $kuesioner->pertanyaan->first();
echo "\nPertanyaan: {$pertanyaan->teks_pertanyaan}\n";
echo "Jenis: {$pertanyaan->jenis_pertanyaan}\n";

try {
    $jawaban = App\Models\Jawaban::create([
        'kuesioner_id' => $kuesioner->id,
        'pertanyaan_id' => $pertanyaan->id,
        'responden_id' => $responden->id,
        'nilai_likert' => 5,
    ]);
    echo "\n✅ Jawaban created successfully! ID: {$jawaban->id}\n";
} catch (Exception $e) {
    echo "\n❌ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    echo "Trace:\n" . $e->getTraceAsString() . "\n";
}

echo "\nTotal Jawaban in DB: " . App\Models\Jawaban::count() . "\n";
