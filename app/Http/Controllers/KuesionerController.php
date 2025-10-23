<?php

namespace App\Http\Controllers;

use App\Models\Kuesioner;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class KuesionerController extends Controller
{
    public function index(Request $request) {
        $cariSurvei = $request->query('cariSurvei');
        $today = Carbon::today()->toDateString();

        $kuesioner = Kuesioner::where('status_aktif', true)
            ->where('tanggal_mulai', '<=', $today)
            ->where('tanggal_selesai', '>=', $today)
            ->orderBy('tanggal_selesai');

        if ($cariSurvei !== '') {
            $kuesioner->where(function($query) use ($cariSurvei) {
                $query->where('judul', 'like', '%' . $cariSurvei . '%')
                    ->orWhere('deskripsi', 'like', '%' . $cariSurvei . '%');
            });
        }

        $kuesioner = $kuesioner->orderBy('tanggal_selesai')
            ->paginate(6)
            ->withQueryString();

        return view('survei/dashboard', compact('kuesioner'));
    }

    public function survey(Kuesioner $kuesioner) {
        return view('survei.fill', compact('kuesioner'));
    }
}
