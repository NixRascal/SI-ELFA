<?php

namespace Database\Seeders;

use App\Models\Kuesioner;
use App\Models\Pertanyaan;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SampelKuesionerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kuesioner1 = Kuesioner::create([
            'judul' => 'Survei Kepuasan Layanan Akademik',
            'deskripsi' => 'Berikan penilaian Anda terhadap layanan akademik yang diterima di fakultas.',
            'icon' => 'fa-smile',
            'target_responden' => 'mahasiswa',
            'status_aktif' => true,
            'tanggal_mulai' => now(),
            'tanggal_selesai' => now()->addMonth(),
            'dibuat_oleh' => 1,
        ]);

        $pertanyaanakademik = [
            ['text' => 'Layanan bimbingan akademik dosen sangat membantu', 'category' => 'Bimbingan Akademik'],
            ['text' => 'Dosen mudah ditemui untuk konsultasi akademik', 'category' => 'Bimbingan Akademik'],
            ['text' => 'Proses pendaftaran mata kuliah mudah dan jelas', 'category' => 'Administrasi Akademik'],
            ['text' => 'Informasi akademik disampaikan dengan jelas dan tepat waktu', 'category' => 'Administrasi Akademik'],
            ['text' => 'Fasilitas ruang kuliah nyaman dan mendukung pembelajaran', 'category' => 'Fasilitas'],
            ['text' => 'Perpustakaan menyediakan buku dan referensi yang memadai', 'category' => 'Fasilitas'],
        ];

        foreach ($pertanyaanakademik as $index => $pertanyaan) {
            Pertanyaan::create([
                'kuesioner_id' => $kuesioner1->id,
                'teks_pertanyaan' => $pertanyaan['text'],
                'jenis_pertanyaan' => 'likert',
                'kategori' => $pertanyaan['category'],
                'urutan' => $index + 1,
                'wajib_diisi' => true,
            ]);
        }

        $kuesioner2 = Kuesioner::create([
            'judul' => 'Survei Kepuasan Layanan Laboratorium',
            'deskripsi' => 'Evaluasi terhadap fasilitas dan layanan laboratorium fakultas.',
            'icon' => 'fas fa-flask',
            'target_responden' => 'mahasiswa',
            'status_aktif' => true,
            'tanggal_mulai' => now(),
            'tanggal_selesai' => now()->addMonth(1),
            'dibuat_oleh' => 1,
        ]);

        $pertanyaanlab = [
            ['text' => 'Peralatan laboratorium dalam kondisi baik dan berfungsi dengan sempurna', 'category' => 'Fasilitas Lab'],
            ['text' => 'Asisten laboratorium memberikan bimbingan yang memadai', 'category' => 'Layanan Lab'],
            ['text' => 'Jadwal praktikum sesuai dengan kebutuhan mahasiswa', 'category' => 'Administrasi Lab'],
            ['text' => 'Keamanan dan kebersihan laboratorium terjaga dengan baik', 'category' => 'Fasilitas Lab'],
        ];

        foreach ($pertanyaanlab as $index => $pertanyaan) {
            Pertanyaan::create([
                'kuesioner_id' => $kuesioner2->id,
                'teks_pertanyaan' => $pertanyaan['text'],
                'jenis_pertanyaan' => 'likert',
                'kategori' => $pertanyaan['category'],
                'urutan' => $index + 1,
                'wajib_diisi' => true,
            ]);
        }

        $kuesioner3 = Kuesioner::create([
            'judul' => 'Evaluasi Kinerja Dosen',
            'deskripsi' => 'Penilaian terhadap kinerja dosen dalam proses pembelajaran.',
            'icon' => 'fas fa-chalkboard-teacher',
            'target_responden' => 'mahasiswa',
            'status_aktif' => true,
            'tanggal_mulai' => now(),
            'tanggal_selesai' => now()->addMonth(1),
            'dibuat_oleh' => 1,
        ]);

        $pertanyaandosen = [
            ['text' => 'Dosen menguasai materi perkuliahan dengan baik', 'category' => 'Kompetensi Akademik'],
            ['text' => 'Metode pengajaran dosen mudah dipahami', 'category' => 'Metode Pengajaran'],
            ['text' => 'Dosen memberikan feedback yang konstruktif', 'category' => 'Komunikasi'],
            ['text' => 'Dosen hadir tepat waktu dalam perkuliahan', 'category' => 'Kedisiplinan'],
            ['text' => 'Dosen responsif terhadap pertanyaan mahasiswa', 'category' => 'Komunikasi'],
        ];

        foreach ($pertanyaandosen as $index => $pertanyaan) {
            Pertanyaan::create([
                'kuesioner_id' => $kuesioner3->id,
                'teks_pertanyaan' => $pertanyaan['text'],
                'jenis_pertanyaan' => 'likert',
                'kategori' => $pertanyaan['category'],
                'urutan' => $index + 1,
                'wajib_diisi' => true,
            ]);
        }
    }
}
