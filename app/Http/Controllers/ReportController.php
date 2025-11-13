<?php

namespace App\Http\Controllers;

use App\Models\Kuesioner;
use App\Models\Responden;
use App\Models\Pertanyaan;
use App\Models\Jawaban;
use App\Services\GeminiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

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

    /**
     * Show detail report for specific questionnaire.
     */
    public function show($id): View
    {
        $kuesioner = Kuesioner::with(['admin', 'pertanyaan'])->findOrFail($id);
        
        // Get all respondents for this questionnaire
        $responden = DB::table('jawaban')
            ->join('responden', 'jawaban.responden_id', '=', 'responden.id')
            ->where('jawaban.kuesioner_id', $id)
            ->select(
                'responden.id',
                'responden.nama',
                'responden.email',
                'responden.npm',
                'responden.fakultas',
                'responden.jurusan',
                'responden.jenis_responden',
                'responden.created_at',
                'responden.updated_at',
                DB::raw('MIN(jawaban.created_at) as waktu_isi')
            )
            ->groupBy(
                'responden.id',
                'responden.nama',
                'responden.email',
                'responden.npm',
                'responden.fakultas',
                'responden.jurusan',
                'responden.jenis_responden',
                'responden.created_at',
                'responden.updated_at'
            )
            ->get();
        
        return view('admin.laporan.detail', compact('kuesioner', 'responden'));
    }

    /**
     * Show analysis/results for specific questionnaire.
     */
    public function hasil($id): View
    {
        $kuesioner = Kuesioner::with(['pertanyaan'])->findOrFail($id);
        
        // Get total respondents
        $totalResponden = DB::table('jawaban')
            ->where('kuesioner_id', $id)
            ->distinct('responden_id')
            ->count('responden_id');
        
        // Analyze answers for each question
        $analisis = $kuesioner->pertanyaan->map(function ($pertanyaan) use ($totalResponden) {
            $jawaban = Jawaban::where('pertanyaan_id', $pertanyaan->id)->get();
            
            $hasil = [
                'pertanyaan' => $pertanyaan,
                'total_jawaban' => $jawaban->count(),
            ];
            
            if ($pertanyaan->jenis_pertanyaan === 'likert') {
                // Calculate average for Likert scale
                $total = $jawaban->sum('nilai_likert');
                $hasil['rata_rata'] = $jawaban->count() > 0 ? round($total / $jawaban->count(), 2) : 0;
                
                // Distribution of Likert values
                $distribusi = $jawaban->groupBy('nilai_likert')->map(function ($group) use ($totalResponden) {
                    return [
                        'count' => $group->count(),
                        'percentage' => $totalResponden > 0 ? round(($group->count() / $totalResponden) * 100, 1) : 0
                    ];
                });
                $hasil['distribusi'] = $distribusi;
                
            } elseif ($pertanyaan->jenis_pertanyaan === 'pilihan_ganda') {
                // Count for each option using isi_jawaban
                $distribusi = $jawaban->groupBy('isi_jawaban')->map(function ($group) use ($totalResponden) {
                    return [
                        'count' => $group->count(),
                        'percentage' => $totalResponden > 0 ? round(($group->count() / $totalResponden) * 100, 1) : 0
                    ];
                });
                $hasil['distribusi'] = $distribusi;
                
            } elseif ($pertanyaan->jenis_pertanyaan === 'isian') {
                // Get all text answers using isi_jawaban
                $hasil['jawaban_text'] = $jawaban->pluck('isi_jawaban')->filter()->values();
            }
            
            return $hasil;
        });
        
        return view('admin.laporan.hasil', compact('kuesioner', 'analisis', 'totalResponden'));
    }

    /**
     * Export report to CSV.
     */
    public function export($id)
    {
        $kuesioner = Kuesioner::with(['pertanyaan'])->findOrFail($id);
        
        // Get all responses
        $responses = DB::table('jawaban')
            ->join('responden', 'jawaban.responden_id', '=', 'responden.id')
            ->join('pertanyaan', 'jawaban.pertanyaan_id', '=', 'pertanyaan.id')
            ->where('jawaban.kuesioner_id', $id)
            ->select(
                'responden.nama',
                'responden.email',
                'responden.npm',
                'responden.fakultas',
                'responden.jurusan',
                'responden.jenis_responden',
                'pertanyaan.teks_pertanyaan',
                'pertanyaan.jenis_pertanyaan',
                'jawaban.nilai_likert',
                'jawaban.isi_jawaban',
                'jawaban.created_at'
            )
            ->orderBy('responden.id')
            ->orderBy('pertanyaan.urutan')
            ->get();
        
        $filename = 'laporan_' . str_replace(' ', '_', strtolower($kuesioner->judul)) . '_' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($responses) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Header row
            fputcsv($file, [
                'Nama',
                'Email',
                'NPM',
                'Fakultas',
                'Jurusan',
                'Jenis Responden',
                'Pertanyaan',
                'Jenis Pertanyaan',
                'Nilai Likert',
                'Isi Jawaban',
                'Waktu Isi'
            ]);
            
            // Data rows
            foreach ($responses as $response) {
                fputcsv($file, [
                    $response->nama,
                    $response->email,
                    $response->npm,
                    $response->fakultas,
                    $response->jurusan,
                    $response->jenis_responden,
                    $response->teks_pertanyaan,
                    $response->jenis_pertanyaan,
                    $response->nilai_likert,
                    $response->isi_jawaban,
                    Carbon::parse($response->created_at)->format('Y-m-d H:i:s')
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }

    /**
     * Print report.
     */
    public function print($id): View
    {
        $kuesioner = Kuesioner::with(['pertanyaan'])->findOrFail($id);
        
        // Get total respondents
        $totalResponden = DB::table('jawaban')
            ->where('kuesioner_id', $id)
            ->distinct('responden_id')
            ->count('responden_id');
        
        // Analyze answers for each question
        $analisis = $kuesioner->pertanyaan->map(function ($pertanyaan) use ($totalResponden) {
            $jawaban = Jawaban::where('pertanyaan_id', $pertanyaan->id)->get();
            
            $hasil = [
                'pertanyaan' => $pertanyaan,
                'total_jawaban' => $jawaban->count(),
            ];
            
            if ($pertanyaan->jenis_pertanyaan === 'likert') {
                $total = $jawaban->sum('nilai_likert');
                $hasil['rata_rata'] = $jawaban->count() > 0 ? round($total / $jawaban->count(), 2) : 0;
                
                $distribusi = $jawaban->groupBy('nilai_likert')->map(function ($group) use ($totalResponden) {
                    return [
                        'count' => $group->count(),
                        'percentage' => $totalResponden > 0 ? round(($group->count() / $totalResponden) * 100, 1) : 0
                    ];
                });
                $hasil['distribusi'] = $distribusi;
                
            } elseif ($pertanyaan->jenis_pertanyaan === 'pilihan_ganda') {
                // Use isi_jawaban for multiple choice
                $distribusi = $jawaban->groupBy('isi_jawaban')->map(function ($group) use ($totalResponden) {
                    return [
                        'count' => $group->count(),
                        'percentage' => $totalResponden > 0 ? round(($group->count() / $totalResponden) * 100, 1) : 0
                    ];
                });
                $hasil['distribusi'] = $distribusi;
            }
            
            return $hasil;
        });
        
        return view('admin.laporan.print', compact('kuesioner', 'analisis', 'totalResponden'));
    }

    /**
     * Generate AI analysis for survey results
     */
    public function aiAnalysis($id, GeminiService $gemini): JsonResponse
    {
        try {
            \Log::info('AI Analysis started for questionnaire: ' . $id);
            
            $kuesioner = Kuesioner::with(['pertanyaan'])->findOrFail($id);
            \Log::info('Questionnaire loaded: ' . $kuesioner->judul);
            
            // Get total respondents
            $totalResponden = DB::table('jawaban')
                ->where('kuesioner_id', $id)
                ->distinct('responden_id')
                ->count('responden_id');
            
            \Log::info('Total respondents: ' . $totalResponden);
            
            // Analyze answers for each question
            $analisis = $kuesioner->pertanyaan->map(function ($pertanyaan) use ($totalResponden) {
                $jawaban = Jawaban::where('pertanyaan_id', $pertanyaan->id)->get();
                
                $hasil = [
                    'pertanyaan' => $pertanyaan,
                    'total_jawaban' => $jawaban->count(),
                ];
                
                if ($pertanyaan->jenis_pertanyaan === 'likert') {
                    $total = $jawaban->sum('nilai_likert');
                    $hasil['rata_rata'] = $jawaban->count() > 0 ? round($total / $jawaban->count(), 2) : 0;
                    
                    $distribusi = $jawaban->groupBy('nilai_likert')->map(function ($group) use ($totalResponden) {
                        return [
                            'count' => $group->count(),
                            'percentage' => $totalResponden > 0 ? round(($group->count() / $totalResponden) * 100, 1) : 0
                        ];
                    });
                    $hasil['distribusi'] = $distribusi;
                    
                } elseif ($pertanyaan->jenis_pertanyaan === 'pilihan_ganda') {
                    $distribusi = $jawaban->groupBy('isi_jawaban')->map(function ($group) use ($totalResponden) {
                        return [
                            'count' => $group->count(),
                            'percentage' => $totalResponden > 0 ? round(($group->count() / $totalResponden) * 100, 1) : 0
                        ];
                    });
                    $hasil['distribusi'] = $distribusi;
                    
                } elseif ($pertanyaan->jenis_pertanyaan === 'isian') {
                    $hasil['jawaban_text'] = $jawaban->pluck('isi_jawaban')->filter()->values();
                }
                
                return $hasil;
            });
            
            \Log::info('Analysis data prepared, calling Gemini API...');
            
            // Get AI analysis
            $result = $gemini->analyzeSurveyResults($kuesioner, $analisis, $totalResponden);
            
            \Log::info('Gemini API response received', ['success' => $result['success']]);
            
            if ($result['success']) {
                return response()->json([
                    'success' => true,
                    'analysis' => $result['analysis']
                ]);
            } else {
                \Log::error('Gemini API error: ' . $result['error']);
                
                // Check if it's a rate limit error
                if (strpos($result['error'], 'Terlalu banyak permintaan') !== false) {
                    return response()->json([
                        'success' => false,
                        'error' => $result['error']
                    ], 429);
                }
                
                return response()->json([
                    'success' => false,
                    'error' => $result['error']
                ], 500);
            }
            
        } catch (\Exception $e) {
            \Log::error('AI Analysis exception: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}

