<?php

namespace App\Http\Controllers;

use App\Models\Kuesioner;
use App\Models\Responden;
use App\Models\Jawaban;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index(): View
    {
        // Sync active status based on dates
        Kuesioner::syncActiveStatus();

        // Get statistics
        $totalKuesioner = Kuesioner::count();
        $kuesionerAktif = Kuesioner::active()->count();

        $totalResponden = Responden::count();

        // Hitung total jawaban (total butir pertanyaan yang dijawab)
        $totalJawaban = Jawaban::count();

        // Get recent questionnaires (3 latest) with responden count
        $recentQuestionnaires = Kuesioner::with('admin')
            ->withCount('pertanyaan')
            ->latest()
            ->take(3)
            ->get()
            ->map(function ($kuesioner) {
                // Count unique responden untuk kuesioner ini
                $respondenCount = DB::table('jawaban')
                    ->join('pertanyaan', 'jawaban.pertanyaan_id', '=', 'pertanyaan.id')
                    ->where('pertanyaan.kuesioner_id', $kuesioner->id)
                    ->distinct('jawaban.responden_id')
                    ->count('jawaban.responden_id');

                $kuesioner->responden_count = $respondenCount;
                // is_active is now handled by the model accessor
    
                return $kuesioner;
            });

        // Get respondent distribution
        $respondenDistribution = Responden::select('jenis_responden', DB::raw('count(*) as total'))
            ->groupBy('jenis_responden')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->jenis_responden => $item->total];
            });

        // Calculate percentages
        $totalRespondenForDistribution = $totalResponden > 0 ? $totalResponden : 1;
        $respondenStats = [
            'mahasiswa' => [
                'count' => $respondenDistribution['mahasiswa'] ?? 0,
                'percentage' => round((($respondenDistribution['mahasiswa'] ?? 0) / $totalRespondenForDistribution) * 100, 1)
            ],
            'dosen' => [
                'count' => $respondenDistribution['dosen'] ?? 0,
                'percentage' => round((($respondenDistribution['dosen'] ?? 0) / $totalRespondenForDistribution) * 100, 1)
            ],
            'staff' => [
                'count' => $respondenDistribution['staff'] ?? 0,
                'percentage' => round((($respondenDistribution['staff'] ?? 0) / $totalRespondenForDistribution) * 100, 1)
            ],
            'alumni' => [
                'count' => $respondenDistribution['alumni'] ?? 0,
                'percentage' => round((($respondenDistribution['alumni'] ?? 0) / $totalRespondenForDistribution) * 100, 1)
            ],
            'stakeholder' => [
                'count' => $respondenDistribution['stakeholder'] ?? 0,
                'percentage' => round((($respondenDistribution['stakeholder'] ?? 0) / $totalRespondenForDistribution) * 100, 1)
            ]
        ];

        // Get recent respondents with their latest kuesioner
        $recentRespondents = Responden::with([
            'jawaban' => function ($query) {
                $query->with('pertanyaan.kuesioner')->latest()->limit(1);
            }
        ])
            ->latest('waktu_pengisian')
            ->take(5)
            ->get()
            ->map(function ($responden) {
                // Get kuesioner from first jawaban's pertanyaan
                $latestAnswer = $responden->jawaban->first();
                $responden->kuesioner_judul = $latestAnswer && $latestAnswer->pertanyaan && $latestAnswer->pertanyaan->kuesioner
                    ? $latestAnswer->pertanyaan->kuesioner->judul
                    : '-';
                return $responden;
            });

        return view('admin.dashboard', compact(
            'totalKuesioner',
            'kuesionerAktif',
            'totalResponden',
            'totalJawaban',
            'recentQuestionnaires',
            'respondenStats',
            'recentRespondents'
        ));
    }
}
