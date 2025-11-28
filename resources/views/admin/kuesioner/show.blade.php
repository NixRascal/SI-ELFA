@extends('layouts.admin')

@section('content')
    <div class="px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('dashboard.kuesioner.index') }}" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-arrow-left text-xl"></i>
                    </a>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Detail Kuesioner</h1>
                        <p class="mt-1 text-sm text-gray-500">Informasi lengkap kuesioner dan pertanyaan</p>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
                    <form action="{{ route('dashboard.kuesioner.duplicate', $kuesioner) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                            class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 cursor-pointer">
                            <i class="fas fa-copy mr-2"></i>
                            Duplikasi
                        </button>
                    </form>
                    <a href="{{ route('dashboard.kuesioner.export', $kuesioner) }}?format=pdf" target="_blank"
                        class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 cursor-pointer">
                        <i class="fas fa-file-pdf mr-2 text-red-500"></i>
                        Export PDF
                    </a>
                    <a href="{{ route('dashboard.kuesioner.edit', $kuesioner) }}"
                        class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 cursor-pointer">
                        <i class="fas fa-edit mr-2"></i>
                        Edit
                    </a>
                    <a href="{{ route('dashboard.laporan.hasil', $kuesioner->id) }}"
                        class="inline-flex items-center justify-center px-4 py-2 border border-blue-600 rounded-md shadow-sm text-sm font-medium text-blue-600 bg-white hover:bg-blue-50 cursor-pointer">
                        <i class="fas fa-chart-bar mr-2"></i>
                        Lihat Hasil
                    </a>
                </div>
            </div>
        </div>

        <!-- Info Kuesioner -->
        <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl mb-6">
            <div class="p-6">
                <div class="flex flex-col sm:flex-row items-start gap-4">
                    <div class="h-16 w-16 flex-shrink-0 rounded-xl bg-blue-100 flex items-center justify-center">
                        <i class="{{ $kuesioner->icon }} text-blue-600 text-2xl"></i>
                    </div>
                    <div class="flex-1 min-w-0 w-full">
                        <h2 class="text-2xl font-bold text-gray-900">{{ $kuesioner->judul }}</h2>
                        @if($kuesioner->deskripsi)
                            <p class="mt-2 text-sm text-gray-600">{{ $kuesioner->deskripsi }}</p>
                        @endif

                        <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                            <!-- Status -->
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    @if($kuesioner->is_active)
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
                                </div>
                            </div>

                            <!-- Target Responden -->
                            <div>
                                <dt class="text-xs font-medium text-gray-500">Target Responden</dt>
                                <dd class="mt-1 text-sm font-semibold text-gray-900 capitalize">
                                    {{ implode(', ', array_map('ucfirst', (array) $kuesioner->target_responden)) }}
                                </dd>
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

                        <div class="mt-4 flex flex-wrap items-center gap-2 text-sm text-gray-500">
                            <i class="fas fa-user"></i>
                            <span>Dibuat oleh <span
                                    class="font-medium">{{ $kuesioner->admin->nama ?? 'Admin' }}</span></span>
                            <span class="hidden sm:inline">•</span>
                            <span>{{ $kuesioner->created_at->format('d M Y H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Pertanyaan List -->
        <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
            <div class="px-4 sm:px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">
                    Daftar Pertanyaan
                    <span class="ml-2 text-sm font-normal text-gray-500">({{ $kuesioner->pertanyaan->count() }}
                        pertanyaan)</span>
                </h3>
            </div>

            <div class="divide-y divide-gray-200">
                @forelse($kuesioner->pertanyaan as $index => $pertanyaan)
                    <div class="p-4 sm:p-6 hover:bg-gray-50">
                        <div class="flex items-start gap-3 sm:gap-4">
                            <!-- Nomor -->
                            <div class="flex-shrink-0">
                                <div class="h-10 w-10 rounded-lg bg-blue-100 flex items-center justify-center">
                                    <span class="text-blue-600 font-bold">{{ $index + 1 }}</span>
                                </div>
                            </div>

                            <!-- Pertanyaan Content -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-base font-medium text-gray-900 break-words">
                                            {{ $pertanyaan->teks_pertanyaan }}
                                        </p>

                                        <div class="mt-2 flex flex-wrap items-center gap-2">
                                            <!-- Daftar Pertanyaan -->
                                            <span
                                                class="inline-flex items-center rounded-md bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-800">
                                                @if($pertanyaan->jenis_pertanyaan === 'likert')
                                                    <i class="fas fa-star mr-1"></i> Skala Likert
                                                @elseif($pertanyaan->jenis_pertanyaan === 'pilihan_ganda')
                                                    <i class="fas fa-list mr-1"></i> Pilihan Ganda
                                                @else
                                                    <i class="fas fa-keyboard mr-1"></i> Isian
                                                @endif
                                            </span>

                                            @if($pertanyaan->kategori)
                                                <span
                                                    class="inline-flex items-center rounded-md bg-blue-50 px-2.5 py-0.5 text-xs font-medium text-blue-700">
                                                    <i class="fas fa-tag mr-1"></i> {{ $pertanyaan->kategori }}
                                                </span>
                                            @endif

                                            @if($pertanyaan->wajib_diisi)
                                                <span
                                                    class="inline-flex items-center rounded-md bg-red-50 px-2.5 py-0.5 text-xs font-medium text-red-700">
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
                                                        <li class="flex items-start text-sm text-gray-700">
                                                            <i class="fas fa-circle text-xs text-gray-400 mr-2 mt-1 flex-shrink-0"></i>
                                                            <span class="break-words">{{ $opsi }}</span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @elseif($pertanyaan->jenis_pertanyaan === 'likert')
                                            <div class="mt-3 pl-4 border-l-2 border-gray-200">
                                                <p class="text-xs font-medium text-gray-500 mb-2">Skala:</p>
                                                <div class="flex flex-wrap items-center gap-2">
                                                    @foreach(['Sangat Tidak Setuju', 'Tidak Setuju', 'Netral', 'Setuju', 'Sangat Setuju'] as $skalaIndex => $skala)
                                                        <span
                                                            class="inline-flex items-center px-2 py-1 rounded text-xs {{ $skalaIndex === 2 ? 'bg-yellow-100 text-yellow-800' : ($skalaIndex < 2 ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800') }}">
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

        <!-- Daftar Responden Terbaru -->
        <div class="bg-white shadow-sm ring-1 ring-900/5 sm:rounded-xl mt-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">
                    Daftar Responden Terbaru
                    <span class="ml-2 text-sm font-normal text-gray-500">({{ $respondenCount }} responden)</span>
                </h3>
            </div>

            <!-- Tampilan Tabel Desktop (hidden di mobile) -->
            <div class="hidden md:block overflow-x-auto">
                @if($responden->count() > 0)
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    No
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nama
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    NPM
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Email
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Jenis
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Waktu Pengisian
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Jumlah Jawaban
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($responden as $index => $r)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $responden->firstItem() + $index }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $r->nama }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $r->npm ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $r->email ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800 capitalize">
                                            {{ ucfirst($r->jenis_responden) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($r->waktu_selesai)->format('d M Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                        <span
                                            class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">
                                            {{ $r->jumlah_jawaban }} / {{ $kuesioner->pertanyaan->count() }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $responden->links('pagination.custom') }}
                    </div>
                @else
                    <div class="p-8 text-center">
                        <i class="fas fa-users text-4xl text-gray-300 mb-2"></i>
                        <p class="text-gray-500">Belum ada responden yang mengisi kuesioner ini</p>
                    </div>
                @endif
            </div>

            <!-- Tampilan Card Mobile (hanya di mobile) -->
            <div class="md:hidden p-4 space-y-4">
                @forelse($responden as $index => $r)
                    <div class="bg-gray-50 rounded-lg border border-gray-200 p-4">
                        <!-- Header -->
                        <div class="flex items-start gap-3 mb-3">
                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                                <span
                                    class="text-blue-700 font-semibold text-sm">{{ strtoupper(substr($r->nama, 0, 2)) }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-sm font-semibold text-gray-900">{{ $r->nama }}</h3>
                                <p class="text-xs text-gray-500">#{{ $responden->firstItem() + $index }}</p>
                            </div>
                            <span
                                class="inline-flex items-center rounded-full bg-blue-100 px-2 py-0.5 text-xs font-medium text-blue-800 capitalize flex-shrink-0">
                                {{ ucfirst($r->jenis_responden) }}
                            </span>
                        </div>

                        <!-- Details -->
                        <div class="space-y-2 text-sm">
                            @if($r->npm)
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-id-card text-gray-400 w-4 text-xs"></i>
                                    <span class="text-gray-700">NPM: {{ $r->npm }}</span>
                                </div>
                            @endif

                            <div class="flex items-center gap-2">
                                <i class="fas fa-envelope text-gray-400 w-4 text-xs"></i>
                                <span class="text-gray-600 break-all">{{ $r->email ?? '-' }}</span>
                            </div>

                            <div class="flex items-center gap-2">
                                <i class="far fa-clock text-gray-400 w-4 text-xs"></i>
                                <span
                                    class="text-gray-600">{{ \Carbon\Carbon::parse($r->waktu_selesai)->format('d M Y H:i') }}</span>
                            </div>

                            <div class="flex items-center gap-2">
                                <i class="fas fa-check-circle text-gray-400 w-4 text-xs"></i>
                                <span
                                    class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">
                                    {{ $r->jumlah_jawaban }} / {{ $kuesioner->pertanyaan->count() }} Jawaban
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="py-12 text-center text-gray-500">
                        <i class="fas fa-users text-4xl text-gray-300 mb-2"></i>
                        <p class="text-sm">Belum ada responden yang mengisi kuesioner ini</p>
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

        <!-- Header Halaman dengan Tombol Aksi -->
        <div class="mt-6 flex items-center justify-between">
            <a href="{{ route('dashboard.kuesioner.index') }}"
                class="text-sm font-medium text-gray-600 hover:text-gray-900">
                <i class="fas fa-arrow-left mr-1"></i>
                Kembali ke Daftar Kuesioner
            </a>
        </div>
    </div>
@endsection