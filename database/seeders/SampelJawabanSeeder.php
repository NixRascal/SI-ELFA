<?php

namespace Database\Seeders;

use App\Models\Responden;
use App\Models\Kuesioner;
use App\Models\Pertanyaan;
use App\Models\Jawaban;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class SampelJawabanSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        
        $fakultasJurusan = [
            'Teknik' => ['Teknik Informatika', 'Teknik Elektro', 'Teknik Sipil', 'Teknik Mesin', 'Teknik Industri'],
            'Ekonomi dan Bisnis' => ['Manajemen', 'Akuntansi', 'Ekonomi Pembangunan'],
            'Kedokteran' => ['Pendidikan Dokter', 'Keperawatan', 'Farmasi'],
            'Ilmu Sosial dan Politik' => ['Ilmu Komunikasi', 'Ilmu Pemerintahan', 'Hubungan Internasional'],
        ];

        // Generate 600 responden
        $respondenIds = [];
        $respondenTypes = [];
        
        for ($i = 0; $i < 600; $i++) {
            $fakultas = $faker->randomElement(array_keys($fakultasJurusan));
            $jurusan = $faker->randomElement($fakultasJurusan[$fakultas]);
            
            $rand = rand(1, 100);
            if ($rand <= 70) {
                $jenisResponden = 'mahasiswa';
            } elseif ($rand <= 85) {
                $jenisResponden = 'dosen';
            } else {
                $jenisResponden = 'alumni';
            }

            $responden = Responden::create([
                'nama' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'npm' => $jenisResponden === 'mahasiswa' ? '21' . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT) : null,
                'fakultas' => $fakultas,
                'jurusan' => $jurusan,
                'jenis_responden' => $jenisResponden,
                'sesi_token' => bin2hex(random_bytes(16)),
                'created_at' => now()->subDays(rand(1, 60)),
                'updated_at' => now()->subDays(rand(1, 60)),
            ]);

            $respondenIds[] = $responden->id;
            $respondenTypes[$responden->id] = $jenisResponden;
        }

        // Generate answers
        $kuesionerList = Kuesioner::with('pertanyaan')->get();
        
        foreach ($kuesionerList as $kuesioner) {
            $targetResponden = is_array($kuesioner->target_responden) 
                ? $kuesioner->target_responden 
                : [$kuesioner->target_responden];
            
            $eligibleRespondenIds = array_filter($respondenIds, function($id) use ($respondenTypes, $targetResponden) {
                return in_array($respondenTypes[$id], $targetResponden);
            });

            if (count($eligibleRespondenIds) == 0) continue;

            $jumlahResponden = (int) (count($eligibleRespondenIds) * (rand(60, 95) / 100));
            $selectedIds = array_slice(array_values($eligibleRespondenIds), 0, $jumlahResponden);

            foreach ($selectedIds as $respondenId) {
                foreach ($kuesioner->pertanyaan as $pertanyaan) {
                    $jawabanData = [
                        'kuesioner_id' => $kuesioner->id,
                        'pertanyaan_id' => $pertanyaan->id,
                        'responden_id' => $respondenId,
                    ];

                    if ($pertanyaan->jenis_pertanyaan === 'likert') {
                        $rand = rand(1, 100);
                        if ($rand <= 5) $nilai = 1;
                        elseif ($rand <= 15) $nilai = 2;
                        elseif ($rand <= 35) $nilai = 3;
                        elseif ($rand <= 70) $nilai = 4;
                        else $nilai = 5;
                        
                        $jawabanData['nilai_likert'] = $nilai;
                        $jawabanData['isi_jawaban'] = (string)$nilai;
                        
                    } elseif ($pertanyaan->jenis_pertanyaan === 'pilihan_ganda') {
                        $opsiJawaban = $pertanyaan->opsi_jawaban;
                        if (is_array($opsiJawaban) && count($opsiJawaban) > 0) {
                            $jawabanData['isi_jawaban'] = $opsiJawaban[array_rand($opsiJawaban)];
                        } else {
                            $jawabanData['isi_jawaban'] = 'N/A';
                        }
                        
                    } elseif ($pertanyaan->jenis_pertanyaan === 'isian') {
                        $jawabanData['isi_jawaban'] = $this->generateTextAnswer($pertanyaan, $faker);
                    }

                    $now = now();
                    $jawabanData['created_at'] = $now;
                    $jawabanData['updated_at'] = $now;

                    Jawaban::create($jawabanData);
                }
            }
        }
    }

    private function generateTextAnswer($pertanyaan, $faker)
    {
        $kategori = strtolower($pertanyaan->kategori ?? '');
        $teks = strtolower($pertanyaan->teks_pertanyaan ?? '');

        if (str_contains($kategori, 'saran') || str_contains($teks, 'saran')) {
            $pool = [
                'Tingkatkan kualitas fasilitas dan infrastruktur.',
                'Perlu peningkatan sistem pelayanan administrasi.',
                'Perbanyak kegiatan yang melibatkan mahasiswa.',
                'Modernisasi peralatan laboratorium diperlukan.',
                'Tingkatkan kecepatan dan stabilitas internet.',
                'Perbanyak koleksi buku perpustakaan.',
                'Perlu pelatihan tambahan softskills.',
                'Jadwal konsultasi lebih fleksibel.',
                'Sistem akademik harus lebih user-friendly.',
                'Perluas jam operasional layanan.',
            ];
            return $pool[array_rand($pool)];
        }

        if (str_contains($kategori, 'kendala') || str_contains($teks, 'kendala')) {
            $pool = [
                'Internet tidak stabil saat pembelajaran online.',
                'Kurang informasi tentang prosedur administrasi.',
                'Jadwal yang padat sulit diatur.',
                'Fasilitas lab terbatas untuk praktikum.',
                'Akses perpustakaan terbatas diluar jam kerja.',
                'Komunikasi dosen-mahasiswa kurang lancar.',
                'Sistem pendaftaran sering error.',
                'Kurang ruang diskusi kelompok.',
            ];
            return $pool[array_rand($pool)];
        }

        $pool = [
            'Secara keseluruhan sudah cukup baik.',
            'Pelayanan memuaskan dan sesuai harapan.',
            'Perlu peningkatan di beberapa aspek.',
            'Sangat puas dengan layanan yang diberikan.',
            'Cukup baik dengan beberapa penyesuaian.',
            'Harapannya bisa ditingkatkan lagi.',
            'Sudah bagus, teruskan pelayanannya.',
            'Masih perlu perbaikan untuk hasil maksimal.',
        ];
        
        return $pool[array_rand($pool)];
    }
}
