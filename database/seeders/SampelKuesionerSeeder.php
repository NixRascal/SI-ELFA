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
        // Kuesioner 1: Kepuasan Layanan Akademik (Mahasiswa) - 25 pertanyaan
        $kuesioner1 = Kuesioner::create([
            'judul' => 'Survei Kepuasan Layanan Akademik',
            'deskripsi' => 'Evaluasi komprehensif terhadap seluruh aspek layanan akademik yang diterima mahasiswa di fakultas.',
            'icon' => 'fa-graduation-cap',
            'target_responden' => ['mahasiswa'],
            'status_aktif' => true,
            'tanggal_mulai' => now(),
            'tanggal_selesai' => now()->addMonth(),
            'dibuat_oleh' => 1,
        ]);

        $pertanyaanAkademik = [
            // Bimbingan Akademik (5)
            ['text' => 'Dosen pembimbing akademik mudah dihubungi', 'category' => 'Bimbingan Akademik', 'type' => 'likert'],
            ['text' => 'Bimbingan akademik membantu perencanaan studi saya', 'category' => 'Bimbingan Akademik', 'type' => 'likert'],
            ['text' => 'Dosen PA memberikan arahan yang jelas', 'category' => 'Bimbingan Akademik', 'type' => 'likert'],
            ['text' => 'Jadwal konsultasi PA sesuai kebutuhan', 'category' => 'Bimbingan Akademik', 'type' => 'likert'],
            ['text' => 'Dosen PA memahami kebutuhan akademik mahasiswa', 'category' => 'Bimbingan Akademik', 'type' => 'likert'],
            
            // Administrasi Akademik (5)
            ['text' => 'Proses registrasi mata kuliah mudah dan cepat', 'category' => 'Administrasi Akademik', 'type' => 'likert'],
            ['text' => 'Informasi akademik disampaikan tepat waktu', 'category' => 'Administrasi Akademik', 'type' => 'likert'],
            ['text' => 'Sistem informasi akademik mudah digunakan', 'category' => 'Administrasi Akademik', 'type' => 'likert'],
            ['text' => 'Staf akademik responsif terhadap pertanyaan', 'category' => 'Administrasi Akademik', 'type' => 'likert'],
            ['text' => 'Prosedur administrasi jelas dan transparan', 'category' => 'Administrasi Akademik', 'type' => 'likert'],
            
            // Fasilitas (5)
            ['text' => 'Ruang kuliah nyaman dan kondusif', 'category' => 'Fasilitas', 'type' => 'likert'],
            ['text' => 'Perpustakaan memiliki koleksi buku yang memadai', 'category' => 'Fasilitas', 'type' => 'likert'],
            ['text' => 'Fasilitas laboratorium lengkap dan berfungsi baik', 'category' => 'Fasilitas', 'type' => 'likert'],
            ['text' => 'Akses internet kampus stabil dan cepat', 'category' => 'Fasilitas', 'type' => 'likert'],
            ['text' => 'Toilet dan area umum bersih dan terawat', 'category' => 'Fasilitas', 'type' => 'likert'],
            
            // Kualitas Pembelajaran (7)
            ['text' => 'Materi perkuliahan sesuai dengan RPS', 'category' => 'Kualitas Pembelajaran', 'type' => 'likert'],
            ['text' => 'Metode pengajaran dosen efektif', 'category' => 'Kualitas Pembelajaran', 'type' => 'likert'],
            ['text' => 'Tugas dan ujian relevan dengan materi', 'category' => 'Kualitas Pembelajaran', 'type' => 'likert'],
            ['text' => 'Penilaian dilakukan secara objektif', 'category' => 'Kualitas Pembelajaran', 'type' => 'likert'],
            ['text' => 'Feedback dari dosen membantu pembelajaran', 'category' => 'Kualitas Pembelajaran', 'type' => 'likert'],
            ['text' => 'Pembelajaran mengembangkan critical thinking', 'category' => 'Kualitas Pembelajaran', 'type' => 'likert'],
            ['text' => 'Waktu kuliah dimanfaatkan dengan efektif', 'category' => 'Kualitas Pembelajaran', 'type' => 'likert'],
            
            // Pilihan Ganda (2)
            ['text' => 'Berapa tingkat kepuasan Anda secara keseluruhan?', 'category' => 'Evaluasi Umum', 'type' => 'pilihan_ganda', 'options' => ['Sangat Puas', 'Puas', 'Cukup Puas', 'Kurang Puas', 'Tidak Puas']],
            ['text' => 'Layanan akademik mana yang paling perlu ditingkatkan?', 'category' => 'Evaluasi Umum', 'type' => 'pilihan_ganda', 'options' => ['Bimbingan Akademik', 'Administrasi', 'Fasilitas', 'Kualitas Dosen', 'Sistem Informasi']],
            
            // Isian (1)
            ['text' => 'Saran Anda untuk meningkatkan layanan akademik', 'category' => 'Saran', 'type' => 'isian'],
        ];

        $this->createQuestions($kuesioner1->id, $pertanyaanAkademik);

        // Kuesioner 2: Evaluasi Kinerja Dosen (Mahasiswa) - 22 pertanyaan
        $kuesioner2 = Kuesioner::create([
            'judul' => 'Evaluasi Kinerja Dosen Semester Ini',
            'deskripsi' => 'Penilaian komprehensif terhadap kinerja dosen dalam proses belajar mengajar.',
            'icon' => 'fas fa-chalkboard-teacher',
            'target_responden' => ['mahasiswa'],
            'status_aktif' => true,
            'tanggal_mulai' => now(),
            'tanggal_selesai' => now()->addMonth(2),
            'dibuat_oleh' => 1,
        ]);

        $pertanyaanDosen = [
            // Kompetensi (6)
            ['text' => 'Dosen menguasai materi dengan sangat baik', 'category' => 'Kompetensi Akademik', 'type' => 'likert'],
            ['text' => 'Penjelasan dosen mudah dipahami', 'category' => 'Kompetensi Akademik', 'type' => 'likert'],
            ['text' => 'Dosen memberikan contoh yang relevan', 'category' => 'Kompetensi Akademik', 'type' => 'likert'],
            ['text' => 'Dosen menjawab pertanyaan dengan jelas', 'category' => 'Kompetensi Akademik', 'type' => 'likert'],
            ['text' => 'Materi yang diajarkan up to date', 'category' => 'Kompetensi Akademik', 'type' => 'likert'],
            ['text' => 'Dosen menghubungkan teori dengan praktik', 'category' => 'Kompetensi Akademik', 'type' => 'likert'],
            
            // Metode Pengajaran (5)
            ['text' => 'Metode pengajaran variatif dan menarik', 'category' => 'Metode Pengajaran', 'type' => 'likert'],
            ['text' => 'Dosen menggunakan media pembelajaran yang efektif', 'category' => 'Metode Pengajaran', 'type' => 'likert'],
            ['text' => 'Diskusi kelas berjalan produktif', 'category' => 'Metode Pengajaran', 'type' => 'likert'],
            ['text' => 'Dosen mendorong partisipasi mahasiswa', 'category' => 'Metode Pengajaran', 'type' => 'likert'],
            ['text' => 'Pembelajaran student-centered', 'category' => 'Metode Pengajaran', 'type' => 'likert'],
            
            // Kedisiplinan (4)
            ['text' => 'Dosen hadir tepat waktu', 'category' => 'Kedisiplinan', 'type' => 'likert'],
            ['text' => 'Perkuliahan dimulai dan selesai sesuai jadwal', 'category' => 'Kedisiplinan', 'type' => 'likert'],
            ['text' => 'Dosen menginformsikan jika berhalangan hadir', 'category' => 'Kedisiplinan', 'type' => 'likert'],
            ['text' => 'Tugas dikembalikan sesuai waktu yang dijanjikan', 'category' => 'Kedisiplinan', 'type' => 'likert'],
            
            // Komunikasi (4)
            ['text' => 'Dosen mudah dihubungi di luar jam kuliah', 'category' => 'Komunikasi', 'type' => 'likert'],
            ['text' => 'Dosen responsif terhadap email/pesan', 'category' => 'Komunikasi', 'type' => 'likert'],
            ['text' => 'Feedback yang diberikan konstruktif', 'category' => 'Komunikasi', 'type' => 'likert'],
            ['text' => 'Dosen bersikap ramah dan menghargai mahasiswa', 'category' => 'Komunikasi', 'type' => 'likert'],
            
            // Pilihan Ganda (2)
            ['text' => 'Aspek mana yang paling baik dari dosen ini?', 'category' => 'Evaluasi', 'type' => 'pilihan_ganda', 'options' => ['Penguasaan Materi', 'Metode Mengajar', 'Kedisiplinan', 'Komunikasi', 'Penilaian yang Adil']],
            ['text' => 'Apakah Anda merekomendasikan dosen ini?', 'category' => 'Evaluasi', 'type' => 'pilihan_ganda', 'options' => ['Sangat Merekomendasikan', 'Merekomendasikan', 'Netral', 'Tidak Merekomendasikan']],
            
            // Isian (1)
            ['text' => 'Masukan untuk perbaikan kinerja dosen', 'category' => 'Saran', 'type' => 'isian'],
        ];

        $this->createQuestions($kuesioner2->id, $pertanyaanDosen);

        // Kuesioner 3: Kepuasan Layanan Perpustakaan (Mahasiswa, Dosen) - 20 pertanyaan
        $kuesioner3 = Kuesioner::create([
            'judul' => 'Survei Kepuasan Layanan Perpustakaan',
            'deskripsi' => 'Evaluasi terhadap fasilitas, koleksi, dan layanan perpustakaan fakultas.',
            'icon' => 'fas fa-book',
            'target_responden' => ['mahasiswa', 'dosen'],
            'status_aktif' => true,
            'tanggal_mulai' => now(),
            'tanggal_selesai' => now()->addMonths(2),
            'dibuat_oleh' => 1,
        ]);

        $pertanyaanPerpus = [
            // Koleksi (6)
            ['text' => 'Koleksi buku perpustakaan lengkap dan up to date', 'category' => 'Koleksi', 'type' => 'likert'],
            ['text' => 'Jurnal ilmiah yang tersedia relevan dengan kebutuhan', 'category' => 'Koleksi', 'type' => 'likert'],
            ['text' => 'E-book dan sumber digital mudah diakses', 'category' => 'Koleksi', 'type' => 'likert'],
            ['text' => 'Buku referensi wajib selalu tersedia', 'category' => 'Koleksi', 'type' => 'likert'],
            ['text' => 'Perpustakaan menyediakan literature terbaru', 'category' => 'Koleksi', 'type' => 'likert'],
            ['text' => 'Database online yang berlangganan memadai', 'category' => 'Koleksi', 'type' => 'likert'],
            
            // Fasilitas (5)
            ['text' => 'Ruang baca nyaman dan tenang', 'category' => 'Fasilitas', 'type' => 'likert'],
            ['text' => 'Area diskusi terpisah dari ruang baca', 'category' => 'Fasilitas', 'type' => 'likert'],
            ['text' => 'Komputer dan printer berfungsi dengan baik', 'category' => 'Fasilitas', 'type' => 'likert'],
            ['text' => 'Pencahayaan dan AC nyaman', 'category' => 'Fasilitas', 'type' => 'likert'],
            ['text' => 'Loker penitipan barang aman', 'category' => 'Fasilitas', 'type' => 'likert'],
            
            // Layanan (5)
            ['text' => 'Petugas perpustakaan ramah dan membantu', 'category' => 'Layanan', 'type' => 'likert'],
            ['text' => 'Sistem peminjaman mudah dan cepat', 'category' => 'Layanan', 'type' => 'likert'],
            ['text' => 'Katalog online mudah digunakan', 'category' => 'Layanan', 'type' => 'likert'],
            ['text' => 'Jam buka perpustakaan sesuai kebutuhan', 'category' => 'Layanan', 'type' => 'likert'],
            ['text' => 'Literasi informasi yang diberikan bermanfaat', 'category' => 'Layanan', 'type' => 'likert'],
            
            // Pilihan Ganda (3)
            ['text' => 'Seberapa sering Anda menggunakan perpustakaan?', 'category' => 'Penggunaan', 'type' => 'pilihan_ganda', 'options' => ['Setiap hari', '2-3 kali seminggu', 'Seminggu sekali', 'Sebulan sekali', 'Jarang']],
            ['text' => 'Fasilitas perpustakaan yang paling sering Anda gunakan?', 'category' => 'Penggunaan', 'type' => 'pilihan_ganda', 'options' => ['Pinjam Buku', 'Ruang Baca', 'Komputer/Internet', 'Database Online', 'Area Diskusi']],
            ['text' => 'Aspek mana yang perlu ditingkatkan?', 'category' => 'Evaluasi', 'type' => 'pilihan_ganda', 'options' => ['Koleksi Buku', 'Fasilitas', 'Layanan Petugas', 'Jam Operasional', 'Sistem Digital']],
            
            // Isian (1)
            ['text' => 'Saran untuk peningkatan layanan perpustakaan', 'category' => 'Saran', 'type' => 'isian'],
        ];

        $this->createQuestions($kuesioner3->id, $pertanyaanPerpus);

        // Kuesioner 4: Evaluasi Pembelajaran Hybrid (Mahasiswa, Dosen) - 28 pertanyaan
        $kuesioner4 = Kuesioner::create([
            'judul' => 'Evaluasi Sistem Pembelajaran Hybrid',
            'deskripsi' => 'Penilaian efektivitas pembelajaran kombinasi online dan offline dalam perkuliahan.',
            'icon' => 'fas fa-laptop-house',
            'target_responden' => ['mahasiswa', 'dosen'],
            'status_aktif' => true,
            'tanggal_mulai' => now(),
            'tanggal_selesai' => now()->addMonth(3),
            'dibuat_oleh' => 1,
        ]);

        $pertanyaanHybrid = [
            // Efektivitas (7)
            ['text' => 'Pembelajaran hybrid memudahkan pemahaman materi', 'category' => 'Efektivitas', 'type' => 'likert'],
            ['text' => 'Kombinasi online-offline efektif untuk belajar', 'category' => 'Efektivitas', 'type' => 'likert'],
            ['text' => 'Materi online sama berkualitasnya dengan offline', 'category' => 'Efektivitas', 'type' => 'likert'],
            ['text' => 'Diskusi online sama produktifnya dengan offline', 'category' => 'Efektivitas', 'type' => 'likert'],
            ['text' => 'Saya dapat mengikuti kuliah dengan baik', 'category' => 'Efektivitas', 'type' => 'likert'],
            ['text' => 'Interaksi dengan dosen tetap terjaga', 'category' => 'Efektivitas', 'type' => 'likert'],
            ['text' => 'Pembelajaran hybrid meningkatkan kemandirian belajar', 'category' => 'Efektivitas', 'type' => 'likert'],
            
            // Teknologi (6)
            ['text' => 'Platform e-learning mudah digunakan', 'category' => 'Teknologi', 'type' => 'likert'],
            ['text' => 'Aplikasi video conference berfungsi dengan baik', 'category' => 'Teknologi', 'type' => 'likert'],
            ['text' => 'Materi digital mudah diakses', 'category' => 'Teknologi', 'type' => 'likert'],
            ['text' => 'Sistem ujian online berjalan lancar', 'category' => 'Teknologi', 'type' => 'likert'],
            ['text' => 'Internet saya mendukung pembelajaran online', 'category' => 'Teknologi', 'type' => 'likert'],
            ['text' => 'Perangkat saya memadai untuk kuliah online', 'category' => 'Teknologi', 'type' => 'likert'],
            
            // Fleksibilitas (5)
            ['text' => 'Jadwal hybrid memberikan fleksibilitas', 'category' => 'Fleksibilitas', 'type' => 'likert'],
            ['text' => 'Waktu belajar lebih efisien', 'category' => 'Fleksibilitas', 'type' => 'likert'],
            ['text' => 'Menghemat waktu dan biaya transportasi', 'category' => 'Fleksibilitas', 'type' => 'likert'],
            ['text' => 'Materi dapat diulang sesuai kebutuhan', 'category' => 'Fleksibilitas', 'type' => 'likert'],
            ['text' => 'Balance antara online dan offline sudah ideal', 'category' => 'Fleksibilitas', 'type' => 'likert'],
            
            // Dukungan (4)
            ['text' => 'Dosen memberikan support yang memadai', 'category' => 'Dukungan', 'type' => 'likert'],
            ['text' => 'Panduan pembelajaran hybrid jelas', 'category' => 'Dukungan', 'type' => 'likert'],
            ['text' => 'Helpdesk IT responsif terhadap masalah', 'category' => 'Dukungan', 'type' => 'likert'],
            ['text' => 'Pelatihan penggunaan platform memadai', 'category' => 'Dukungan', 'type' => 'likert'],
            
            // Pilihan Ganda (5)
            ['text' => 'Mana yang Anda preferensikan?', 'category' => 'Preferensi', 'type' => 'pilihan_ganda', 'options' => ['100% Online', '75% Online 25% Offline', '50-50', '25% Online 75% Offline', '100% Offline']],
            ['text' => 'Platform yang paling sering digunakan?', 'category' => 'Platform', 'type' => 'pilihan_ganda', 'options' => ['Moodle', 'Google Classroom', 'Microsoft Teams', 'Zoom', 'Lainnya']],
            ['text' => 'Durasi belajar online per hari?', 'category' => 'Waktu', 'type' => 'pilihan_ganda', 'options' => ['< 1 jam', '1-2 jam', '2-4 jam', '4-6 jam', '> 6 jam']],
            ['text' => 'Kendala utama pembelajaran online?', 'category' => 'Kendala', 'type' => 'pilihan_ganda', 'options' => ['Koneksi Internet', 'Perangkat', 'Fokus Belajar', 'Interaksi Terbatas', 'Lainnya']],
            ['text' => 'Tingkat kepuasan pembelajaran hybrid?', 'category' => 'Evaluasi', 'type' => 'pilihan_ganda', 'options' => ['Sangat Puas', 'Puas', 'Cukup', 'Kurang Puas', 'Tidak Puas']],
            
            // Isian (1)
            ['text' => 'Saran perbaikan sistem pembelajaran hybrid', 'category' => 'Saran', 'type' => 'isian'],
        ];

        $this->createQuestions($kuesioner4->id, $pertanyaanHybrid);

        // Kuesioner 5: Kepuasan Layanan IT (Mahasiswa, Dosen, Alumni) - 24 pertanyaan
        $kuesioner5 = Kuesioner::create([
            'judul' => 'Survei Kepuasan Layanan Teknologi Informasi',
            'deskripsi' => 'Evaluasi terhadap infrastruktur IT, sistem akademik, dan layanan helpdesk teknologi.',
            'icon' => 'fas fa-server',
            'target_responden' => ['mahasiswa', 'dosen', 'alumni'],
            'status_aktif' => true,
            'tanggal_mulai' => now()->subDays(5),
            'tanggal_selesai' => now()->addMonth(2),
            'dibuat_oleh' => 1,
        ]);

        $pertanyaanIT = [
            // Sistem Akademik (6)
            ['text' => 'SIAKAD mudah diakses dan digunakan', 'category' => 'Sistem Akademik', 'type' => 'likert'],
            ['text' => 'Informasi akademik akurat dan real-time', 'category' => 'Sistem Akademik', 'type' => 'likert'],
            ['text' => 'Proses registrasi online lancar', 'category' => 'Sistem Akademik', 'type' => 'likert'],
            ['text' => 'Portal mahasiswa user-friendly', 'category' => 'Sistem Akademik', 'type' => 'likert'],
            ['text' => 'Mobile app SIAKAD berfungsi baik', 'category' => 'Sistem Akademik', 'type' => 'likert'],
            ['text' => 'Sistem pembayaran online aman dan mudah', 'category' => 'Sistem Akademik', 'type' => 'likert'],
            
            // Infrastruktur (5)
            ['text' => 'WiFi kampus stabil di seluruh area', 'category' => 'Infrastruktur', 'type' => 'likert'],
            ['text' => 'Kecepatan internet memadai', 'category' => 'Infrastruktur', 'type' => 'likert'],
            ['text' => 'Komputer lab terawat dan berfungsi baik', 'category' => 'Infrastruktur', 'type' => 'likert'],
            ['text' => 'Proyektor dan AV equipment berfungsi', 'category' => 'Infrastruktur', 'type' => 'likert'],
            ['text' => 'Fasilitas charging dan colokan memadai', 'category' => 'Infrastruktur', 'type' => 'likert'],
            
            // Keamanan (4)
            ['text' => 'Data pribadi dijaga dengan baik', 'category' => 'Keamanan', 'type' => 'likert'],
            ['text' => 'Sistem autentikasi aman', 'category' => 'Keamanan', 'type' => 'likert'],
            ['text' => 'Privasi informasi terjaga', 'category' => 'Keamanan', 'type' => 'likert'],
            ['text' => 'Backup data dilakukan secara berkala', 'category' => 'Keamanan', 'type' => 'likert'],
            
            // Layanan IT Support (5)
            ['text' => 'Helpdesk IT responsif dan membantu', 'category' => 'IT Support', 'type' => 'likert'],
            ['text' => 'Masalah teknis diselesaikan dengan cepat', 'category' => 'IT Support', 'type' => 'likert'],
            ['text' => 'Petugas IT kompeten dan ramah', 'category' => 'IT Support', 'type' => 'likert'],
            ['text' => 'Panduan penggunaan sistem jelas', 'category' => 'IT Support', 'type' => 'likert'],
            ['text' => 'Kanal komunikasi helpdesk mudah diakses', 'category' => 'IT Support', 'type' => 'likert'],
            
            // Pilihan Ganda (3)
            ['text' => 'Seberapa sering Anda mengalami masalah IT?', 'category' => 'Frekuensi Masalah', 'type' => 'pilihan_ganda', 'options' => ['Tidak pernah', 'Jarang', 'Kadang-kadang', 'Sering', 'Sangat Sering']],
            ['text' => 'Layanan IT mana yang paling sering Anda gunakan?', 'category' => 'Penggunaan', 'type' => 'pilihan_ganda', 'options' => ['SIAKAD', 'Email Kampus', 'E-Learning', 'WiFi', 'Helpdesk']],
            ['text' => 'Aspek IT yang perlu prioritas ditingkatkan?', 'category' => 'Prioritas', 'type' => 'pilihan_ganda', 'options' => ['Kecepatan Internet', 'Stabilitas Sistem', 'User Interface', 'IT Support', 'Keamanan']],
            
            // Isian (1)
            ['text' => 'Saran perbaikan layanan IT kampus', 'category' => 'Saran', 'type' => 'isian'],
        ];

        $this->createQuestions($kuesioner5->id, $pertanyaanIT);

        // Kuesioner 6: Tracer Study Alumni - 30 pertanyaan
        $kuesioner6 = Kuesioner::create([
            'judul' => 'Tracer Study Alumni - Kesiapan Kerja',
            'deskripsi' => 'Survei pelacakan alumni untuk evaluasi kesesuaian kurikulum dengan kebutuhan dunia kerja.',
            'icon' => 'fas fa-user-tie',
            'target_responden' => ['alumni'],
            'status_aktif' => true,
            'tanggal_mulai' => now()->subWeek(),
            'tanggal_selesai' => now()->addMonths(3),
            'dibuat_oleh' => 1,
        ]);

        $pertanyaanAlumni = [
            // Relevansi Kurikulum (7)
            ['text' => 'Kurikulum relevan dengan pekerjaan saya', 'category' => 'Relevansi Kurikulum', 'type' => 'likert'],
            ['text' => 'Keterampilan teknis yang dipelajari berguna', 'category' => 'Relevansi Kurikulum', 'type' => 'likert'],
            ['text' => 'Soft skills yang diajarkan membantu karir', 'category' => 'Relevansi Kurikulum', 'type' => 'likert'],
            ['text' => 'Praktikum/magang mempersiapkan dunia kerja', 'category' => 'Relevansi Kurikulum', 'type' => 'likert'],
            ['text' => 'Proyek akhir/skripsi relevan dengan pekerjaan', 'category' => 'Relevansi Kurikulum', 'type' => 'likert'],
            ['text' => 'Teori mendukung praktik di lapangan', 'category' => 'Relevansi Kurikulum', 'type' => 'likert'],
            ['text' => 'Mata kuliah pilihan sesuai minat karir', 'category' => 'Relevansi Kurikulum', 'type' => 'likert'],
            
            // Kompetensi (6)
            ['text' => 'Saya siap bekerja setelah lulus', 'category' => 'Kompetensi', 'type' => 'likert'],
            ['text' => 'Kemampuan problem solving saya baik', 'category' => 'Kompetensi', 'type' => 'likert'],
            ['text' => 'Saya dapat berkomunikasi efektif', 'category' => 'Kompetensi', 'type' => 'likert'],
            ['text' => 'Kemampuan teamwork saya kuat', 'category' => 'Kompetensi', 'type' => 'likert'],
            ['text' => 'Saya adaptif terhadap perubahan', 'category' => 'Kompetensi', 'type' => 'likert'],
            ['text' => 'Leadership skills saya berkembang', 'category' => 'Kompetensi', 'type' => 'likert'],
            
            // Karir (4)
            ['text' => 'Pekerjaan sesuai dengan jurusan', 'category' => 'Status Karir', 'type' => 'likert'],
            ['text' => 'Gaji sesuai dengan ekspektasi', 'category' => 'Status Karir', 'type' => 'likert'],
            ['text' => 'Fakultas membantu proses mencari kerja', 'category' => 'Status Karir', 'type' => 'likert'],
            ['text' => 'Alumni network bermanfaat untuk karir', 'category' => 'Status Karir', 'type' => 'likert'],
            
            // Hubungan Alumni (3)
            ['text' => 'Saya tetap terhubung dengan fakultas', 'category' => 'Relasi Alumni', 'type' => 'likert'],
            ['text' => 'Kegiatan alumni terorganisir dengan baik', 'category' => 'Relasi Alumni', 'type' => 'likert'],
            ['text' => 'Fakultas memfasilitasi networking alumni', 'category' => 'Relasi Alumni', 'type' => 'likert'],
            
            // Pilihan Ganda (9)
            ['text' => 'Status pekerjaan Anda saat ini?', 'category' => 'Status', 'type' => 'pilihan_ganda', 'options' => ['Bekerja Full-time', 'Bekerja Part-time', 'Wirausaha', 'Lanjut Studi', 'Mencari Kerja', 'Lainnya']],
            ['text' => 'Berapa lama Anda mendapat pekerjaan pertama?', 'category' => 'Waiting Period', 'type' => 'pilihan_ganda', 'options' => ['< 3 bulan', '3-6 bulan', '6-12 bulan', '> 1 tahun', 'Belum bekerja']],
            ['text' => 'Jenis perusahaan tempat bekerja?', 'category' => 'Jenis Pekerjaan', 'type' => 'pilihan_ganda', 'options' => ['BUMN', 'Swasta Nasional', 'Multinasional', 'Startup', 'Pemerintah', 'Lainnya']],
            ['text' => 'Posisi Anda saat ini?', 'category' => 'Level', 'type' => 'pilihan_ganda', 'options' => ['Staff', 'Supervisor', 'Manager', 'Senior Manager', 'Director']],
            ['text' => 'Rentang gaji per bulan?', 'category' => 'Salary', 'type' => 'pilihan_ganda', 'options' => ['< 5 juta', '5-10 juta', '10-15 juta', '15-20 juta', '> 20 juta']],
            ['text' => 'Kesesuaian pekerjaan dengan jurusan?', 'category' => 'Alignment', 'type' => 'pilihan_ganda', 'options' => ['Sangat Sesuai', 'Sesuai', 'Cukup Sesuai', 'Kurang Sesuai', 'Tidak Sesuai']],
            ['text' => 'Kompetensi yang paling dibutuhkan di pekerjaan?', 'category' => 'Kompetensi Kunci', 'type' => 'pilihan_ganda', 'options' => ['Technical Skills', 'Communication', 'Leadership', 'Problem Solving', 'Teamwork']],
            ['text' => 'Apakah Anda merekomendasikan jurusan ini?', 'category' => 'Rekomendasi', 'type' => 'pilihan_ganda', 'options' => ['Sangat Merekomendasikan', 'Merekomendasikan', 'Netral', 'Tidak Merekomendasikan']],
            ['text' => 'Aspek pendidikan yang perlu ditingkatkan?', 'category' => 'Improvement', 'type' => 'pilihan_ganda', 'options' => ['Kurikulum', 'Praktikum', 'Soft Skills', 'Career Center', 'Industry Connection']],
            
            // Isian (1)
            ['text' => 'Saran untuk meningkatkan kualitas lulusan', 'category' => 'Saran', 'type' => 'isian'],
        ];

        $this->createQuestions($kuesioner6->id, $pertanyaanAlumni);

        // Kuesioner 7: Evaluasi Fasilitas Kampus - 26 pertanyaan
        $kuesioner7 = Kuesioner::create([
            'judul' => 'Evaluasi Komprehensif Fasilitas Kampus',
            'deskripsi' => 'Survey menyeluruh tentang kualitas dan kecukupan fasilitas fisik di lingkungan kampus.',
            'icon' => 'fas fa-building',
            'target_responden' => ['mahasiswa', 'dosen'],
            'status_aktif' => true,
            'tanggal_mulai' => now(),
            'tanggal_selesai' => now()->addMonth(2),
            'dibuat_oleh' => 1,
        ]);

        $pertanyaanFasilitas = [
            // Ruang Kuliah (5)
            ['text' => 'Ruang kuliah bersih dan terawat', 'category' => 'Ruang Kuliah', 'type' => 'likert'],
            ['text' => 'AC dan ventilasi berfungsi baik', 'category' => 'Ruang Kuliah', 'type' => 'likert'],
            ['text' => 'Kursi dan meja dalam kondisi baik', 'category' => 'Ruang Kuliah', 'type' => 'likert'],
            ['text' => 'Pencahayaan memadai', 'category' => 'Ruang Kuliah', 'type' => 'likert'],
            ['text' => 'Sound system jelas', 'category' => 'Ruang Kuliah', 'type' => 'likert'],
            
            // Laboratorium (4)
            ['text' => 'Peralatan lab lengkap dan modern', 'category' => 'Laboratorium', 'type' => 'likert'],
            ['text' => 'Lab bersih dan aman', 'category' => 'Laboratorium', 'type' => 'likert'],
            ['text' => 'Jumlah lab memadai', 'category' => 'Laboratorium', 'type' => 'likert'],
            ['text' => 'Akses lab mudah dan fleksibel', 'category' => 'Laboratorium', 'type' => 'likert'],
            
            // Fasilitas Umum (6)
            ['text' => 'Toilet bersih dan terawat', 'category' => 'Fasilitas Umum', 'type' => 'likert'],
            ['text' => 'Mushola nyaman dan bersih', 'category' => 'Fasilitas Umum', 'type' => 'likert'],
            ['text' => 'Area parkir luas dan aman', 'category' => 'Fasilitas Umum', 'type' => 'likert'],
            ['text' => 'Kantin menyediakan makanan berkualitas', 'category' => 'Fasilitas Umum', 'type' => 'likert'],
            ['text' => 'Area hijau dan ruang terbuka memadai', 'category' => 'Fasilitas Umum', 'type' => 'likert'],
            ['text' => 'Tempat sampah tersedia di berbagai lokasi', 'category' => 'Fasilitas Umum', 'type' => 'likert'],
            
            // Aksesibilitas (3)
            ['text' => 'Fasilitas ramah difabel', 'category' => 'Aksesibilitas', 'type' => 'likert'],
            ['text' => 'Lift dan tangga dalam kondisi baik', 'category' => 'Aksesibilitas', 'type' => 'likert'],
            ['text' => 'Signage dan petunjuk arah jelas', 'category' => 'Aksesibilitas', 'type' => 'likert'],
            
            // Keamanan (4)
            ['text' => 'Sistem keamanan kampus baik', 'category' => 'Keamanan', 'type' => 'likert'],
            ['text' => 'CCTV terpasang di area strategis', 'category' => 'Keamanan', 'type' => 'likert'],
            ['text' => 'Petugas keamanan responsif', 'category' => 'Keamanan', 'type' => 'likert'],
            ['text' => 'Pencahayaan malam hari memadai', 'category' => 'Keamanan', 'type' => 'likert'],
            
            // Pilihan Ganda (3)
            ['text' => 'Fasilitas mana yang paling baik kondisinya?', 'category' => 'Evaluasi', 'type' => 'pilihan_ganda', 'options' => ['Ruang Kuliah', 'Laboratorium', 'Perpustakaan', 'Fasilitas Umum', 'Parkir']],
            ['text' => 'Fasilitas mana yang paling perlu diperbaiki?', 'category' => 'Prioritas', 'type' => 'pilihan_ganda', 'options' => ['Ruang Kuliah', 'Toilet', 'Lab', 'Kantin', 'Parkir', 'Lainnya']],
            ['text' => 'Tingkat kepuasan terhadap fasilitas keseluruhan?', 'category' => 'Overall', 'type' => 'pilihan_ganda', 'options' => ['Sangat Puas', 'Puas', 'Cukup', 'Kurang Puas', 'Tidak Puas']],
            
            // Isian (1)
            ['text' => 'Saran perbaikan fasilitas kampus', 'category' => 'Saran', 'type' => 'isian'],
        ];

        $this->createQuestions($kuesioner7->id, $pertanyaanFasilitas);

        // Kuesioner 8: Kepuasan Layanan Administrasi - 23 pertanyaan
        $kuesioner8 = Kuesioner::create([
            'judul' => 'Survei Kepuasan Layanan Administrasi Fakultas',
            'deskripsi' => 'Evaluasi terhadap kualitas pelayanan administrasi akademik, kemahasiswaan, dan keuangan.',
            'icon' => 'fas fa-file-alt',
            'target_responden' => ['mahasiswa'],
            'status_aktif' => true,
            'tanggal_mulai' => now()->subDays(3),
            'tanggal_selesai' => now()->addMonths(2),
            'dibuat_oleh' => 1,
        ]);

        $pertanyaanAdmin = [
            // Administrasi Akademik (6)
            ['text' => 'Proses pengurusan surat cepat', 'category' => 'Adm. Akademik', 'type' => 'likert'],
            ['text' => 'Petugas akademik ramah dan membantu', 'category' => 'Adm. Akademik', 'type' => 'likert'],
            ['text' => 'Persyaratan administrasi jelas', 'category' => 'Adm. Akademik', 'type' => 'likert'],
            ['text' => 'Waktu pelayanan sesuai kebutuhan', 'category' => 'Adm. Akademik', 'type' => 'likert'],
            ['text' => 'Informasi prosedur mudah diakses', 'category' => 'Adm. Akademik', 'type' => 'likert'],
            ['text' => 'Birokrasi tidak berbelit', 'category' => 'Adm. Akademik', 'type' => 'likert'],
            
            // Kemahasiswaan (5)
            ['text' => 'Layanan beasiswa responsif', 'category' => 'Kemahasiswaan', 'type' => 'likert'],
            ['text' => 'Pengurusan organisasi kemahasiswaan mudah', 'category' => 'Kemahasiswaan', 'type' => 'likert'],
            ['text' => 'Informasi kegiatan kampus jelas', 'category' => 'Kemahasiswaan', 'type' => 'likert'],
            ['text' => 'Konseling mahasiswa membantu', 'category' => 'Kemahasiswaan', 'type' => 'likert'],
            ['text' => 'Dukungan untuk prestasi mahasiswa baik', 'category' => 'Kemahasiswaan', 'type' => 'likert'],
            
            // Keuangan (4)
            ['text' => 'Proses pembayaran UKT mudah', 'category' => 'Keuangan', 'type' => 'likert'],
            ['text' => 'Informasi tagihan jelas dan tepat waktu', 'category' => 'Keuangan', 'type' => 'likert'],
            ['text' => 'Layanan keringanan UKT transparan', 'category' => 'Keuangan', 'type' => 'likert'],
            ['text' => 'Petugas keuangan profesional', 'category' => 'Keuangan', 'type' => 'likert'],
            
            // Layanan Online (4)
            ['text' => 'Portal layanan online user-friendly', 'category' => 'Layanan Online', 'type' => 'likert'],
            ['text' => 'Pengajuan online cepat diproses', 'category' => 'Layanan Online', 'type' => 'likert'],
            ['text' => 'Tracking status permohonan mudah', 'category' => 'Layanan Online', 'type' => 'likert'],
            ['text' => 'Notifikasi otomatis berfungsi', 'category' => 'Layanan Online', 'type' => 'likert'],
            
            // Pilihan Ganda (3)
            ['text' => 'Layanan administrasi yang paling sering digunakan?', 'category' => 'Penggunaan', 'type' => 'pilihan_ganda', 'options' => ['Surat Akademik', 'Beasiswa', 'Keuangan', 'Kemahasiswaan', 'Transkrip/Ijazah']],
            ['text' => 'Aspek layanan yang perlu ditingkatkan?', 'category' => 'Prioritas', 'type' => 'pilihan_ganda', 'options' => ['Kecepatan', 'Keramahan', 'Transparansi', 'Prosedur', 'Sistem Online']],
            ['text' => 'Kepuasan layanan administrasi secara keseluruhan?', 'category' => 'Overall', 'type' => 'pilihan_ganda', 'options' => ['Sangat Puas', 'Puas', 'Cukup', 'Kurang Puas', 'Tidak Puas']],
            
            // Isian (1)
            ['text' => 'Saran perbaikan layanan administrasi', 'category' => 'Saran', 'type' => 'isian'],
        ];

        $this->createQuestions($kuesioner8->id, $pertanyaanAdmin);

        // Kuesioner 9: Iklim Akademik dan Budaya Kampus - 27 pertanyaan
        $kuesioner9 = Kuesioner::create([
            'judul' => 'Survei Iklim Akademik dan Budaya Kampus',
            'deskripsi' => 'Evaluasi terhadap suasana akademik, interaksi sosial, dan budaya organisasi di kampus.',
            'icon' => 'fas fa-users',
            'target_responden' => ['mahasiswa', 'dosen'],
            'status_aktif' => true,
            'tanggal_mulai' => now(),
            'tanggal_selesai' => now()->addMonths(2),
            'dibuat_oleh' => 1,
        ]);

        $pertanyaanIklim = [
            // Iklim Akademik (7)
            ['text' => 'Suasana akademik kondusif untuk belajar', 'category' => 'Iklim Akademik', 'type' => 'likert'],
            ['text' => 'Diskusi ilmiah berjalan produktif', 'category' => 'Iklim Akademik', 'type' => 'likert'],
            ['text' => 'Kebebasan akademik dihormati', 'category' => 'Iklim Akademik', 'type' => 'likert'],
            ['text' => 'Riset dan publikasi didorong', 'category' => 'Iklim Akademik', 'type' => 'likert'],
            ['text' => 'Kompetisi akademik sehat', 'category' => 'Iklim Akademik', 'type' => 'likert'],
            ['text' => 'Integritas akademik dijunjung tinggi', 'category' => 'Iklim Akademik', 'type' => 'likert'],
            ['text' => 'Seminar dan workshop berkualitas', 'category' => 'Iklim Akademik', 'type' => 'likert'],
            
            // Interaksi Sosial (6)
            ['text' => 'Hubungan mahasiswa-dosen baik', 'category' => 'Interaksi Sosial', 'type' => 'likert'],
            ['text' => 'Interaksi antar mahasiswa positif', 'category' => 'Interaksi Sosial', 'type' => 'likert'],
            ['text' => 'Tidak ada diskriminasi', 'category' => 'Interaksi Sosial', 'type' => 'likert'],
            ['text' => 'Keberagaman dihargai', 'category' => 'Interaksi Sosial', 'type' => 'likert'],
            ['text' => 'Kolaborasi antar jurusan baik', 'category' => 'Interaksi Sosial', 'type' => 'likert'],
            ['text' => 'Lingkungan inklusif dan ramah', 'category' => 'Interaksi Sosial', 'type' => 'likert'],
            
            // Organisasi Kemahasiswaan (5)
            ['text' => 'Organisasi mahasiswa aktif', 'category' => 'Organisasi', 'type' => 'likert'],
            ['text' => 'Kegiatan ekstrakurikuler berkualitas', 'category' => 'Organisasi', 'type' => 'likert'],
            ['text' => 'Fakultas mendukung kegiatan mahasiswa', 'category' => 'Organisasi', 'type' => 'likert'],
            ['text' => 'Kompetisi dan event kampus menarik', 'category' => 'Organisasi', 'type' => 'likert'],
            ['text' => 'Leadership training tersedia', 'category' => 'Organisasi', 'type' => 'likert'],
            
            // Kesejahteraan (4)
            ['text' => 'Work-life balance terjaga', 'category' => 'Kesejahteraan', 'type' => 'likert'],
            ['text' => 'Support untuk mental health memadai', 'category' => 'Kesejahteraan', 'type' => 'likert'],
            ['text' => 'Tekanan akademik manageable', 'category' => 'Kesejahteraan', 'type' => 'likert'],
            ['text' => 'Fakultas peduli kesejahteraan mahasiswa', 'category' => 'Kesejahteraan', 'type' => 'likert'],
            
            // Nilai dan Etika (3)
            ['text' => 'Nilai kejujuran diamalkan', 'category' => 'Nilai dan Etika', 'type' => 'likert'],
            ['text' => 'Transparansi dalam kebijakan', 'category' => 'Nilai dan Etika', 'type' => 'likert'],
            ['text' => 'Akuntabilitas dipraktikkan', 'category' => 'Nilai dan Etika', 'type' => 'likert'],
            
            // Pilihan Ganda (2)
            ['text' => 'Aspek budaya kampus yang paling positif?', 'category' => 'Evaluasi', 'type' => 'pilihan_ganda', 'options' => ['Iklim Akademik', 'Interaksi Sosial', 'Kegiatan Mahasiswa', 'Kesejahteraan', 'Nilai Etika']],
            ['text' => 'Apakah Anda bangga menjadi bagian dari fakultas ini?', 'category' => 'Sense of Belonging', 'type' => 'pilihan_ganda', 'options' => ['Sangat Bangga', 'Bangga', 'Netral', 'Kurang Bangga', 'Tidak Bangga']],
            
            // Isian (1)
            ['text' => 'Saran untuk meningkatkan budaya kampus', 'category' => 'Saran', 'type' => 'isian'],
        ];

        $this->createQuestions($kuesioner9->id, $pertanyaanIklim);

        // Kuesioner 10: Evaluasi Program Magang dan PKL - 21 pertanyaan
        $kuesioner10 = Kuesioner::create([
            'judul' => 'Evaluasi Program Magang dan Praktik Kerja Lapangan',
            'deskripsi' => 'Penilaian terhadap efektivitas program magang dan PKL dalam mempersiapkan mahasiswa ke dunia kerja.',
            'icon' => 'fas fa-briefcase',
            'target_responden' => ['mahasiswa'],
            'status_aktif' => true,
            'tanggal_mulai' => now()->subDays(7),
            'tanggal_selesai' => now()->addMonth(3),
            'dibuat_oleh' => 1,
        ]);

        $pertanyaanMagang = [
            // Persiapan (5)
            ['text' => 'Briefing sebelum magang memadai', 'category' => 'Persiapan', 'type' => 'likert'],
            ['text' => 'Fakultas membantu mencari tempat magang', 'category' => 'Persiapan', 'type' => 'likert'],
            ['text' => 'Panduan magang jelas dan lengkap', 'category' => 'Persiapan', 'type' => 'likert'],
            ['text' => 'Persyaratan administrasi tidak menyulitkan', 'category' => 'Persiapan', 'type' => 'likert'],
            ['text' => 'Pembekalan keterampilan kerja diberikan', 'category' => 'Persiapan', 'type' => 'likert'],
            
            // Pelaksanaan (6)
            ['text' => 'Tugas magang sesuai kompetensi jurusan', 'category' => 'Pelaksanaan', 'type' => 'likert'],
            ['text' => 'Pembimbing lapangan membantu', 'category' => 'Pelaksanaan', 'type' => 'likert'],
            ['text' => 'Dosen pembimbing responsif', 'category' => 'Pelaksanaan', 'type' => 'likert'],
            ['text' => 'Durasi magang cukup untuk belajar', 'category' => 'Pelaksanaan', 'type' => 'likert'],
            ['text' => 'Fasilitas di tempat magang memadai', 'category' => 'Pelaksanaan', 'type' => 'likert'],
            ['text' => 'Monitoring dari fakultas teratur', 'category' => 'Pelaksanaan', 'type' => 'likert'],
            
            // Manfaat (5)
            ['text' => 'Magang meningkatkan kompetensi teknis', 'category' => 'Manfaat', 'type' => 'likert'],
            ['text' => 'Soft skills berkembang selama magang', 'category' => 'Manfaat', 'type' => 'likert'],
            ['text' => 'Pengalaman kerja nyata berharga', 'category' => 'Manfaat', 'type' => 'likert'],
            ['text' => 'Networking profesional terbangun', 'category' => 'Manfaat', 'type' => 'likert'],
            ['text' => 'Magang membantu kesiapan kerja', 'category' => 'Manfaat', 'type' => 'likert'],
            
            // Pilihan Ganda (4)
            ['text' => 'Dimana Anda melaksanakan magang?', 'category' => 'Lokasi', 'type' => 'pilihan_ganda', 'options' => ['Perusahaan Swasta', 'BUMN', 'Startup', 'Instansi Pemerintah', 'NGO', 'Lainnya']],
            ['text' => 'Durasi magang Anda?', 'category' => 'Durasi', 'type' => 'pilihan_ganda', 'options' => ['< 3 bulan', '3-4 bulan', '5-6 bulan', '> 6 bulan']],
            ['text' => 'Bagaimana Anda mendapatkan tempat magang?', 'category' => 'Akses', 'type' => 'pilihan_ganda', 'options' => ['Dari Fakultas', 'Mencari Sendiri', 'Referensi Teman', 'Alumni Network', 'Job Fair']],
            ['text' => 'Tingkat kepuasan program magang?', 'category' => 'Evaluasi', 'type' => 'pilihan_ganda', 'options' => ['Sangat Puas', 'Puas', 'Cukup', 'Kurang Puas', 'Tidak Puas']],
            
            // Isian (1)
            ['text' => 'Saran perbaikan program magang dan PKL', 'category' => 'Saran', 'type' => 'isian'],
        ];

        $this->createQuestions($kuesioner10->id, $pertanyaanMagang);
    }

    /**
     * Helper function to create questions
     */
    private function createQuestions($kuesionerId, $pertanyaanArray)
    {
        foreach ($pertanyaanArray as $index => $pertanyaan) {
            $data = [
                'kuesioner_id' => $kuesionerId,
                'teks_pertanyaan' => $pertanyaan['text'],
                'jenis_pertanyaan' => $pertanyaan['type'],
                'kategori' => $pertanyaan['category'],
                'urutan' => $index + 1,
                'wajib_diisi' => true,
            ];

            // Add options for multiple choice questions
            if ($pertanyaan['type'] === 'pilihan_ganda' && isset($pertanyaan['options'])) {
                $data['opsi_jawaban'] = is_array($pertanyaan['options']) 
                    ? json_encode($pertanyaan['options']) 
                    : json_encode(explode(', ', $pertanyaan['options']));
            }

            Pertanyaan::create($data);
        }
    }
}
