@extends('layouts.admin')

@section('content')
<div class="px-4 sm:px-6 lg:px-8">
    <!-- Header Halaman -->
    <div class="sm:flex sm:items-center sm:justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Laporan Survei</h1>
            <p class="mt-2 text-sm text-gray-700">Ringkasan hasil survei dan statistik</p>
        </div>
    </div>

    <!-- Kartu Statistik -->
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

    <!-- Form Pencarian dan Filter -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6 p-4 sm:p-6">
        <form action="{{ route('dashboard.laporan.index') }}" method="GET">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- Input Pencarian -->
                <div class="lg:col-span-1">
                    <label for="cariSurvei" class="block text-sm font-medium text-gray-700 mb-2">Cari Kuesioner</label>
                    <input type="text" id="cariSurvei" name="cariSurvei" value="{{ request('cariSurvei') }}" 
                        class="block w-full rounded-md border-2 border-gray-200 focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5 px-3.5" 
                        placeholder="Cari judul atau deskripsi...">
                </div>

                <!-- Filter Target Responden -->
                <div class="lg:col-span-1">
                    <label for="target" class="block text-sm font-medium text-gray-700 mb-2">Target Responden</label>
                    <select id="target" name="target" 
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5 px-3.5">
                        <option value="">Semua Target</option>
                        <option value="mahasiswa" {{ request('target') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                        <option value="dosen" {{ request('target') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                        <option value="staff" {{ request('target') == 'staff' ? 'selected' : '' }}>Staff</option>
                        <option value="alumni" {{ request('target') == 'alumni' ? 'selected' : '' }}>Alumni</option>
                        <option value="stakeholder" {{ request('target') == 'stakeholder' ? 'selected' : '' }}>Stakeholder</option>
                    </select>
                </div>

                <!-- Group Tombol -->
                <div class="lg:col-span-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">&nbsp;</label>
                    <div class="flex gap-2">
                        <button type="submit" class="flex-1 rounded-md bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-700 shadow-sm cursor-pointer transition-colors">
                            <i class="fas fa-search mr-2"></i>
                            Cari
                        </button>
                        @if(request('cariSurvei') || request('target'))
                            <a href="{{ route('dashboard.laporan.index') }}" class="px-4 py-2.5 rounded-md border border-gray-300 text-sm font-semibold text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                                <i class="fas fa-redo mr-2"></i>
                                Reset
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Laporan Per Kuesioner -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-8 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-900">Laporan Per Kuesioner</h2>
            <span class="text-sm text-gray-500">Total: {{ $laporanKuesioner->total() }}</span>
        </div>
        
        <!-- Tampilan Tabel Desktop (hidden di mobile/tablet kecil) -->
        <div class="hidden md:block overflow-hidden">
            <div class="align-middle">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-700 tracking-wider">
                                Kuesioner
                            </th>
                            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-700 tracking-wider">
                                Target
                            </th>
                            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-700 tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-700 tracking-wider">
                                Responden
                            </th>
                            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-700 tracking-wider">
                                Pertanyaan
                            </th>
                            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-700 tracking-wider">
                                Periode
                            </th>
                            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-700 tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($laporanKuesioner as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="px-3 py-4">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 flex-shrink-0">
                                            <div class="h-10 w-10 rounded-lg bg-deep-sapphire-100 flex items-center justify-center">
                                                <i class="{{ $item->icon }} text-deep-sapphire-600"></i>
                                            </div>
                                        </div>
                                        <div class="ml-4 min-w-0">
                                            <div class="text-sm font-medium text-gray-900 break-words">{{ $item->judul }}</div>
                                            <div class="text-xs text-gray-500 break-words">{{ Str::limit($item->deskripsi, 50) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-3 py-4">
                                    <div class="flex flex-col gap-1">
                                        @php
                                            $targetArray = is_array($item->target_responden) ? $item->target_responden : [$item->target_responden];
                                        @endphp
                                        @foreach($targetArray as $target)
                                            <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-800 capitalize w-fit">
                                                {{ ucfirst($target) }}
                                            </span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-3 py-4">
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
                                <td class="px-3 py-4 text-sm text-gray-900">
                                    <div class="flex items-center">
                                        <i class="fas fa-users text-gray-400 mr-2"></i>
                                        <span class="font-semibold">{{ $item->responden_count }}</span>
                                        <span class="ml-1 text-gray-500">Responden</span>
                                    </div>
                                </td>
                                <td class="px-3 py-4 text-sm text-gray-900">
                                    <div class="flex items-center">
                                        <i class="fas fa-question-circle text-gray-400 mr-2"></i>
                                        <span class="font-semibold">{{ $item->pertanyaan_count }}</span>
                                        <span class="ml-1 text-gray-500">Pertanyaan</span>
                                    </div>
                                </td>
                                <td class="px-3 py-4 text-xs text-gray-500">
                                    <div class="flex flex-col">
                                        <span>{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }}</span>
                                        <span class="text-gray-300 text-[10px]">-</span>
                                        <span>{{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}</span>
                                    </div>
                                </td>
                                <td class="px-3 py-4 text-sm">
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
                                    <p class="text-xs">Coba ubah filter atau kata kunci pencarian</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tampilan Card Mobile (hanya di mobile/tablet kecil) -->
        <div class="md:hidden p-4 space-y-4">
            @forelse ($laporanKuesioner as $item)
                <div class="bg-gray-50 rounded-lg border border-gray-200 p-4">
                    <!-- Header with Icon and Title -->
                    <div class="flex items-start space-x-3 mb-3">
                        <div class="h-10 w-10 flex-shrink-0">
                            <div class="h-10 w-10 rounded-lg bg-deep-sapphire-100 flex items-center justify-center">
                                <i class="{{ $item->icon }} text-deep-sapphire-600"></i>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-sm font-semibold text-gray-900 break-words">{{ $item->judul }}</h3>
                            <p class="text-xs text-gray-500 break-words mt-1">{{ Str::limit($item->deskripsi, 60) }}</p>
                        </div>
                    </div>

                    <!-- Info Grid -->
                    <div class="space-y-2 mb-3">
                        <!-- Target -->
                        <div class="flex items-start">
                            <span class="text-xs text-gray-500 w-28 flex-shrink-0">Target:</span>
                            <div class="flex flex-wrap gap-1">
                                @php
                                    $targetArray = is_array($item->target_responden) ? $item->target_responden : [$item->target_responden];
                                @endphp
                                @foreach($targetArray as $target)
                                    <span class="inline-flex items-center rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-800 capitalize">
                                        {{ ucfirst($target) }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="flex items-center">
                            <span class="text-xs text-gray-500 w-28 flex-shrink-0">Status:</span>
                            @if ($item->status_aktif)
                                <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">
                                    Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800">
                                    Nonaktif
                                </span>
                            @endif
                        </div>

                        <!-- Responden -->
                        <div class="flex items-center">
                            <span class="text-xs text-gray-500 w-28 flex-shrink-0">Responden:</span>
                            <div class="flex items-center text-xs text-gray-900">
                                <i class="fas fa-users text-gray-400 mr-1.5"></i>
                                <span class="font-semibold">{{ $item->responden_count }} Responden</span>
                            </div>
                        </div>

                        <!-- Pertanyaan -->
                        <div class="flex items-center">
                            <span class="text-xs text-gray-500 w-28 flex-shrink-0">Pertanyaan:</span>
                            <div class="flex items-center text-xs text-gray-900">
                                <i class="fas fa-question-circle text-gray-400 mr-1.5"></i>
                                <span class="font-semibold">{{ $item->pertanyaan_count }} Pertanyaan</span>
                            </div>
                        </div>

                        <!-- Periode -->
                        <div class="flex items-start">
                            <span class="text-xs text-gray-500 w-28 flex-shrink-0">Periode:</span>
                            <div class="text-xs text-gray-900">
                                {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-end space-x-3 pt-3 border-t border-gray-200">
                        <a href="{{ route('dashboard.laporan.show', $item->id) }}" 
                            class="text-blue-600 hover:text-blue-800" title="Lihat Detail">
                            <i class="fas fa-eye text-lg"></i>
                        </a>
                        <a href="{{ route('dashboard.laporan.hasil', $item->id) }}" 
                            class="text-green-600 hover:text-green-800" title="Lihat Hasil">
                            <i class="fas fa-chart-bar text-lg"></i>
                        </a>
                        <a href="{{ route('dashboard.laporan.export', $item->id) }}" 
                            class="text-blue-600 hover:text-blue-800" title="Export CSV">
                            <i class="fas fa-download text-lg"></i>
                        </a>
                        <a href="{{ route('dashboard.laporan.print', $item->id) }}" 
                            target="_blank" class="text-gray-600 hover:text-gray-800" title="Print">
                            <i class="fas fa-print text-lg"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-lg border border-gray-200 p-8 text-center">
                    <i class="fas fa-inbox text-4xl text-gray-300 mb-2"></i>
                    <p class="font-medium text-gray-900">Tidak ada data laporan</p>
                    <p class="text-xs text-gray-500 mt-1">Coba ubah filter atau kata kunci pencarian</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($laporanKuesioner->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $laporanKuesioner->links('pagination.custom') }}
            </div>
        @endif
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
                            <div class="text-xs">
                                <span class="text-gray-600 block mb-1">Target:</span>
                                <div class="flex flex-col gap-1">
                                    @php
                                        $targetArrayCard = is_array($item->target_responden) ? $item->target_responden : [$item->target_responden];
                                    @endphp
                                    @foreach($targetArrayCard as $target)
                                        <span class="inline-flex items-center rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-800 capitalize w-fit">
                                            {{ ucfirst($target) }}
                                        </span>
                                    @endforeach
                                </div>
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
