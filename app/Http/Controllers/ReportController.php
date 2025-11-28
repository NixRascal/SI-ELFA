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
     * Tampilkan laporan survei.
     */
    public function index(Request $request): View
    {
        // Statistik
        $totalKuesioner = Kuesioner::count();
        $totalResponden = Responden::count();

        // Total pertanyaan dari semua kuesioner
        $totalPertanyaan = Pertanyaan::count();

        // Kuesioner aktif
        $kuesionerAktif = Kuesioner::where('status_aktif', true)
            ->whereDate('tanggal_mulai', '<=', now())
            ->whereDate('tanggal_selesai', '>=', now())
            ->count();

        // Parameter
        $search = $request->query('cariSurvei', '');
        $targetFilter = $request->query('target', '');

        // Subquery untuk jumlah responden
        $respondenCountSubquery = DB::table('jawaban')
            ->select('kuesioner_id', DB::raw('count(distinct responden_id) as responden_count'))
            ->groupBy('kuesioner_id');

        // Laporan per kuesioner dengan pagination dan filtering
        $laporanKuesioner = Kuesioner::with(['admin'])
            ->withCount('pertanyaan')
            ->leftJoinSub($respondenCountSubquery, 'responden_counts', function ($join) {
                $join->on('kuesioner.id', '=', 'responden_counts.kuesioner_id');
            })
            ->select('kuesioner.*', DB::raw('COALESCE(responden_counts.responden_count, 0) as responden_count'))
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('judul', 'like', "%{$search}%")
                        ->orWhere('deskripsi', 'like', "%{$search}%");
                });
            })
            ->when($targetFilter, function ($query, $targetFilter) {
                $query->whereJsonContains('target_responden', $targetFilter);
            })
            ->orderByDesc('responden_count')
            ->paginate(10)
            ->withQueryString();

        // Ringkasan cepat - top 3 kuesioner berdasarkan responden (Global)
        $topKuesioner = Kuesioner::with(['admin'])
            ->withCount('pertanyaan')
            ->leftJoinSub($respondenCountSubquery, 'responden_counts', function ($join) {
                $join->on('kuesioner.id', '=', 'responden_counts.kuesioner_id');
            })
            ->select('kuesioner.*', DB::raw('COALESCE(responden_counts.responden_count, 0) as responden_count'))
            ->orderByDesc('responden_count')
            ->limit(3)
            ->get();

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
     * Tampilkan laporan detail untuk kuesioner tertentu.
     */
    public function show(Request $request, $id): View
    {
        $kuesioner = Kuesioner::with(['admin', 'pertanyaan'])->findOrFail($id);

        // Dapatkan semua responden untuk kuesioner ini dengan pagination
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
            ->orderBy('waktu_isi', 'desc')
            ->paginate(10)
            ->withQueryString();

        // Dapatkan jumlah total untuk statistik
        $totalResponden = DB::table('jawaban')
            ->where('kuesioner_id', $id)
            ->distinct('responden_id')
            ->count('responden_id');

        return view('admin.laporan.detail', compact('kuesioner', 'responden', 'totalResponden'));
    }

    /**
     * Tampilkan analisis/hasil untuk kuesioner tertentu.
     */
    public function hasil(Request $request, $id): View
    {
        $kuesioner = Kuesioner::with(['pertanyaan'])->findOrFail($id);

        // Dapatkan total responden
        $totalResponden = DB::table('jawaban')
            ->where('kuesioner_id', $id)
            ->distinct('responden_id')
            ->count('responden_id');

        // Analisis jawaban untuk setiap pertanyaan
        $analisis = $kuesioner->pertanyaan->map(function ($pertanyaan) use ($totalResponden) {
            $jawaban = Jawaban::where('pertanyaan_id', $pertanyaan->id)->get();

            $hasil = [
                'pertanyaan' => $pertanyaan,
                'total_jawaban' => $jawaban->count(),
            ];

            if ($pertanyaan->jenis_pertanyaan === 'likert') {
                // Hitung rata-rata untuk skala Likert
                $total = $jawaban->sum('nilai_likert');
                $hasil['rata_rata'] = $jawaban->count() > 0 ? round($total / $jawaban->count(), 2) : 0;

                // Distribusi nilai Likert
                $distribusi = $jawaban->groupBy('nilai_likert')->map(function ($group) use ($totalResponden) {
                    return [
                        'count' => $group->count(),
                        'percentage' => $totalResponden > 0 ? round(($group->count() / $totalResponden) * 100, 1) : 0
                    ];
                });
                $hasil['distribusi'] = $distribusi;

            } elseif ($pertanyaan->jenis_pertanyaan === 'pilihan_ganda') {
                // Hitung untuk setiap opsi menggunakan isi_jawaban
                $distribusi = $jawaban->groupBy('isi_jawaban')->map(function ($group) use ($totalResponden) {
                    return [
                        'count' => $group->count(),
                        'percentage' => $totalResponden > 0 ? round(($group->count() / $totalResponden) * 100, 1) : 0
                    ];
                });
                $hasil['distribusi'] = $distribusi;

            } elseif ($pertanyaan->jenis_pertanyaan === 'isian') {
                // Dapatkan semua jawaban teks menggunakan isi_jawaban
                $hasil['jawaban_text'] = $jawaban->pluck('isi_jawaban')->filter()->values();
            }

            return $hasil;
        });

        // Ambil data responden dengan pagination
        $responden = DB::table('responden')
            ->join('jawaban', 'responden.id', '=', 'jawaban.responden_id')
            ->where('jawaban.kuesioner_id', $id)
            ->select(
                'responden.id',
                'responden.nama',
                'responden.npm',
                'responden.email',
                'responden.jenis_responden',
                DB::raw('MIN(jawaban.created_at) as waktu_mulai'),
                DB::raw('MAX(jawaban.created_at) as waktu_selesai'),
                DB::raw('COUNT(jawaban.id) as jumlah_jawaban')
            )
            ->groupBy('responden.id', 'responden.nama', 'responden.npm', 'responden.email', 'responden.jenis_responden')
            ->orderBy('waktu_selesai', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.laporan.hasil', compact('kuesioner', 'analisis', 'totalResponden', 'responden'));
    }

    /**
     * Ekspor laporan ke CSV.
     */
    public function export($id)
    {
        $kuesioner = Kuesioner::with([
            'pertanyaan' => function ($query) {
                $query->orderBy('urutan');
            }
        ])->findOrFail($id);

        // Dapatkan semua responden untuk kuesioner ini
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
                DB::raw('MIN(jawaban.created_at) as waktu_isi')
            )
            ->groupBy(
                'responden.id',
                'responden.nama',
                'responden.email',
                'responden.npm',
                'responden.fakultas',
                'responden.jurusan',
                'responden.jenis_responden'
            )
            ->orderBy('responden.id')
            ->get();

        // Dapatkan semua jawaban dikelompokkan berdasarkan responden
        $jawabanGrouped = DB::table('jawaban')
            ->join('pertanyaan', 'jawaban.pertanyaan_id', '=', 'pertanyaan.id')
            ->where('jawaban.kuesioner_id', $id)
            ->select(
                'jawaban.responden_id',
                'pertanyaan.id as pertanyaan_id',
                'pertanyaan.urutan',
                'jawaban.nilai_likert',
                'jawaban.isi_jawaban'
            )
            ->orderBy('pertanyaan.urutan')
            ->get()
            ->groupBy('responden_id');

        $filename = 'laporan_' . str_replace(' ', '_', strtolower($kuesioner->judul)) . '_' . date('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($responden, $kuesioner, $jawabanGrouped) {
            $file = fopen('php://output', 'w');

            // Tambahkan BOM untuk UTF-8
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Buat baris header
            $headerRow = [
                'Nama',
                'Email',
                'NPM',
                'Fakultas',
                'Jurusan',
                'Jenis Responden',
                'Waktu Isi'
            ];

            // Tambahkan setiap pertanyaan sebagai kolom
            foreach ($kuesioner->pertanyaan as $pertanyaan) {
                $headerRow[] = 'P' . $pertanyaan->urutan . ': ' . $pertanyaan->teks_pertanyaan;
            }

            fputcsv($file, $headerRow);

            // Baris data - setiap responden adalah satu baris
            foreach ($responden as $r) {
                $row = [
                    $r->nama,
                    $r->email,
                    $r->npm ?: '-',
                    $r->fakultas ?: '-',
                    $r->jurusan ?: '-',
                    ucfirst($r->jenis_responden),
                    Carbon::parse($r->waktu_isi)->format('Y-m-d H:i:s')
                ];

                // Dapatkan jawaban untuk responden ini
                $jawaban = $jawabanGrouped->get($r->id, collect());

                // Tambahkan jawaban untuk setiap pertanyaan
                foreach ($kuesioner->pertanyaan as $pertanyaan) {
                    $answer = $jawaban->firstWhere('pertanyaan_id', $pertanyaan->id);

                    if ($answer) {
                        // Untuk Likert, tampilkan nilai numerik
                        if ($pertanyaan->jenis_pertanyaan === 'likert' && $answer->nilai_likert) {
                            $row[] = $answer->nilai_likert;
                        } else {
                            // Untuk tipe lain, tampilkan jawaban teks
                            $row[] = $answer->isi_jawaban ?: '-';
                        }
                    } else {
                        $row[] = '-';
                    }
                }

                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Cetak laporan.
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
                // Gunakan isi_jawaban untuk pilihan ganda
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

        return view('admin.laporan.print', compact('kuesioner', 'analisis', 'totalResponden'));
    }

    /**
     * Hasilkan analisis AI untuk hasil survei
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

            // Dapatkan analisis AI
            $result = $gemini->analyzeSurveyResults($kuesioner, $analisis, $totalResponden);

            \Log::info('Gemini API response received', ['success' => $result['success']]);

            if ($result['success']) {
                return response()->json([
                    'success' => true,
                    'analysis' => $result['analysis']
                ]);
            } else {
                \Log::error('Gemini API error: ' . $result['error']);

                // Cek apakah ini error rate limit
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

