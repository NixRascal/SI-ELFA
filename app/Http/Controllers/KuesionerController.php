<?php

namespace App\Http\Controllers;

use App\Models\Kuesioner;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class KuesionerController extends Controller
{
    public function index() {
        $kuesioner = Kuesioner::latest()->get(); // atau first()
        return view('welcome', ['kuesioner' => $kuesioner]);
    }


    public function show(Kuesioner $kuesioner) {
        if (!kuesioner->status_aktif) {
            return response()->json([
                'sukses' => false,
                'pesan' => "Kuesioner tidak tersedia",
            ], 404);
        }

        $kuesioner->load(['quesioner' => function ($query) {
            $query->orderBy('order');
        }]);

        return response()->json([
            'sukses' => true,
            'data' => $kuesioner,
            'pesan' => "Pengambilan Kuesioner Sukses"
        ]);
    }
}
