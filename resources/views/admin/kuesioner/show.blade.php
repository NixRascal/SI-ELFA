@extends('layouts.admin')

@section('content')
<div class="px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('dashboard.kuesioner.index') }}" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-arrow-left text-xl"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Detail Kuesioner</h1>
                    <p class="mt-1 text-sm text-gray-500">Informasi lengkap kuesioner dan pertanyaan</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <form action="{{ route('dashboard.kuesioner.duplicate', $kuesioner) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 cursor-pointer">
                        <i class="fas fa-copy mr-2"></i>
                        Duplikasi
                    </button>
                </form>
                <a href="{{ route('dashboard.kuesioner.export', $kuesioner) }}?format=pdf" target="_blank" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 cursor-pointer">
                    <i class="fas fa-file-pdf mr-2 text-red-500"></i>
                    Export PDF
                </a>
                <a href="{{ route('dashboard.kuesioner.edit', $kuesioner) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 cursor-pointer">
                    <i class="fas fa-edit mr-2"></i>
                    Edit
                </a>
                <a href="{{ route('dashboard.laporan.hasil', $kuesioner->id) }}" class="inline-flex items-center px-4 py-2 border border-blue-600 rounded-md shadow-sm text-sm font-medium text-blue-600 bg-white hover:bg-blue-50 cursor-pointer">
                    <i class="fas fa-chart-bar mr-2"></i>
                    Lihat Hasil
                </a>
            </div>
        </div>
    </div>

    <!-- Kuesioner Info -->
    <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl mb-6">
        <div class="p-6">
            <div class="flex items-start space-x-4">
                <div class="h-16 w-16 flex-shrink-0 rounded-xl bg-blue-100 flex items-center justify-center">
                    <i class="{{ $kuesioner->icon }} text-blue-600 text-2xl"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <h2 class="text-2xl font-bold text-gray-900">{{ $kuesioner->judul }}</h2>
                    @if($kuesioner->deskripsi)
                        <p class="mt-2 text-sm text-gray-600">{{ $kuesioner->deskripsi }}</p>
                    @endif
                    
                    <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                        <!-- Status -->
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                @if($kuesioner->status_aktif)
                                    <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-sm font-medium text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i> Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-sm font-medium text-red-800">
                                        <i class="fas fa-times-circle mr-1"></i> Nonaktif
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Target Responden -->
                        <div>
                            <dt class="text-xs font-medium text-gray-500">Target Responden</dt>
                            <dd class="mt-1 text-sm font-semibold text-gray-900 capitalize">{{ $kuesioner->target_responden }}</dd>
                        </div>

                        <!-- Periode -->
                        <div>
                            <dt class="text-xs font-medium text-gray-500">Periode</dt>
                            <dd class="mt-1 text-sm font-semibold text-gray-900">
                                {{ \Carbon\Carbon::parse($kuesioner->tanggal_mulai)->format('d M Y') }} - 
                                {{ \Carbon\Carbon::parse($kuesioner->tanggal_selesai)->format('d M Y') }}
                            </dd>
                        </div>

                        <!-- Responden -->
                        <div>
                            <dt class="text-xs font-medium text-gray-500">Total Responden</dt>
                            <dd class="mt-1 text-sm font-semibold text-gray-900">
                                <i class="fas fa-users text-gray-400 mr-1"></i>
                                {{ $respondenCount }} Responden
                            </dd>
                        </div>
                    </div>

                    <div class="mt-4 flex items-center text-sm text-gray-500">
                        <i class="fas fa-user mr-2"></i>
                        Dibuat oleh <span class="font-medium ml-1">{{ $kuesioner->admin->nama ?? 'Admin' }}</span>
                        <span class="mx-2">•</span>
                        {{ $kuesioner->created_at->format('d M Y H:i') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pertanyaan List -->
    <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">
                Daftar Pertanyaan
                <span class="ml-2 text-sm font-normal text-gray-500">({{ $kuesioner->pertanyaan->count() }} pertanyaan)</span>
            </h3>
        </div>
        
        <div class="divide-y divide-gray-200">
            @forelse($kuesioner->pertanyaan as $index => $pertanyaan)
                <div class="p-6 hover:bg-gray-50">
                    <div class="flex items-start space-x-4">
                        <!-- Nomor -->
                        <div class="flex-shrink-0">
                            <div class="h-10 w-10 rounded-lg bg-blue-100 flex items-center justify-center">
                                <span class="text-blue-600 font-bold">{{ $index + 1 }}</span>
                            </div>
                        </div>

                        <!-- Pertanyaan Content -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <p class="text-base font-medium text-gray-900">{{ $pertanyaan->teks_pertanyaan }}</p>
                                    
                                    <div class="mt-2 flex items-center space-x-4">
                                        <!-- Jenis Pertanyaan -->
                                        <span class="inline-flex items-center rounded-md bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-800">
                                            @if($pertanyaan->jenis_pertanyaan === 'likert')
                                                <i class="fas fa-star mr-1"></i> Skala Likert
                                            @elseif($pertanyaan->jenis_pertanyaan === 'pilihan_ganda')
                                                <i class="fas fa-list mr-1"></i> Pilihan Ganda
                                            @else
                                                <i class="fas fa-keyboard mr-1"></i> Isian
                                            @endif
                                        </span>

                                        @if($pertanyaan->kategori)
                                            <span class="inline-flex items-center rounded-md bg-blue-50 px-2.5 py-0.5 text-xs font-medium text-blue-700">
                                                <i class="fas fa-tag mr-1"></i> {{ $pertanyaan->kategori }}
                                            </span>
                                        @endif

                                        @if($pertanyaan->wajib_diisi)
                                            <span class="inline-flex items-center rounded-md bg-red-50 px-2.5 py-0.5 text-xs font-medium text-red-700">
                                                <i class="fas fa-asterisk mr-1"></i> Wajib
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Opsi Jawaban -->
                                    @if($pertanyaan->jenis_pertanyaan === 'pilihan_ganda' && $pertanyaan->opsi_jawaban)
                                        <div class="mt-3 pl-4 border-l-2 border-gray-200">
                                            <p class="text-xs font-medium text-gray-500 mb-2">Opsi Jawaban:</p>
                                            <ul class="space-y-1.5">
                                                @foreach($pertanyaan->opsi_jawaban as $opsi)
                                                    <li class="flex items-center text-sm text-gray-700">
                                                        <i class="fas fa-circle text-xs text-gray-400 mr-2"></i>
                                                        {{ $opsi }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @elseif($pertanyaan->jenis_pertanyaan === 'likert')
                                        <div class="mt-3 pl-4 border-l-2 border-gray-200">
                                            <p class="text-xs font-medium text-gray-500 mb-2">Skala:</p>
                                            <div class="flex items-center space-x-2">
                                                @foreach(['Sangat Tidak Setuju', 'Tidak Setuju', 'Netral', 'Setuju', 'Sangat Setuju'] as $skalaIndex => $skala)
                                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs {{ $skalaIndex === 2 ? 'bg-yellow-100 text-yellow-800' : ($skalaIndex < 2 ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800') }}">
                                                        {{ $skalaIndex + 1 }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center">
                    <i class="fas fa-question-circle text-4xl text-gray-300 mb-2"></i>
                    <p class="text-gray-500">Belum ada pertanyaan</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="mt-6 flex items-center justify-between">
        <a href="{{ route('dashboard.kuesioner.index') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">
            <i class="fas fa-arrow-left mr-1"></i>
            Kembali ke Daftar Kuesioner
        </a>
    </div>
</div>
@endsection
