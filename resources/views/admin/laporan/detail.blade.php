@extends('layouts.admin')

@section('content')
    <div class="px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <a href="{{ route('dashboard.laporan.index') }}"
                        class="text-sm text-gray-600 hover:text-gray-900 mb-2 inline-flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Laporan
                    </a>
                    <h1 class="text-2xl font-bold text-gray-900 mt-2">Detail Laporan Kuesioner</h1>
                    <p class="mt-1 text-sm text-gray-600">{{ $kuesioner->judul }}</p>
                </div>
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
                    <a href="{{ route('dashboard.laporan.hasil', $kuesioner->id) }}"
                        class="inline-flex items-center justify-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700">
                        <i class="fas fa-chart-bar mr-2"></i> Lihat Hasil
                    </a>
                    <a href="{{ route('dashboard.laporan.export', $kuesioner->id) }}"
                        class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700">
                        <i class="fas fa-download mr-2"></i> Export CSV
                    </a>
                    <a href="{{ route('dashboard.laporan.print', $kuesioner->id) }}" target="_blank"
                        class="inline-flex items-center justify-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-md hover:bg-gray-700">
                        <i class="fas fa-print mr-2"></i> Print
                    </a>
                </div>
            </div>
        </div>

        <!-- Info Kuesioner Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Informasi Kuesioner</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div>
                        <label class="text-sm font-medium text-gray-600">Judul</label>
                        <p class="mt-1 text-base text-gray-900">{{ $kuesioner->judul }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-600">Target Responden</label>
                        <p class="mt-1">
                            <span
                                class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1 text-sm font-medium text-gray-800 capitalize">
                                {{ implode(', ', array_map('ucfirst', (array) $kuesioner->target_responden)) }}
                            </span>
                        </p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-600">Status</label>
                        <p class="mt-1">
                            @if ($kuesioner->is_active)
                                <span
                                    class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-sm font-medium text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i> Aktif
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-sm font-medium text-red-800">
                                    <i class="fas fa-times-circle mr-1"></i> Nonaktif
                                </span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-600">Periode</label>
                        <p class="mt-1 text-sm text-gray-900">
                            {{ \Carbon\Carbon::parse($kuesioner->tanggal_mulai)->format('d M Y') }} -
                            {{ \Carbon\Carbon::parse($kuesioner->tanggal_selesai)->format('d M Y') }}
                        </p>
                    </div>
                </div>
                @if($kuesioner->deskripsi)
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <label class="text-sm font-medium text-gray-600">Deskripsi</label>
                        <p class="mt-1 text-sm text-gray-700">{{ $kuesioner->deskripsi }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Kartu Statistik -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Responden</p>
                        <p class="mt-2 text-3xl font-bold text-gray-900">{{ $totalResponden }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-users text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Pertanyaan</p>
                        <p class="mt-2 text-3xl font-bold text-gray-900">{{ $kuesioner->pertanyaan->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-question-circle text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Jawaban</p>
                        <p class="mt-2 text-3xl font-bold text-gray-900">
                            {{ $totalResponden * $kuesioner->pertanyaan->count() }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-edit text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Daftar Responden -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Daftar Responden Terbaru</h2>
            </div>

            <!-- Tampilan Tabel Desktop -->(hidden on mobile) -->
            <div class="hidden md:block overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                No
                            </th>
                            <th scope="col"
                                class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                Nama
                            </th>
                            <th scope="col"
                                class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                Email
                            </th>
                            <th scope="col"
                                class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                NPM
                            </th>
                            <th scope="col"
                                class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                Fakultas
                            </th>
                            <th scope="col"
                                class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                Jurusan
                            </th>
                            <th scope="col"
                                class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                Jenis
                            </th>
                            <th scope="col"
                                class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                Waktu Isi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($responden as $index => $item)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-4 text-sm text-gray-900">
                                    {{ $responden->firstItem() + $index }}
                                </td>
                                <td class="px-4 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $item->nama }}</div>
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-600 break-all">
                                    {{ $item->email }}
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-600">
                                    {{ $item->npm ?: '-' }}
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-600">
                                    {{ $item->fakultas }}
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-600">
                                    {{ $item->jurusan }}
                                </td>
                                <td class="px-4 py-4">
                                    <span
                                        class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-800 capitalize">
                                        {{ $item->jenis_responden }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-xs text-gray-500">
                                    {{ \Carbon\Carbon::parse($item->waktu_isi)->format('d M Y H:i') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-8 text-center text-sm text-gray-500">
                                    <i class="fas fa-inbox text-4xl text-gray-300 mb-2"></i>
                                    <p class="font-medium">Belum ada responden</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                @if($responden->count() > 0)
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $responden->links('pagination.custom') }}
                    </div>
                @endif
            </div>

            <!-- Tampilan Card Mobile -->
            <div class="md:hidden p-4 space-y-4">
                @forelse ($responden as $index => $item)
                    <div class="bg-gray-50 rounded-lg border border-gray-200 p-4">
                        <!-- Header -->
                        <div class="flex items-start gap-3 mb-3">
                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                                <span
                                    class="text-blue-700 font-semibold text-sm">{{ strtoupper(substr($item->nama, 0, 2)) }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-sm font-semibold text-gray-900">{{ $item->nama }}</h3>
                                <p class="text-xs text-gray-500">#{{ $responden->firstItem() + $index }}</p>
                            </div>
                            <span
                                class="inline-flex items-center rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-800 capitalize flex-shrink-0">
                                {{ $item->jenis_responden }}
                            </span>
                        </div>

                        <!-- Details -->
                        <div class="space-y-2 text-sm">
                            @if($item->npm)
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-id-card text-gray-400 w-4 text-xs"></i>
                                    <span class="text-gray-700">NPM: {{ $item->npm }}</span>
                                </div>
                            @endif

                            <div class="flex items-center gap-2">
                                <i class="fas fa-envelope text-gray-400 w-4 text-xs"></i>
                                <span class="text-gray-600 break-all">{{ $item->email }}</span>
                            </div>

                            <div class="flex items-center gap-2">
                                <i class="fas fa-university text-gray-400 w-4 text-xs"></i>
                                <span class="text-gray-600">{{ $item->fakultas }}</span>
                            </div>

                            <div class="flex items-center gap-2">
                                <i class="fas fa-graduation-cap text-gray-400 w-4 text-xs"></i>
                                <span class="text-gray-600">{{ $item->jurusan }}</span>
                            </div>

                            <div class="flex items-center gap-2">
                                <i class="far fa-clock text-gray-400 w-4 text-xs"></i>
                                <span
                                    class="text-gray-500">{{ \Carbon\Carbon::parse($item->waktu_isi)->format('d M Y H:i') }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="py-12 text-center text-gray-500">
                        <i class="fas fa-inbox text-4xl text-gray-300 mb-2"></i>
                        <p class="text-sm font-medium">Belum ada responden</p>
                    </div>
                @endforelse

                <!-- Pagination -->
                @if($responden->count() > 0)
                    <div class="bg-white rounded-lg border border-gray-200 px-4 py-3">
                        {{ $responden->links('pagination.custom') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection