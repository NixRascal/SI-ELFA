<?php

namespace App\Http\Controllers;

use App\Models\Kuesioner;
use App\Models\Pertanyaan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class QuestionnaireController extends Controller
{
    /**
     * Display a listing of active questionnaires.
     */
    public function index(Request $request)
    {
        $search = $request->query('cariSurvei', '');
        $today = Carbon::today()->toDateString();

        $questionnaires = Kuesioner::query()
            ->active()
            ->currentPeriod($today)
            ->when($search, function ($query, $search) {
                $query->search($search);
            })
            ->orderBy('tanggal_selesai')
            ->paginate(6)
            ->withQueryString();

        return view('survei.dashboard', [
            'kuesioner' => $questionnaires
        ]);
    }

    /**
     * Display a listing of questionnaires for admin management.
     */
    public function manage(Request $request)
    {
        $search = $request->query('cari', '');
        $statusFilter = $request->query('status', '');
        $targetFilter = $request->query('target', '');

        $questionnaires = Kuesioner::query()
            ->with(['admin', 'pertanyaan'])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('judul', 'like', "%{$search}%")
                      ->orWhere('deskripsi', 'like', "%{$search}%");
                });
            })
            ->when($statusFilter, function ($query, $status) {
                if ($status === 'aktif') {
                    $query->where('status_aktif', true);
                } elseif ($status === 'nonaktif') {
                    $query->where('status_aktif', false);
                }
            })
            ->when($targetFilter, function ($query, $target) {
                $query->where('target_responden', $target);
            })
            ->latest()
            ->paginate(9)
            ->withQueryString();

        // Hitung jumlah responden untuk setiap kuesioner
        $questionnaires->getCollection()->transform(function ($kuesioner) {
            $kuesioner->responden_count = DB::table('jawaban')
                ->where('kuesioner_id', $kuesioner->id)
                ->distinct('responden_id')
                ->count('responden_id');
            
            return $kuesioner;
        });

        return view('admin.kuesioner.index', [
            'kuesioner' => $questionnaires,
            'search' => $search,
            'statusFilter' => $statusFilter,
            'targetFilter' => $targetFilter,
        ]);
    }

    /**
     * Show the form for creating a new questionnaire.
     */
    public function create(): View
    {
        return view('admin.kuesioner.create');
    }

    /**
     * Store a newly created questionnaire in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'icon' => 'required|string',
            'target_responden' => 'required|in:mahasiswa,dosen,staff,alumni,stakeholder',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status_aktif' => 'boolean',
            'pertanyaan' => 'required|array|min:1',
            'pertanyaan.*.teks_pertanyaan' => 'required|string',
            'pertanyaan.*.jenis_pertanyaan' => 'required|in:likert,pilihan_ganda,isian',
            'pertanyaan.*.kategori' => 'nullable|string',
            'pertanyaan.*.opsi' => 'nullable|array|min:2',
            'pertanyaan.*.opsi.*' => 'nullable|string',
        ], [
            'judul.required' => 'Judul kuesioner harus diisi',
            'icon.required' => 'Ikon harus dipilih',
            'target_responden.required' => 'Target responden harus dipilih',
            'tanggal_mulai.required' => 'Tanggal mulai harus diisi',
            'tanggal_selesai.required' => 'Tanggal selesai harus diisi',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai',
            'pertanyaan.required' => 'Minimal harus ada 1 pertanyaan',
            'pertanyaan.*.teks_pertanyaan.required' => 'Teks pertanyaan harus diisi',
            'pertanyaan.*.jenis_pertanyaan.required' => 'Jenis pertanyaan harus dipilih',
            'pertanyaan.*.opsi.min' => 'Pilihan ganda minimal harus memiliki 2 opsi',
        ]);

        DB::beginTransaction();
        try {
            // Create questionnaire
            $kuesioner = Kuesioner::create([
                'judul' => $validated['judul'],
                'deskripsi' => $validated['deskripsi'],
                'icon' => $validated['icon'],
                'target_responden' => $validated['target_responden'],
                'tanggal_mulai' => $validated['tanggal_mulai'],
                'tanggal_selesai' => $validated['tanggal_selesai'],
                'status_aktif' => $request->boolean('status_aktif', true),
                'dibuat_oleh' => Auth::id(),
            ]);

            // Create questions
            foreach ($validated['pertanyaan'] as $index => $pertanyaanData) {
                // Prepare opsi_jawaban based on jenis_pertanyaan
                $opsiJawaban = null;
                if ($pertanyaanData['jenis_pertanyaan'] === 'pilihan_ganda') {
                    $opsiJawaban = isset($pertanyaanData['opsi']) ? array_values(array_filter($pertanyaanData['opsi'])) : null;
                }
                
                Pertanyaan::create([
                    'kuesioner_id' => $kuesioner->id,
                    'teks_pertanyaan' => $pertanyaanData['teks_pertanyaan'],
                    'jenis_pertanyaan' => $pertanyaanData['jenis_pertanyaan'],
                    'opsi_jawaban' => $opsiJawaban,
                    'urutan' => $index + 1,
                    'wajib_diisi' => true,
                    'kategori' => $pertanyaanData['kategori'] ?? null,
                ]);
            }

            DB::commit();

            return redirect()->route('dashboard.kuesioner.index')
                ->with('success', 'Kuesioner berhasil dibuat');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
