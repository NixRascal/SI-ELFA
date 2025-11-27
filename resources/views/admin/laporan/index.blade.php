@extends('layouts.admin')

@section('content')
<div class="px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="sm:flex sm:items-center sm:justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Laporan Survei</h1>
            <p class="mt-2 text-sm text-gray-700">Ringkasan hasil survei dan statistik</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <!-- Total Kuesioner -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Kuesioner</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900">{{ $totalKuesioner }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clipboard-list text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Responden -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Responden</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900">{{ $totalResponden }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Pertanyaan -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Pertanyaan</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900">{{ $totalPertanyaan }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-question-circle text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Kuesioner Aktif -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Kuesioner Aktif</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900">{{ $kuesionerAktif }}</p>
                </div>
                <div class="w-12 h-12 bg-deep-sapphire-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-deep-sapphire-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Laporan Per Kuesioner -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-8 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Laporan Per Kuesioner</h2>
        </div>
        <div class="overflow-x-auto">
            <div class="inline-block min-w-full align-middle">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 tracking-wider whitespace-nowrap">
                                Kuesioner
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 tracking-wider whitespace-nowrap">
                                Target
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 tracking-wider whitespace-nowrap">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 tracking-wider whitespace-nowrap">
                                Responden
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 tracking-wider whitespace-nowrap">
                                Pertanyaan
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 tracking-wider whitespace-nowrap">
                                Periode
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 tracking-wider whitespace-nowrap">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($laporanKuesioner as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center min-w-[250px]">
                                        <div class="h-10 w-10 flex-shrink-0">
                                            <div class="h-10 w-10 rounded-lg bg-deep-sapphire-100 flex items-center justify-center">
                                                <i class="{{ $item->icon }} text-deep-sapphire-600"></i>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $item->judul }}</div>
                                            <div class="text-xs text-gray-500">{{ Str::limit($item->deskripsi, 50) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-800 capitalize">
                                        {{ is_array($item->target_responden) ? implode(', ', array_map('ucfirst', $item->target_responden)) : ucfirst($item->target_responden) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($item->status_aktif)
                                        <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">
                                            Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800">
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <div class="flex items-center">
                                        <i class="fas fa-users text-gray-400 mr-2"></i>
                                        <span class="font-semibold">{{ $item->responden_count }}</span>
                                        <span class="ml-1 text-gray-500">Responden</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <div class="flex items-center">
                                        <i class="fas fa-question-circle text-gray-400 mr-2"></i>
                                        <span class="font-semibold">{{ $item->pertanyaan_count }}</span>
                                        <span class="ml-1 text-gray-500">Pertanyaan</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500">
                                    {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }} - 
                                    {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('dashboard.laporan.show', $item->id) }}" 
                                            class="text-blue-600 hover:text-blue-800" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('dashboard.laporan.hasil', $item->id) }}" 
                                            class="text-green-600 hover:text-green-800" title="Lihat Hasil">
                                            <i class="fas fa-chart-bar"></i>
                                        </a>
                                        <a href="{{ route('dashboard.laporan.export', $item->id) }}" 
                                            class="text-blue-600 hover:text-blue-800" title="Export CSV">
                                            <i class="fas fa-download"></i>
                                        </a>
                                        <a href="{{ route('dashboard.laporan.print', $item->id) }}" 
                                            target="_blank" class="text-gray-600 hover:text-gray-800" title="Print">
                                            <i class="fas fa-print"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-sm text-gray-500">
                                    <i class="fas fa-inbox text-4xl text-gray-300 mb-2"></i>
                                    <p class="font-medium">Tidak ada data laporan</p>
                                    <p class="text-xs">Belum ada kuesioner yang dibuat</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Ringkasan Cepat -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Ringkasan Cepat</h2>
            <p class="text-sm text-gray-600">Top 3 kuesioner dengan responden terbanyak</p>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse ($topKuesioner as $index => $item)
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full {{ $index === 0 ? 'bg-yellow-100' : ($index === 1 ? 'bg-gray-200' : 'bg-orange-100') }} flex items-center justify-center mr-3">
                                    <span class="text-base font-bold {{ $index === 0 ? 'text-yellow-600' : ($index === 1 ? 'text-gray-600' : 'text-orange-600') }}">
                                        #{{ $index + 1 }}
                                    </span>
                                </div>
                                <div class="h-10 w-10 rounded-lg bg-deep-sapphire-100 flex items-center justify-center">
                                    <i class="{{ $item->icon }} text-deep-sapphire-600"></i>
                                </div>
                            </div>
                        </div>
                        <h3 class="font-semibold text-gray-900 text-sm mb-2">{{ $item->judul }}</h3>
                        <div class="space-y-2">
                            <div class="flex items-center justify-between text-xs">
                                <span class="text-gray-600">Responden:</span>
                                <span class="font-semibold text-gray-900">{{ $item->responden_count }}</span>
                            </div>
                            <div class="flex items-center justify-between text-xs">
                                <span class="text-gray-600">Pertanyaan:</span>
                                <span class="font-semibold text-gray-900">{{ $item->pertanyaan_count }}</span>
                            </div>
                            <div class="flex items-center justify-between text-xs">
                                <span class="text-gray-600">Target:</span>
                                <span class="font-medium text-gray-900 capitalize">{{ is_array($item->target_responden) ? implode(', ', array_map('ucfirst', $item->target_responden)) : ucfirst($item->target_responden) }}</span>
                            </div>
                        </div>
                        <div class="mt-3 pt-3 border-t border-gray-200">
                            <a href="{{ route('dashboard.laporan.hasil', $item->id) }}" 
                                class="w-full inline-block text-center text-xs text-blue-600 hover:text-blue-800 font-medium">
                                <i class="fas fa-chart-line mr-1"></i> Lihat Detail
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-8 text-gray-500">
                        <i class="fas fa-chart-bar text-4xl text-gray-300 mb-2"></i>
                        <p class="text-sm">Belum ada data untuk ditampilkan</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
