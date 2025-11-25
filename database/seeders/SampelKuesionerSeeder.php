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
            'target_responden' => ['mahasiswa'],
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
            'target_responden' => ['mahasiswa'],
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
            'target_responden' => ['mahasiswa'],
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

        $kuesioner4 = Kuesioner::create([
            'judul' => 'Survei Kepuasan Layanan Administrasi',
            'deskripsi' => 'Penilaian terhadap pelayanan administrasi fakultas seperti surat-menyurat dan layanan keuangan.',
            'icon' => 'fas fa-file-alt',
            'target_responden' => ['mahasiswa'],
            'status_aktif' => true,
            'tanggal_mulai' => now(),
            'tanggal_selesai' => now()->addMonth(),
            'dibuat_oleh' => 1,
        ]);

        $pertanyaanadm = [
            ['text' => 'Proses pengurusan surat berjalan cepat dan efisien', 'category' => 'Prosedur'],
            ['text' => 'Petugas administrasi bersikap ramah dan membantu', 'category' => 'Pelayanan'],
            ['text' => 'Jam pelayanan administrasi sesuai dengan kebutuhan mahasiswa', 'category' => 'Ketersediaan'],
            ['text' => 'Informasi mengenai prosedur administrasi mudah diakses', 'category' => 'Transparansi'],
        ];

        foreach ($pertanyaanadm as $index => $pertanyaan) {
            Pertanyaan::create([
                'kuesioner_id' => $kuesioner4->id,
                'teks_pertanyaan' => $pertanyaan['text'],
                'jenis_pertanyaan' => 'likert',
                'kategori' => $pertanyaan['category'],
                'urutan' => $index + 1,
                'wajib_diisi' => true,
            ]);
        }

        $kuesioner5 = Kuesioner::create([
            'judul' => 'Survei Kepuasan Fasilitas Kampus',
            'deskripsi' => 'Evaluasi terhadap kebersihan, kenyamanan, dan keamanan fasilitas di lingkungan kampus.',
            'icon' => 'fas fa-building',
            'target_responden' => ['mahasiswa'],
            'status_aktif' => true,
            'tanggal_mulai' => now(),
            'tanggal_selesai' => now()->addMonth(),
            'dibuat_oleh' => 1,
        ]);

        $pertanyaankampus = [
            ['text' => 'Ruang kelas dan toilet selalu bersih dan terawat', 'category' => 'Kebersihan'],
            ['text' => 'Area parkir cukup luas dan aman', 'category' => 'Keamanan'],
            ['text' => 'Sarana olahraga dan ruang terbuka memadai', 'category' => 'Fasilitas Umum'],
            ['text' => 'Kantin menyediakan makanan dengan harga dan kualitas baik', 'category' => 'Layanan Penunjang'],
        ];

        foreach ($pertanyaankampus as $index => $pertanyaan) {
            Pertanyaan::create([
                'kuesioner_id' => $kuesioner5->id,
                'teks_pertanyaan' => $pertanyaan['text'],
                'jenis_pertanyaan' => 'likert',
                'kategori' => $pertanyaan['category'],
                'urutan' => $index + 1,
                'wajib_diisi' => true,
            ]);
        }

        $kuesioner6 = Kuesioner::create([
            'judul' => 'Survei Kepuasan Layanan Teknologi Informasi',
            'deskripsi' => 'Penilaian terhadap layanan IT seperti sistem akademik dan jaringan internet.',
            'icon' => 'fas fa-wifi',
            'target_responden' => ['mahasiswa'],
            'status_aktif' => true,
            'tanggal_mulai' => now(),
            'tanggal_selesai' => now()->addMonth(),
            'dibuat_oleh' => 1,
        ]);

        $pertanyaanit = [
            ['text' => 'Sistem akademik online mudah digunakan', 'category' => 'Aksesibilitas'],
            ['text' => 'Jaringan internet kampus stabil dan cepat', 'category' => 'Infrastruktur'],
            ['text' => 'Layanan helpdesk IT responsif terhadap masalah pengguna', 'category' => 'Layanan Pengguna'],
            ['text' => 'Data pribadi mahasiswa dijaga dengan baik', 'category' => 'Keamanan Data'],
        ];

        foreach ($pertanyaanit as $index => $pertanyaan) {
            Pertanyaan::create([
                'kuesioner_id' => $kuesioner6->id,
                'teks_pertanyaan' => $pertanyaan['text'],
                'jenis_pertanyaan' => 'likert',
                'kategori' => $pertanyaan['category'],
                'urutan' => $index + 1,
                'wajib_diisi' => true,
            ]);
        }

        $kuesioner7 = Kuesioner::create([
            'judul' => 'Survei Kepuasan Mahasiswa Baru',
            'deskripsi' => 'Evaluasi pengalaman mahasiswa baru selama masa orientasi dan awal perkuliahan.',
            'icon' => 'fas fa-user-graduate',
            'target_responden' => ['mahasiswa'],
            'status_aktif' => true,
            'tanggal_mulai' => now(),
            'tanggal_selesai' => now()->addMonth(),
            'dibuat_oleh' => 1,
        ]);

        $pertanyaanmaba = [
            ['text' => 'Kegiatan orientasi memberikan informasi yang bermanfaat', 'category' => 'Orientasi'],
            ['text' => 'Dosen dan senior bersikap ramah terhadap mahasiswa baru', 'category' => 'Sosialisasi'],
            ['text' => 'Fasilitas kampus mudah diakses oleh mahasiswa baru', 'category' => 'Aksesibilitas'],
            ['text' => 'Informasi akademik mudah dipahami sejak awal perkuliahan', 'category' => 'Informasi'],
        ];

        foreach ($pertanyaanmaba as $index => $pertanyaan) {
            Pertanyaan::create([
                'kuesioner_id' => $kuesioner7->id,
                'teks_pertanyaan' => $pertanyaan['text'],
                'jenis_pertanyaan' => 'likert',
                'kategori' => $pertanyaan['category'],
                'urutan' => $index + 1,
                'wajib_diisi' => true,
            ]);
        }

        $kuesioner8 = Kuesioner::create([
            'judul' => 'Survei Kepuasan Alumni',
            'deskripsi' => 'Evaluasi pengalaman alumni terkait pembelajaran dan kesiapan kerja.',
            'icon' => 'fas fa-user-tie',
            'target_responden' => ['alumni'],
            'status_aktif' => true,
            'tanggal_mulai' => now(),
            'tanggal_selesai' => now()->addMonth(),
            'dibuat_oleh' => 1,
        ]);

        $pertanyaanalumni = [
            ['text' => 'Kurikulum perkuliahan relevan dengan kebutuhan dunia kerja', 'category' => 'Relevansi'],
            ['text' => 'Keterampilan yang diajarkan berguna di tempat kerja', 'category' => 'Kompetensi'],
            ['text' => 'Hubungan dengan fakultas tetap terjaga setelah lulus', 'category' => 'Relasi Alumni'],
            ['text' => 'Fakultas memfasilitasi kegiatan alumni dengan baik', 'category' => 'Kegiatan Alumni'],
        ];

        foreach ($pertanyaanalumni as $index => $pertanyaan) {
            Pertanyaan::create([
                'kuesioner_id' => $kuesioner8->id,
                'teks_pertanyaan' => $pertanyaan['text'],
                'jenis_pertanyaan' => 'likert',
                'kategori' => $pertanyaan['category'],
                'urutan' => $index + 1,
                'wajib_diisi' => true,
            ]);
        }

        $kuesioner9 = Kuesioner::create([
            'judul' => 'Survei Kepuasan Tenaga Kependidikan',
            'deskripsi' => 'Penilaian terhadap fasilitas dan dukungan yang diterima tenaga kependidikan.',
            'icon' => 'fas fa-users-cog',
            'target_responden' => ['mahasiswa', 'dosen'],
            'status_aktif' => true,
            'tanggal_mulai' => now(),
            'tanggal_selesai' => now()->addMonth(),
            'dibuat_oleh' => 1,
        ]);

        $pertanyaantendik = [
            ['text' => 'Fakultas menyediakan pelatihan untuk meningkatkan kompetensi staf', 'category' => 'Pengembangan'],
            ['text' => 'Lingkungan kerja kondusif dan mendukung kinerja', 'category' => 'Lingkungan Kerja'],
            ['text' => 'Fasilitas kerja mencukupi untuk menjalankan tugas', 'category' => 'Fasilitas'],
            ['text' => 'Komunikasi antar staf dan pimpinan berjalan baik', 'category' => 'Komunikasi Internal'],
        ];

        $kuesioner10 = Kuesioner::create([
            'judul' => 'Evaluasi Pembelajaran Hybrid',
            'deskripsi' => 'Survei untuk mengevaluasi efektivitas pembelajaran hybrid (online dan offline).',
            'icon' => 'fas fa-laptop-house',
            'target_responden' => ['mahasiswa', 'dosen'],
            'status_aktif' => true,
            'tanggal_mulai' => now(),
            'tanggal_selesai' => now()->addMonth(),
            'dibuat_oleh' => 1,
        ]);

        // Likert scale questions
        $pertanyaanHybrid1 = [
            [
                'teks_pertanyaan' => 'Pembelajaran hybrid membantu pemahaman materi kuliah',
                'kategori' => 'Efektivitas Pembelajaran',
                'jenis_pertanyaan' => 'likert',
                'urutan' => 1,
            ],
            [
                'teks_pertanyaan' => 'Platform e-learning mudah digunakan',
                'kategori' => 'Teknologi',
                'jenis_pertanyaan' => 'likert',
                'urutan' => 2,
            ],
        ];

        // Multiple choice questions
        $pertanyaanHybrid2 = [
            [
                'teks_pertanyaan' => 'Platform e-learning yang paling sering Anda gunakan?',
                'kategori' => 'Teknologi',
                'jenis_pertanyaan' => 'pilihan_ganda',
                'opsi_jawaban' => json_encode(['Moodle', 'Google Classroom', 'Microsoft Teams', 'Zoom']),
                'urutan' => 3,
            ],
            [
                'teks_pertanyaan' => 'Berapa jam rata-rata yang Anda habiskan untuk belajar online per hari?',
                'kategori' => 'Waktu Belajar',
                'jenis_pertanyaan' => 'pilihan_ganda',
                'opsi_jawaban' => json_encode(['< 1 jam', '1-2 jam', '2-4 jam', '> 4 jam']),
                'urutan' => 4,
            ],
        ];

        // Text input questions
        $pertanyaanHybrid3 = [
            [
                'teks_pertanyaan' => 'Apa saran Anda untuk meningkatkan kualitas pembelajaran hybrid?',
                'kategori' => 'Saran',
                'jenis_pertanyaan' => 'isian',
                'urutan' => 5,
            ],
            [
                'teks_pertanyaan' => 'Sebutkan kendala utama yang Anda hadapi selama pembelajaran hybrid',
                'kategori' => 'Kendala',
                'jenis_pertanyaan' => 'isian',
                'urutan' => 6,
            ],
        ];

        // Combine all questions
        $semuaPertanyaan = array_merge($pertanyaanHybrid1, $pertanyaanHybrid2, $pertanyaanHybrid3);

        // Create questions
        foreach ($semuaPertanyaan as $pertanyaan) {
            Pertanyaan::create(array_merge(
                $pertanyaan,
                ['kuesioner_id' => $kuesioner10->id, 'wajib_diisi' => true]
            ));
        }

        foreach ($pertanyaantendik as $index => $pertanyaan) {
            Pertanyaan::create([
                'kuesioner_id' => $kuesioner9->id,
                'teks_pertanyaan' => $pertanyaan['text'],
                'jenis_pertanyaan' => 'likert',
                'kategori' => $pertanyaan['category'],
                'urutan' => $index + 1,
                'wajib_diisi' => true,
            ]);
        }
    }
}
