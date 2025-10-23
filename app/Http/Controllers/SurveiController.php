<?php

namespace App\Http\Controllers;

use App\Models\Kuesioner;
use App\Models\Pertanyaan;
use App\Models\Responden;
use App\Models\Jawaban;
use Illuminate\Http\Request;

class SurveiController extends Controller
{
    public function tampilFormProfilResponden(Kuesioner $kuesioner)
    {
        $profil = session("survei.{$kuesioner->id}.profil", []);
        return view('survei.profil', compact('kuesioner', 'profil'));
    }

    public function simpanProfilResponden(Request $request, Kuesioner $kuesioner)
    {
        $data = $request->validate(
            [
                'jenis_responden' => ['required', 'in:mahasiswa,dosen,staff,alumni,stakeholder'],
                'nama' => ['required', 'string', 'max:255'],
                'npm' => ['nullable', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255'],
                'fakultas' => ['required', 'string', 'max:255'],
                'jurusan' => ['required', 'string', 'max:255'],
            ],
            [
                'jenis_responden.required' => 'Pilih jenis responden',
                'nama.required' => 'Nama wajib diisi',
                'email.required' => 'Email wajib diisi',
                'fakultas.required' => 'Fakultas wajib diisi',
                'jurusan.required' => 'Jurusan wajib diisi',
            ],
        );

        session(["survei.{$kuesioner->id}.profil" => $data]);

        return redirect()->route('survei.jawaban.tampil', $kuesioner->id);
    }

    public function tampilFormJawabanSurvei(Kuesioner $kuesioner)
    {
        // Pastikan profil responden sudah diisi
        $sessionKey = 'survei.' . $kuesioner->id . '.profil';
        $profil = session($sessionKey);

        if (!$profil) {
            return redirect()->route('survei.profil.tampil', $kuesioner->id)
                ->with('error', 'Silakan isi profil responden terlebih dahulu.');
        }

        // Muat pertanyaan untuk kuesioner ini
        $kuesioner->load('pertanyaan');
        $pertanyaan = $kuesioner->pertanyaan;

        // Tampilkan view untuk jawaban survei
        return view('survei.jawaban', compact('kuesioner', 'pertanyaan'));
    }

    public function simpanJawabanSurvei(Request $request, \App\Models\Kuesioner $kuesioner)
    {
        // Pastikan relasi pertanyaan tersedia
        $kuesioner->load('pertanyaan');

        // Bangun aturan validasi per pertanyaan
        $aturan = [];
        foreach ($kuesioner->pertanyaan as $p) {
            $key = "jawaban.{$p->id}";
            $rule = $p->wajib_diisi ? 'required' : 'nullable';

            if ($p->jenis_pertanyaan === 'likert') {
                $rule .= '|in:1,2,3,4,5';
            } elseif ($p->jenis_pertanyaan === 'isian') {
                $rule .= '|string';
            } else {
                // pilihan_ganda
                $rule .= '|string';
            }

            $aturan[$key] = $rule;
        }

        $dataValid = $request->validate($aturan);

        // Ambil profil responden yang sebelumnya disimpan di session
        $sessionKey = 'survei.' . $kuesioner->id . '.profil';
        $profil = session($sessionKey);

        if (!$profil) {
            return redirect()->route('survei.profil.tampil', $kuesioner->id)->with('error', 'Isi profil responden terlebih dahulu.');
        }

        // Simpan responden setelah semua jawaban valid
        $responden = \App\Models\Responden::create([
            'nama' => $profil['nama'] ?? null,
            'npm' => $profil['npm'] ?? null,
            'email' => $profil['email'] ?? null,
            'jenis_responden' => $profil['jenis_responden'] ?? null,
            'fakultas' => $profil['fakultas'] ?? null,
            'jurusan' => $profil['jurusan'] ?? null,
            'sesi_token' => \Illuminate\Support\Str::random(32), // Generate random unique token
            'waktu_pengisian' => now(),
        ]);

        // Simpan tiap jawaban
        foreach ($dataValid['jawaban'] ?? [] as $pertanyaanId => $nilai) {
            \App\Models\Jawaban::create([
                'kuesioner_id' => $kuesioner->id,
                'responden_id' => $responden->id,
                'pertanyaan_id' => $pertanyaanId,
                'isi_jawaban' => $nilai, // Menyimpan jawaban di kolom isi_jawaban
            ]);
        }

        // Bersihkan profil di session
        session()->forget($sessionKey);

        return redirect()->route('survei.selesai', $kuesioner->id)->with('success', 'Terima kasih. Jawaban Anda sudah tersimpan.');
    }

    public function halamanSelesai(Kuesioner $kuesioner)
    {
        return view('survei.selesai', [
            'kuesioner' => $kuesioner,
            'message' => session('success')
        ]);
    }
}
