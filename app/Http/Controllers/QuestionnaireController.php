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
     * Tampilkan daftar kuesioner aktif.
     */
    public function index(Request $request)
    {
        $search = $request->query('cariSurvei', '');
        $targetFilter = $request->query('target', '');
        $today = Carbon::today()->toDateString();

        $questionnaires = Kuesioner::query()
            ->active()
            ->when($targetFilter, function ($query, $targetFilter) {
                $query->whereJsonContains('target_responden', $targetFilter);
            })
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
     * Tampilkan daftar kuesioner untuk manajemen admin.
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
                $query->whereJsonContains('target_responden', $target);
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
     * Tampilkan formulir untuk membuat kuesioner baru.
     */
    public function create(): View
    {
        return view('admin.kuesioner.create');
    }

    /**
     * Simpan kuesioner yang baru dibuat ke penyimpanan.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'icon' => 'required|string',
            'target_responden' => 'required|array|min:1',
            'target_responden.*' => 'required|in:mahasiswa,dosen,staff,alumni,stakeholder',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status_aktif' => 'boolean',
            'pertanyaan' => 'required|array|min:1',
            'pertanyaan.*.teks_pertanyaan' => 'required|string',
            'pertanyaan.*.jenis_pertanyaan' => 'required|in:likert,pilihan_ganda,isian',
            'pertanyaan.*.kategori' => 'nullable|string',
            'pertanyaan.*.wajib_diisi' => 'nullable|boolean',
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
            // Buat kuesioner
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

            // Buat pertanyaan
            foreach ($validated['pertanyaan'] as $index => $pertanyaanData) {
                // Siapkan opsi_jawaban berdasarkan jenis_pertanyaan
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
                    'wajib_diisi' => isset($pertanyaanData['wajib_diisi']),
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

    /**
     * Tampilkan kuesioner yang ditentukan.
     */
    public function show(Request $request, Kuesioner $kuesioner): View
    {
        $kuesioner->load([
            'admin',
            'pertanyaan' => function ($query) {
                $query->orderBy('urutan');
            }
        ]);

        // Hitung jumlah responden
        $respondenCount = DB::table('jawaban')
            ->where('kuesioner_id', $kuesioner->id)
            ->distinct('responden_id')
            ->count('responden_id');

        // Ambil data responden dengan pagination
        $responden = DB::table('responden')
            ->join('jawaban', 'responden.id', '=', 'jawaban.responden_id')
            ->where('jawaban.kuesioner_id', $kuesioner->id)
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

        return view('admin.kuesioner.show', [
            'kuesioner' => $kuesioner,
            'respondenCount' => $respondenCount,
            'responden' => $responden
        ]);
    }

    /**
     * Tampilkan formulir untuk mengedit kuesioner yang ditentukan.
     */
    public function edit(Kuesioner $kuesioner): View
    {
        $kuesioner->load([
            'pertanyaan' => function ($query) {
                $query->orderBy('urutan');
            }
        ]);

        return view('admin.kuesioner.edit', [
            'kuesioner' => $kuesioner
        ]);
    }

    /**
     * Perbarui kuesioner yang ditentukan di penyimpanan.
     */
    public function update(Request $request, Kuesioner $kuesioner): RedirectResponse
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'icon' => 'required|string',
            'target_responden' => 'required|array|min:1',
            'target_responden.*' => 'required|in:mahasiswa,dosen,staff,alumni,stakeholder',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status_aktif' => 'boolean',
            'pertanyaan' => 'required|array|min:1',
            'pertanyaan.*.id' => 'nullable|exists:pertanyaan,id',
            'pertanyaan.*.teks_pertanyaan' => 'required|string',
            'pertanyaan.*.jenis_pertanyaan' => 'required|in:likert,pilihan_ganda,isian',
            'pertanyaan.*.kategori' => 'nullable|string',
            'pertanyaan.*.wajib_diisi' => 'nullable|boolean',
            'pertanyaan.*.opsi' => 'nullable|array|min:2',
            'pertanyaan.*.opsi.*' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // Validasi status aktif berdasarkan periode
            $statusAktif = $request->boolean('status_aktif', false); // Default false for checkbox
            $today = today();
            $startDate = \Carbon\Carbon::parse($validated['tanggal_mulai']);
            $endDate = \Carbon\Carbon::parse($validated['tanggal_selesai']);

            // Jika periode tidak valid (belum mulai atau sudah berakhir), paksa status_aktif jadi false
            if ($today < $startDate || $today > $endDate) {
                $statusAktif = false;
            }

            // Perbarui kuesioner
            $kuesioner->update([
                'judul' => $validated['judul'],
                'deskripsi' => $validated['deskripsi'],
                'icon' => $validated['icon'],
                'target_responden' => $validated['target_responden'],
                'tanggal_mulai' => $validated['tanggal_mulai'],
                'tanggal_selesai' => $validated['tanggal_selesai'],
                'status_aktif' => $statusAktif,
            ]);

            // Dapatkan ID pertanyaan yang ada
            $existingIds = $kuesioner->pertanyaan->pluck('id')->toArray();
            $submittedIds = [];

            // Perbarui atau buat pertanyaan
            foreach ($validated['pertanyaan'] as $index => $pertanyaanData) {
                $opsiJawaban = null;
                if ($pertanyaanData['jenis_pertanyaan'] === 'pilihan_ganda') {
                    $opsiJawaban = isset($pertanyaanData['opsi']) ? array_values(array_filter($pertanyaanData['opsi'])) : null;
                }

                $pertanyaanId = $pertanyaanData['id'] ?? null;

                if ($pertanyaanId && in_array($pertanyaanId, $existingIds)) {
                    // Perbarui pertanyaan yang ada
                    Pertanyaan::where('id', $pertanyaanId)->update([
                        'teks_pertanyaan' => $pertanyaanData['teks_pertanyaan'],
                        'jenis_pertanyaan' => $pertanyaanData['jenis_pertanyaan'],
                        'opsi_jawaban' => $opsiJawaban,
                        'urutan' => $index + 1,
                        'wajib_diisi' => isset($pertanyaanData['wajib_diisi']),
                        'kategori' => $pertanyaanData['kategori'] ?? null,
                    ]);
                    $submittedIds[] = $pertanyaanId;
                } else {
                    // Buat pertanyaan baru
                    $newPertanyaan = Pertanyaan::create([
                        'kuesioner_id' => $kuesioner->id,
                        'teks_pertanyaan' => $pertanyaanData['teks_pertanyaan'],
                        'jenis_pertanyaan' => $pertanyaanData['jenis_pertanyaan'],
                        'opsi_jawaban' => $opsiJawaban,
                        'urutan' => $index + 1,
                        'wajib_diisi' => isset($pertanyaanData['wajib_diisi']),
                        'kategori' => $pertanyaanData['kategori'] ?? null,
                    ]);
                    $submittedIds[] = $newPertanyaan->id;
                }
            }

            // Hapus pertanyaan yang dihapus
            $idsToDelete = array_diff($existingIds, $submittedIds);
            if (!empty($idsToDelete)) {
                Pertanyaan::whereIn('id', $idsToDelete)->delete();
            }

            DB::commit();

            return redirect()->route('dashboard.kuesioner.index')
                ->with('success', 'Kuesioner berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Hapus kuesioner yang ditentukan dari penyimpanan.
     * Hapus paksa dengan cascade - menghapus semua data terkait (tanggapan, pertanyaan)
     */
    public function destroy(Kuesioner $kuesioner): RedirectResponse
    {
        DB::beginTransaction();
        try {
            // Hitung tanggapan untuk logging
            $respondenCount = DB::table('jawaban')
                ->where('kuesioner_id', $kuesioner->id)
                ->distinct('responden_id')
                ->count('responden_id');

            $jawabanCount = DB::table('jawaban')
                ->where('kuesioner_id', $kuesioner->id)
                ->count();

            $pertanyaanCount = $kuesioner->pertanyaan()->count();

            // HAPUS PAKSA - Penghapusan cascade
            // 1. Hapus semua jawaban yang terkait dengan kuesioner ini
            DB::table('jawaban')
                ->where('kuesioner_id', $kuesioner->id)
                ->delete();

            // 2. Hapus semua pertanyaan
            $kuesioner->pertanyaan()->delete();

            // 3. Hapus kuesioner itu sendiri
            $kuesioner->delete();

            DB::commit();

            // Pesan sukses dengan detail
            $message = "Kuesioner '{$kuesioner->judul}' berhasil dihapus";
            if ($respondenCount > 0) {
                $message .= " beserta {$pertanyaanCount} pertanyaan dan {$jawabanCount} jawaban dari {$respondenCount} responden";
            } else {
                $message .= " beserta {$pertanyaanCount} pertanyaan";
            }

            return redirect()->route('dashboard.kuesioner.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat menghapus kuesioner: ' . $e->getMessage());
        }
    }

    /**
     * Duplikasi kuesioner yang ditentukan.
     */
    public function duplicate(Kuesioner $kuesioner): RedirectResponse
    {
        DB::beginTransaction();
        try {
            // Buat duplikat kuesioner
            $newKuesioner = $kuesioner->replicate();
            $newKuesioner->judul = $kuesioner->judul . ' (Copy)';
            $newKuesioner->status_aktif = false;
            $newKuesioner->dibuat_oleh = Auth::id();
            $newKuesioner->save();

            // Duplikasi pertanyaan
            foreach ($kuesioner->pertanyaan as $pertanyaan) {
                $newPertanyaan = $pertanyaan->replicate();
                $newPertanyaan->kuesioner_id = $newKuesioner->id;
                $newPertanyaan->save();
            }

            DB::commit();

            return redirect()->route('dashboard.kuesioner.edit', $newKuesioner)
                ->with('success', 'Kuesioner berhasil diduplikasi. Silakan edit sesuai kebutuhan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Toggle status kuesioner dengan validasi periode.
     */
    public function toggleStatus(Kuesioner $kuesioner): RedirectResponse
    {
        try {
            $newStatus = !$kuesioner->status_aktif;

            // Jika ingin mengaktifkan, validasi periode
            if ($newStatus) {
                $today = today();
                $inPeriod = $kuesioner->tanggal_mulai <= $today && $kuesioner->tanggal_selesai >= $today;

                if (!$inPeriod) {
                    if ($today < $kuesioner->tanggal_mulai) {
                        return back()->with('error', 'Tidak dapat mengaktifkan kuesioner. Periode belum dimulai.');
                    } else {
                        return back()->with('error', 'Tidak dapat mengaktifkan kuesioner. Periode sudah berakhir.');
                    }
                }
            }

            // Update status
            $kuesioner->update(['status_aktif' => $newStatus]);

            $message = $newStatus
                ? 'Kuesioner berhasil diaktifkan.'
                : 'Kuesioner berhasil dinonaktifkan.';

            return back()->with('success', $message);
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Ekspor kuesioner ke PDF atau Excel.
     */
    public function export(Request $request, Kuesioner $kuesioner)
    {
        $format = $request->query('format', 'pdf');

        // Untuk saat ini, return view untuk print
        $kuesioner->load([
            'admin',
            'pertanyaan' => function ($query) {
                $query->orderBy('urutan');
            }
        ]);

        return view('admin.kuesioner.export', [
            'kuesioner' => $kuesioner,
            'format' => $format
        ]);
    }
}
