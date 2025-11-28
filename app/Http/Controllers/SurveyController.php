<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRespondentProfileRequest;
use App\Http\Requests\StoreSurveyAnswerRequest;
use App\Models\Jawaban;
use App\Models\Kuesioner;
use App\Models\Responden;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SurveyController extends Controller
{
    /**
     * Display the respondent profile form.
     */
    public function showProfileForm(Kuesioner $questionnaire): View|RedirectResponse
    {
        if (!$questionnaire->is_active) {
            return redirect()->route('beranda')
                ->with('error', 'Maaf, kuesioner ini tidak aktif atau periode pengisian telah berakhir.');
        }

        $profile = session("survey.{$questionnaire->id}.profile", []);

        return view('survei.profil', [
            'kuesioner' => $questionnaire,
            'profil' => $profile
        ]);
    }

    /**
     * Store the respondent profile in session.
     */
    public function storeProfile(
        StoreRespondentProfileRequest $request,
        Kuesioner $questionnaire
    ): RedirectResponse {
        $profileData = $request->validated();

        // Validasi: Pastikan jenis responden sesuai dengan target kuesioner
        if (!in_array($profileData['jenis_responden'], $questionnaire->target_responden)) {
            return redirect()
                ->route('survei.profil', $questionnaire->id)
                ->with('error', 'Survei ini tidak tersedia untuk ' . ucfirst($profileData['jenis_responden']));
        }

        // Cek apakah responden sudah pernah mengisi kuesioner ini
        $existingResponden = Responden::where(function ($query) use ($profileData) {
            if (!empty($profileData['email'])) {
                $query->where('email', $profileData['email']);
            }
            if (!empty($profileData['npm'])) {
                $query->orWhere('npm', $profileData['npm']);
            }
        })->first();

        // Jika responden sudah ada dan sudah mengisi kuesioner ini, redirect dengan error
        if ($existingResponden && $existingResponden->sudahMengisiKuesioner($questionnaire->id)) {
            return redirect()
                ->route('survei.profil', $questionnaire->id)
                ->with('error', 'Anda sudah mengisi kuesioner ini sebelumnya.');
        }

        session(["survey.{$questionnaire->id}.profile" => $profileData]);

        return redirect()->route('survei.pertanyaan', $questionnaire->id);
    }

    /**
     * Display the survey questions form.
     */
    public function showQuestions(Kuesioner $questionnaire): View|RedirectResponse
    {
        if (!$questionnaire->is_active) {
            return redirect()->route('beranda')
                ->with('error', 'Maaf, kuesioner ini tidak aktif atau periode pengisian telah berakhir.');
        }

        $profile = session("survey.{$questionnaire->id}.profile");

        if (!$profile) {
            return redirect()
                ->route('survei.profil', $questionnaire->id)
                ->with('error', 'Silakan isi profil responden terlebih dahulu.');
        }

        $questionnaire->load('pertanyaan');

        $scaleLabels = [
            1 => 'Sangat Tidak Setuju',
            2 => 'Tidak Setuju',
            3 => 'Netral',
            4 => 'Setuju',
            5 => 'Sangat Setuju',
        ];

        return view('survei.jawaban', [
            'kuesioner' => $questionnaire,
            'pertanyaan' => $questionnaire->pertanyaan,
            'skalaLabel' => $scaleLabels
        ]);
    }

    /**
     * Store the survey answers.
     */
    public function storeAnswers(
        StoreSurveyAnswerRequest $request,
        Kuesioner $questionnaire
    ): RedirectResponse {
        $profile = session("survey.{$questionnaire->id}.profile");

        if (!$profile) {
            return redirect()
                ->route('survei.profil', $questionnaire->id)
                ->with('error', 'Isi profil responden terlebih dahulu.');
        }

        // Cek apakah sudah pernah mengisi berdasarkan email atau NPM
        $existingResponden = Responden::where(function ($query) use ($profile) {
            if (!empty($profile['email'])) {
                $query->where('email', $profile['email']);
            }
            if (!empty($profile['npm'])) {
                $query->orWhere('npm', $profile['npm']);
            }
        })->first();

        // Jika responden sudah ada, cek apakah sudah mengisi kuesioner ini
        if ($existingResponden && $existingResponden->sudahMengisiKuesioner($questionnaire->id)) {
            session()->forget("survey.{$questionnaire->id}.profile");

            return redirect()
                ->route('survei.profil', $questionnaire->id)
                ->with('error', 'Anda sudah mengisi kuesioner ini sebelumnya.');
        }

        // Create or use existing respondent
        $respondent = $existingResponden ?? Responden::create([
            'nama' => $profile['nama'],
            'npm' => $profile['npm'] ?? null,
            'email' => $profile['email'],
            'jenis_responden' => $profile['jenis_responden'],
            'fakultas' => $profile['fakultas'],
            'jurusan' => $profile['jurusan'],
            'sesi_token' => Str::random(32),
            'waktu_pengisian' => now(),
        ]);

        // Store answers with kuesioner_id
        $answers = $request->validated()['jawaban'] ?? [];

        foreach ($answers as $questionId => $answer) {
            Jawaban::create([
                'responden_id' => $respondent->id,
                'kuesioner_id' => $questionnaire->id,
                'pertanyaan_id' => $questionId,
                'isi_jawaban' => $answer,
                'nilai_likert' => is_numeric($answer) ? (int) $answer : null,
            ]);
        }

        // Clear session
        session()->forget("survey.{$questionnaire->id}.profile");

        return redirect()
            ->route('survei.selesai', $questionnaire->id)
            ->with('success', 'Terima kasih. Jawaban Anda sudah tersimpan.');
    }

    /**
     * Display the completion page.
     */
    public function complete(Kuesioner $questionnaire): View
    {
        return view('survei.selesai', [
            'kuesioner' => $questionnaire,
            'message' => session('success')
        ]);
    }
}
