@extends('layouts.admin')

@section('content')
    <div class="px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <a href="{{ route('dashboard.laporan.index') }}"
                        class="text-sm text-gray-600 hover:text-gray-900 mb-2 inline-flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Laporan
                    </a>
                    <h1 class="text-2xl font-bold text-gray-900 mt-2">Hasil Analisis Survei</h1>
                    <p class="mt-1 text-sm text-gray-600">{{ $kuesioner->judul }}</p>
                </div>
                <div class="flex items-center space-x-2">
                    <a href="{{ route('dashboard.laporan.show', $kuesioner->id) }}"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700">
                        <i class="fas fa-eye mr-2"></i> Lihat Detail
                    </a>
                    <a href="{{ route('dashboard.laporan.export', $kuesioner->id) }}"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700">
                        <i class="fas fa-download mr-2"></i> Export CSV
                    </a>
                    <a href="{{ route('dashboard.laporan.print', $kuesioner->id) }}" target="_blank"
                        class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-md hover:bg-gray-700">
                        <i class="fas fa-print mr-2"></i> Print
                    </a>
                </div>
            </div>
        </div>

        <!-- Summary Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium text-gray-600">Total Responden</h3>
                    <p class="mt-1 text-3xl font-bold text-gray-900">{{ $totalResponden }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-600">Total Pertanyaan</h3>
                    <p class="mt-1 text-3xl font-bold text-gray-900">{{ $kuesioner->pertanyaan->count() }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-600">Target</h3>
                    <p class="mt-1">
                        <span
                            class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1.5 text-sm font-medium text-gray-800 capitalize">
                            {{ is_array($kuesioner->target_responden) ? implode(', ', array_map('ucfirst', $kuesioner->target_responden)) : ucfirst($kuesioner->target_responden) }}
                        </span>
                    </p>
                </div>
            </div>
        </div>

        <!-- AI Analysis Section -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6" id="ai-analysis-card">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-purple-50 to-indigo-50">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas fa-brain text-blue-600 text-xl mr-3"></i>
                        <div>
                            <h3 class="text-base font-semibold text-gray-900">Analisis AI</h3>
                            <p class="mt-0.5 text-sm text-gray-600">Insight otomatis menggunakan Google Gemini</p>
                        </div>
                    </div>
                    <button id="generate-ai-btn"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition-colors">
                        <i class="fas fa-magic mr-2"></i> Generate Analisis
                    </button>
                </div>
            </div>

            <div class="p-6">
                <div id="ai-loading" class="hidden text-center py-8">
                    <div class="inline-flex items-center">
                        <svg class="animate-spin h-8 w-8 text-blue-600 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <span class="text-gray-700 font-medium">Menganalisis data survei...</span>
                    </div>
                    <p class="mt-2 text-sm text-gray-500">Harap tunggu, ini mungkin memakan waktu beberapa detik</p>
                </div>

                <div id="ai-content" class="hidden">
                    <div class="prose prose-sm max-w-none overflow-y-auto ai-scroll-container" style="max-height: 600px;">
                        <div id="ai-result" class="text-gray-700 leading-relaxed pr-2"></div>
                    </div>
                </div>

                <div id="ai-error" class="hidden">
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                        <div class="flex">
                            <i class="fas fa-exclamation-triangle text-red-600 mr-3 mt-0.5"></i>
                            <div>
                                <h4 class="text-sm font-semibold text-red-800">Gagal Generate Analisis</h4>
                                <p class="mt-1 text-sm text-red-700" id="ai-error-message"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="ai-placeholder" class="text-center py-8">
                    <i class="fas fa-robot text-gray-300 text-5xl mb-3"></i>
                    <p class="text-gray-500">Klik tombol "Generate Analisis" untuk mendapatkan insight AI</p>
                    <p class="text-sm text-gray-400 mt-1">AI akan menganalisis pola, tren, dan memberikan rekomendasi</p>
                </div>
            </div>
        </div>

        <!-- Analisis per Pertanyaan -->
        @foreach($analisis as $index => $item)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h3 class="text-base font-semibold text-gray-900">
                                Pertanyaan {{ $index + 1 }}
                            </h3>
                            <p class="mt-1 text-sm text-gray-700">{{ $item['pertanyaan']->teks_pertanyaan }}</p>
                        </div>
                        <span
                            class="ml-4 inline-flex items-center rounded-full bg-deep-sapphire-100 px-3 py-1 text-xs font-medium text-deep-sapphire-800 capitalize">
                            {{ str_replace('_', ' ', $item['pertanyaan']->jenis_pertanyaan) }}
                        </span>
                    </div>
                </div>

                <div class="p-6">
                    @if($item['pertanyaan']->jenis_pertanyaan === 'likert')
                        <!-- Likert Scale Analysis -->
                        <div class="mb-4">
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-sm font-medium text-gray-600">Rata-rata:</span>
                                <span class="text-2xl font-bold text-deep-sapphire-600">{{ $item['rata_rata'] }}</span>
                            </div>

                            <div class="space-y-3">
                                @for($i = 1; $i <= 5; $i++)
                                    @php
                                        $data = $item['distribusi'][$i] ?? ['count' => 0, 'percentage' => 0];
                                    @endphp
                                    <div class="flex items-center">
                                        <span class="w-16 text-sm text-gray-600">Skala {{ $i }}</span>
                                        <div class="flex-1 mx-4">
                                            <div class="bg-gray-200 rounded-full h-6 overflow-hidden">
                                                <div class="bg-deep-sapphire-600 h-6 flex items-center justify-end px-2"
                                                    style="width: {{ $data['percentage'] }}%">
                                                    @if($data['percentage'] > 10)
                                                        <span class="text-xs text-white font-medium">{{ $data['percentage'] }}%</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <span class="w-20 text-sm text-gray-900 text-right">
                                            {{ $data['count'] }} orang
                                            @if($data['percentage'] <= 10 && $data['percentage'] > 0)
                                                ({{ $data['percentage'] }}%)
                                            @endif
                                        </span>
                                    </div>
                                @endfor
                            </div>
                        </div>

                    @elseif($item['pertanyaan']->jenis_pertanyaan === 'pilihan_ganda')
                        <!-- Multiple Choice Analysis -->
                        <div class="space-y-3">
                            @foreach($item['distribusi'] as $pilihan => $data)
                                <div class="flex items-center">
                                    <span class="w-1/4 text-sm text-gray-700 truncate">{{ $pilihan }}</span>
                                    <div class="flex-1 mx-4">
                                        <div class="bg-gray-200 rounded-full h-6 overflow-hidden">
                                            <div class="bg-green-600 h-6 flex items-center justify-end px-2"
                                                style="width: {{ $data['percentage'] }}%">
                                                @if($data['percentage'] > 10)
                                                    <span class="text-xs text-white font-medium">{{ $data['percentage'] }}%</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <span class="w-20 text-sm text-gray-900 text-right">
                                        {{ $data['count'] }} orang
                                        @if($data['percentage'] <= 10 && $data['percentage'] > 0)
                                            ({{ $data['percentage'] }}%)
                                        @endif
                                    </span>
                                </div>
                            @endforeach
                        </div>

                    @elseif($item['pertanyaan']->jenis_pertanyaan === 'isian')
                        <!-- Text Answers -->
                        <div class="space-y-2 max-h-96 overflow-y-auto">
                            @foreach($item['jawaban_text'] as $jawaban)
                                <div class="bg-gray-50 rounded-lg p-3 border border-gray-200">
                                    <p class="text-sm text-gray-700">{{ $jawaban }}</p>
                                </div>
                            @endforeach
                            @if($item['jawaban_text']->isEmpty())
                                <p class="text-sm text-gray-500 italic">Tidak ada jawaban</p>
                            @endif
                        </div>
                    @endif

                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <p class="text-xs text-gray-500">
                            <i class="fas fa-users mr-1"></i>
                            Total Jawaban: <span class="font-semibold">{{ $item['total_jawaban'] }}</span>
                        </p>
                    </div>
                </div>
            </div>
        @endforeach

        @if($analisis->isEmpty())
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 text-center">
                <i class="fas fa-chart-bar text-4xl text-gray-300 mb-2"></i>
                <p class="text-gray-500">Belum ada data untuk dianalisis</p>
            </div>
        @endif

        <!-- Daftar Responden -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mt-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">
                    Daftar Responden Terbaru
                    <span class="ml-2 text-sm font-normal text-gray-500">({{ $totalResponden }} responden)</span>
                </h3>
            </div>

            <div class="overflow-x-auto">
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
        </div>
    </div>

    <style>
        /* Custom scrollbar untuk AI content */
        .ai-scroll-container {
            scrollbar-width: thin;
            scrollbar-color: #2563eb #f3f4f6;
        }

        .ai-scroll-container::-webkit-scrollbar {
            width: 8px;
        }

        .ai-scroll-container::-webkit-scrollbar-track {
            background: #f3f4f6;
            border-radius: 4px;
        }

        .ai-scroll-container::-webkit-scrollbar-thumb {
            background: #2563eb;
            border-radius: 4px;
        }

        .ai-scroll-container::-webkit-scrollbar-thumb:hover {
            background: #1d4ed8;
        }

        /* Styling untuk markdown content */
        #ai-result h2 {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1f2937;
            margin-top: 1.5rem;
            margin-bottom: 0.75rem;
        }

        #ai-result h3 {
            font-size: 1.125rem;
            font-weight: 600;
            color: #374151;
            margin-top: 1.25rem;
            margin-bottom: 0.5rem;
        }

        #ai-result ul {
            list-style-type: disc;
            list-style-position: inside;
            margin-bottom: 1rem;
            padding-left: 0.5rem;
        }

        #ai-result li {
            margin-bottom: 0.5rem;
            line-height: 1.6;
        }

        #ai-result p {
            margin-bottom: 0.75rem;
            line-height: 1.6;
        }

        #ai-result strong {
            font-weight: 600;
            color: #1f2937;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const generateBtn = document.getElementById('generate-ai-btn');
            const aiLoading = document.getElementById('ai-loading');
            const aiContent = document.getElementById('ai-content');
            const aiResult = document.getElementById('ai-result');
            const aiError = document.getElementById('ai-error');
            const aiErrorMessage = document.getElementById('ai-error-message');
            const aiPlaceholder = document.getElementById('ai-placeholder');

            generateBtn.addEventListener('click', async function () {
                // Hide all sections
                aiPlaceholder.classList.add('hidden');
                aiContent.classList.add('hidden');
                aiError.classList.add('hidden');

                // Show loading
                aiLoading.classList.remove('hidden');
                generateBtn.disabled = true;
                generateBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Menganalisis...';

                try {
                    const response = await fetch('{{ route("dashboard.laporan.ai-analysis", $kuesioner->id) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });

                    const data = await response.json();

                    // Hide loading
                    aiLoading.classList.add('hidden');

                    if (data.success) {
                        // Show result
                        aiContent.classList.remove('hidden');

                        // Remove ** (bold markdown) but keep * (bullets/lists)
                        let cleanText = data.analysis.replace(/\*\*([^\*]+)\*\*/g, '$1');

                        // Convert * at start of line to bullet point •
                        cleanText = cleanText.replace(/^\* /gm, '• ');

                        // Display cleaned text
                        aiResult.innerHTML = `<pre class="whitespace-pre-wrap font-mono text-sm bg-gray-50 p-4 rounded-lg border border-gray-300">${cleanText}</pre>`;

                        // Update button
                        generateBtn.innerHTML = '<i class="fas fa-sync mr-2"></i> Generate Ulang';
                    } else {
                        // Show error
                        aiError.classList.remove('hidden');
                        aiErrorMessage.textContent = data.error || 'Terjadi kesalahan saat menganalisis data';
                    }

                } catch (error) {
                    // Hide loading
                    aiLoading.classList.add('hidden');

                    // Show error
                    aiError.classList.remove('hidden');
                    aiErrorMessage.textContent = 'Gagal terhubung ke server: ' + error.message;
                } finally {
                    generateBtn.disabled = false;
                    if (!aiContent.classList.contains('hidden')) {
                        generateBtn.innerHTML = '<i class="fas fa-sync mr-2"></i> Generate Ulang';
                    } else {
                        generateBtn.innerHTML = '<i class="fas fa-magic mr-2"></i> Generate Analisis';
                    }
                }
            });
        });
    </script>
@endsection