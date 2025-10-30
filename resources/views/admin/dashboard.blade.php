@extends('layouts.admin')

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-3">
                Selamat Datang, {{ Auth::user()->nama }}!
            </h1>
            <p class="text-gray-600 mt-2">Berikut ringkasan aktivitas sistem evaluasi fakultas Anda</p>
        </div>
        <a href="{{ route('dashboard.kuesioner.create') }}" class="hidden md:flex items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all shadow-sm">
            <i class="fas fa-plus"></i>
            <span class="font-semibold">Buat Kuesioner</span>
        </a>
    </div>
</div>

                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Total Kuesioner -->
                    <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200 hover:shadow-md transition-all">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center">
                                <i class="fas fa-clipboard-list text-blue-600 text-xl"></i>
                            </div>
                        </div>
                        <div class="text-3xl font-bold text-gray-800 mb-1">{{ $totalKuesioner }}</div>
                        <p class="text-gray-600 text-sm font-medium">Total Kuesioner</p>
                    </div>

                    <!-- Kuesioner Aktif -->
                    <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200 hover:shadow-md transition-all">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-green-50 rounded-lg flex items-center justify-center">
                                <i class="fas fa-check-circle text-green-600 text-xl"></i>
                            </div>
                        </div>
                        <div class="text-3xl font-bold text-gray-800 mb-1">{{ $kuesionerAktif }}</div>
                        <p class="text-gray-600 text-sm font-medium">Kuesioner Aktif</p>
                        @if($kuesionerAktif > 0)
                        <div class="mt-2 flex items-center text-xs text-green-600">
                            <i class="fas fa-circle text-green-500 text-[6px] mr-1.5"></i>
                            <span>Sedang Berjalan</span>
                        </div>
                        @endif
                    </div>

                    <!-- Total Responden -->
                    <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200 hover:shadow-md transition-all">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-indigo-50 rounded-lg flex items-center justify-center">
                                <i class="fas fa-users text-indigo-600 text-xl"></i>
                            </div>
                        </div>
                        <div class="text-3xl font-bold text-gray-800 mb-1">{{ number_format($totalResponden) }}</div>
                        <p class="text-gray-600 text-sm font-medium">Total Responden</p>
                    </div>

                    <!-- Total Jawaban -->
                    <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200 hover:shadow-md transition-all">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-comments text-gray-700 text-xl"></i>
                            </div>
                        </div>
                        <div class="text-3xl font-bold text-gray-800 mb-1">{{ number_format($totalJawaban) }}</div>
                        <p class="text-gray-600 text-sm font-medium">Total Jawaban</p>
                    </div>
                </div>

                <!-- Content Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                    <!-- Kuesioner Terbaru -->
                    <div class="lg:col-span-2 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                                <i class="fas fa-clipboard-list text-gray-700"></i>
                                Kuesioner Terbaru
                            </h2>
                            <a href="#" class="text-blue-600 hover:text-blue-700 font-medium text-sm flex items-center gap-1">
                                Lihat Semua
                                <i class="fas fa-arrow-right text-xs"></i>
                            </a>
                        </div>
                        
                        <div class="space-y-3">
                            @forelse($recentQuestionnaires as $index => $kuesioner)
                            <!-- Kuesioner Item {{ $index + 1 }} -->
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 hover:border-blue-300 hover:bg-blue-50/50 transition-all">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-2">
                                            <h3 class="font-semibold text-gray-800">{{ $kuesioner->judul }}</h3>
                                        </div>
                                        <p class="text-sm text-gray-600 mb-3">{{ \Str::limit($kuesioner->deskripsi, 100) }}</p>
                                        <div class="flex items-center gap-4 text-xs text-gray-500">
                                            <span class="flex items-center gap-1">
                                                <i class="fas fa-user text-gray-400"></i>
                                                <span>{{ $kuesioner->responden_count }} Responden</span>
                                            </span>
                                            <span class="flex items-center gap-1">
                                                <i class="fas fa-question-circle text-gray-400"></i>
                                                <span>{{ $kuesioner->pertanyaan_count }} Pertanyaan</span>
                                            </span>
                                            <span class="flex items-center gap-1">
                                                <i class="fas fa-clock text-gray-400"></i>
                                                <span>@if($kuesioner->is_active) Aktif hingga @else Selesai @endif {{ $kuesioner->tanggal_selesai->format('d M Y') }}</span>
                                            </span>
                                        </div>
                                    </div>
                                    @if($kuesioner->is_active)
                                    <span class="ml-4 px-3 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-md whitespace-nowrap">
                                        Aktif
                                    </span>
                                    @else
                                    <span class="ml-4 px-3 py-1 bg-gray-200 text-gray-600 text-xs font-medium rounded-md whitespace-nowrap">
                                        Selesai
                                    </span>
                                    @endif
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-12 text-gray-500">
                                <i class="fas fa-inbox text-3xl block mb-2 text-gray-400"></i>
                                <p class="text-sm">Belum ada kuesioner</p>
                            </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Statistik Responden -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-6 flex items-center gap-2">
                            <i class="fas fa-chart-pie text-gray-700"></i>
                            Distribusi Responden
                        </h2>
                        
                        <div class="space-y-4">
                            <!-- Mahasiswa -->
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-user-graduate text-blue-600 text-sm"></i>
                                        <span class="text-sm font-medium text-gray-700">Mahasiswa</span>
                                    </div>
                                    <span class="text-sm font-semibold text-gray-800">{{ $respondenStats['mahasiswa']['count'] }} ({{ $respondenStats['mahasiswa']['percentage'] }}%)</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                                    <div class="bg-blue-600 h-2 rounded-full transition-all duration-500" style="width: {{ $respondenStats['mahasiswa']['percentage'] }}%"></div>
                                </div>
                            </div>

                            <!-- Dosen -->
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-chalkboard-teacher text-green-600 text-sm"></i>
                                        <span class="text-sm font-medium text-gray-700">Dosen</span>
                                    </div>
                                    <span class="text-sm font-semibold text-gray-800">{{ $respondenStats['dosen']['count'] }} ({{ $respondenStats['dosen']['percentage'] }}%)</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                                    <div class="bg-green-600 h-2 rounded-full transition-all duration-500" style="width: {{ $respondenStats['dosen']['percentage'] }}%"></div>
                                </div>
                            </div>

                            <!-- Tenaga Kependidikan/Staff -->
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-user-tie text-indigo-600 text-sm"></i>
                                        <span class="text-sm font-medium text-gray-700">Staff</span>
                                    </div>
                                    <span class="text-sm font-semibold text-gray-800">{{ $respondenStats['staff']['count'] }} ({{ $respondenStats['staff']['percentage'] }}%)</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                                    <div class="bg-indigo-600 h-2 rounded-full transition-all duration-500" style="width: {{ $respondenStats['staff']['percentage'] }}%"></div>
                                </div>
                            </div>

                            <!-- Alumni -->
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-user-check text-orange-600 text-sm"></i>
                                        <span class="text-sm font-medium text-gray-700">Alumni</span>
                                    </div>
                                    <span class="text-sm font-semibold text-gray-800">{{ $respondenStats['alumni']['count'] }} ({{ $respondenStats['alumni']['percentage'] }}%)</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                                    <div class="bg-orange-600 h-2 rounded-full transition-all duration-500" style="width: {{ $respondenStats['alumni']['percentage'] }}%"></div>
                                </div>
                            </div>

                            <!-- Stakeholder -->
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-briefcase text-gray-600 text-sm"></i>
                                        <span class="text-sm font-medium text-gray-700">Stakeholder</span>
                                    </div>
                                    <span class="text-sm font-semibold text-gray-800">{{ $respondenStats['stakeholder']['count'] }} ({{ $respondenStats['stakeholder']['percentage'] }}%)</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                                    <div class="bg-gray-700 h-2 rounded-full transition-all duration-500" style="width: {{ $respondenStats['stakeholder']['percentage'] }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Responden Terbaru -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                            <i class="fas fa-history text-gray-700"></i>
                            Aktivitas Terbaru
                        </h2>
                        <a href="#" class="text-blue-600 hover:text-blue-700 font-medium text-sm flex items-center gap-1">
                            Lihat Semua
                            <i class="fas fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-200">
                                    <th class="text-left py-3 px-4 font-semibold text-gray-700 text-sm">Responden</th>
                                    <th class="text-left py-3 px-4 font-semibold text-gray-700 text-sm">Email</th>
                                    <th class="text-left py-3 px-4 font-semibold text-gray-700 text-sm">Jenis</th>
                                    <th class="text-left py-3 px-4 font-semibold text-gray-700 text-sm">Kuesioner</th>
                                    <th class="text-left py-3 px-4 font-semibold text-gray-700 text-sm">Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentRespondents as $responden)
                                <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                                    <td class="py-3 px-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 
                                                @if($responden->jenis_responden == 'mahasiswa') bg-blue-100
                                                @elseif($responden->jenis_responden == 'dosen') bg-green-100
                                                @elseif($responden->jenis_responden == 'staff') bg-indigo-100
                                                @elseif($responden->jenis_responden == 'alumni') bg-orange-100
                                                @elseif($responden->jenis_responden == 'stakeholder') bg-gray-200
                                                @else bg-gray-100
                                                @endif
                                                rounded-full flex items-center justify-center 
                                                @if($responden->jenis_responden == 'mahasiswa') text-blue-700
                                                @elseif($responden->jenis_responden == 'dosen') text-green-700
                                                @elseif($responden->jenis_responden == 'staff') text-indigo-700
                                                @elseif($responden->jenis_responden == 'alumni') text-orange-700
                                                @elseif($responden->jenis_responden == 'stakeholder') text-gray-700
                                                @else text-gray-700
                                                @endif
                                                font-semibold text-sm">
                                                {{ strtoupper(substr($responden->nama, 0, 2)) }}
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-800 text-sm">{{ $responden->nama }}</p>
                                                @if($responden->npm)
                                                <p class="text-xs text-gray-500">{{ $responden->npm }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 text-gray-600 text-sm">{{ $responden->email ?? '-' }}</td>
                                    <td class="py-3 px-4">
                                        <span class="px-2.5 py-1 
                                            @if($responden->jenis_responden == 'mahasiswa') bg-blue-100 text-blue-700
                                            @elseif($responden->jenis_responden == 'dosen') bg-green-100 text-green-700
                                            @elseif($responden->jenis_responden == 'staff') bg-indigo-100 text-indigo-700
                                            @elseif($responden->jenis_responden == 'alumni') bg-orange-100 text-orange-700
                                            @elseif($responden->jenis_responden == 'stakeholder') bg-gray-200 text-gray-700
                                            @else bg-gray-100 text-gray-700
                                            @endif
                                            text-xs font-medium rounded">
                                            {{ ucfirst($responden->jenis_responden) }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-gray-700 text-sm">{{ \Str::limit($responden->kuesioner_judul, 30) }}</td>
                                    <td class="py-3 px-4 text-gray-500 text-sm">
                                        <div class="flex items-center gap-1">
                                            <i class="far fa-clock text-gray-400"></i>
                                            <span>{{ $responden->waktu_pengisian ? $responden->waktu_pengisian->diffForHumans() : '-' }}</span>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="py-12 text-center text-gray-500">
                                        <i class="fas fa-inbox text-3xl block mb-2 text-gray-400"></i>
                                        <p class="text-sm">Belum ada aktivitas responden</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
@endsection