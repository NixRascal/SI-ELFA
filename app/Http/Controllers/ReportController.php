<?php

namespace App\Http\Controllers;

use App\Models\Kuesioner;
use App\Models\Responden;
use App\Models\Pertanyaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ReportController extends Controller
{
    /**
     * Display survey reports.
     */
    public function index(): View
    {
        // Statistics
        $totalKuesioner = Kuesioner::count();
        $totalResponden = Responden::count();
        
        // Total pertanyaan dari semua kuesioner
        $totalPertanyaan = Pertanyaan::count();
        
        // Kuesioner aktif
        $kuesionerAktif = Kuesioner::where('status_aktif', true)
            ->whereDate('tanggal_mulai', '<=', now())
            ->whereDate('tanggal_selesai', '>=', now())
            ->count();

        // Laporan per kuesioner
        $laporanKuesioner = Kuesioner::with(['admin', 'pertanyaan'])
            ->get()
            ->map(function ($kuesioner) {
                // Hitung jumlah responden untuk kuesioner ini
                $respondenCount = DB::table('jawaban')
                    ->where('kuesioner_id', $kuesioner->id)
                    ->distinct('responden_id')
                    ->count('responden_id');
                
                $kuesioner->responden_count = $respondenCount;
                $kuesioner->pertanyaan_count = $kuesioner->pertanyaan->count();
                
                return $kuesioner;
            })
            ->sortByDesc('responden_count') // Sort by responden count descending
            ->values(); // Re-index collection

        // Ringkasan cepat - top 3 kuesioner berdasarkan responden
        $topKuesioner = $laporanKuesioner->take(3)->values();

        return view('admin.laporan.index', compact(
            'totalKuesioner',
            'totalResponden',
            'totalPertanyaan',
            'kuesionerAktif',
            'laporanKuesioner',
            'topKuesioner'
        ));
    }
}
