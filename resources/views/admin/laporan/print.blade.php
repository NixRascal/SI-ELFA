<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan - {{ $kuesioner->judul }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            font-size: 11px;
            line-height: 1.6;
            color: #1f2937;
            padding: 15px;
        }
        
        /* Cover Page */
        .cover-page {
            text-align: center;
            padding: 80px 40px;
            page-break-after: always;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px;
            margin-bottom: 30px;
        }
        
        .cover-page h1 {
            font-size: 32px;
            margin-bottom: 20px;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        
        .cover-page .subtitle {
            font-size: 20px;
            margin-bottom: 40px;
            opacity: 0.95;
        }
        
        .cover-info {
            background: rgba(255,255,255,0.15);
            padding: 25px;
            border-radius: 8px;
            backdrop-filter: blur(10px);
            margin: 40px auto;
            max-width: 500px;
        }
        
        .cover-info-item {
            margin: 15px 0;
            font-size: 14px;
        }
        
        .cover-info-label {
            font-weight: 600;
            display: inline-block;
            width: 150px;
        }
        
        /* Header */
        .page-header {
            text-align: center;
            margin-bottom: 30px;
            padding: 25px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 8px;
        }
        
        .page-header h1 {
            font-size: 22px;
            margin-bottom: 8px;
            font-weight: 700;
        }
        
        .page-header .subtitle {
            font-size: 15px;
            opacity: 0.9;
            margin-bottom: 5px;
        }
        
        .page-header .period {
            font-size: 12px;
            opacity: 0.85;
            margin-top: 8px;
        }
        
        /* Executive Summary */
        .executive-summary {
            background: #f0f9ff;
            border-left: 4px solid #3b82f6;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 5px;
            page-break-inside: avoid;
        }
        
        .executive-summary h2 {
            color: #1e40af;
            font-size: 16px;
            margin-bottom: 15px;
            font-weight: 700;
        }
        
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-top: 15px;
        }
        
        .summary-item {
            background: white;
            padding: 12px;
            border-radius: 5px;
            border: 1px solid #bfdbfe;
        }
        
        .summary-label {
            font-size: 10px;
            color: #6b7280;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        
        .summary-value {
            font-size: 14px;
            font-weight: 700;
            color: #1e40af;
            margin-top: 4px;
        }
        
        /* Info Section */
        .info-section {
            margin-bottom: 25px;
            background: #f9fafb;
            padding: 18px;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }
        
        .info-section h3 {
            font-size: 14px;
            color: #374151;
            margin-bottom: 12px;
            font-weight: 700;
            border-bottom: 2px solid #d1d5db;
            padding-bottom: 6px;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }
        
        .info-item {
            display: flex;
            flex-direction: column;
        }
        
        .info-label {
            font-weight: 600;
            color: #6b7280;
            font-size: 10px;
            text-transform: uppercase;
            margin-bottom: 4px;
        }
        
        .info-value {
            color: #1f2937;
            font-size: 12px;
            font-weight: 500;
        }
        
        /* Statistics Cards */
        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 25px;
        }
        
        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 18px 12px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .stat-card.green {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }
        
        .stat-card.blue {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        }
        
        .stat-card.orange {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        }
        
        .stat-label {
            font-size: 9px;
            text-transform: uppercase;
            opacity: 0.9;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        
        .stat-value {
            font-size: 28px;
            font-weight: 700;
            margin-top: 6px;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
        }
        
        .stat-subtext {
            font-size: 9px;
            opacity: 0.85;
            margin-top: 4px;
        }
        
        /* Question Section */
        .question-section {
            margin-bottom: 25px;
            page-break-inside: avoid;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            overflow: hidden;
        }
        
        .question-header {
            background: linear-gradient(to right, #f3f4f6, #e5e7eb);
            padding: 12px 18px;
            border-bottom: 2px solid #d1d5db;
        }
        
        .question-title {
            font-weight: 700;
            font-size: 13px;
            margin-bottom: 6px;
            color: #111827;
        }
        
        .question-text {
            color: #4b5563;
            font-size: 12px;
            line-height: 1.5;
        }
        
        .question-meta {
            display: flex;
            gap: 8px;
            margin-top: 8px;
            flex-wrap: wrap;
        }
        
        .question-type {
            display: inline-flex;
            align-items: center;
            background: #6366f1;
            color: white;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 9px;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .question-category {
            display: inline-flex;
            align-items: center;
            background: #10b981;
            color: white;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 9px;
            font-weight: 600;
        }
        
        .question-required {
            display: inline-flex;
            align-items: center;
            background: #ef4444;
            color: white;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 9px;
            font-weight: 600;
        }
        
        .question-content {
            padding: 18px;
            background: white;
        }
        
        /* Score Display */
        .score-display {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 18px;
            text-align: center;
        }
        
        .score-label {
            font-size: 11px;
            opacity: 0.9;
            margin-bottom: 5px;
        }
        
        .score-value {
            font-size: 32px;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }
        
        .score-interpretation {
            font-size: 10px;
            margin-top: 8px;
            opacity: 0.95;
            font-weight: 600;
        }
        
        /* Bar Chart */
        .bar-chart {
            margin-bottom: 15px;
        }
        
        .bar-item {
            margin-bottom: 10px;
        }
        
        .bar-label {
            display: inline-block;
            width: 90px;
            font-size: 11px;
            font-weight: 600;
            color: #374151;
        }
        
        .bar-container {
            display: inline-block;
            width: calc(100% - 200px);
            height: 24px;
            background: #f3f4f6;
            border-radius: 4px;
            vertical-align: middle;
            position: relative;
            overflow: hidden;
            border: 1px solid #e5e7eb;
        }
        
        .bar-fill {
            height: 100%;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding-right: 8px;
            transition: width 0.3s ease;
        }
        
        .bar-fill.green {
            background: linear-gradient(90deg, #10b981 0%, #059669 100%);
        }
        
        .bar-fill.red {
            background: linear-gradient(90deg, #ef4444 0%, #dc2626 100%);
        }
        
        .bar-fill.yellow {
            background: linear-gradient(90deg, #f59e0b 0%, #d97706 100%);
        }
        
        .bar-percentage {
            color: white;
            font-size: 10px;
            font-weight: 700;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
        }
        
        .bar-count {
            display: inline-block;
            width: 100px;
            text-align: right;
            font-size: 11px;
            margin-left: 10px;
            font-weight: 600;
            color: #374151;
        }
        
        /* Text Answers */
        .text-answer {
            background: #f9fafb;
            padding: 10px 14px;
            margin-bottom: 6px;
            border-radius: 6px;
            font-size: 11px;
            border-left: 3px solid #6366f1;
            line-height: 1.6;
        }
        
        .answer-count {
            margin-top: 12px;
            padding: 12px;
            background: #eff6ff;
            border-radius: 6px;
            border-left: 3px solid #3b82f6;
        }
        
        .answer-count strong {
            color: #1e40af;
            font-size: 12px;
        }
        
        /* Insights Box */
        .insights-box {
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 12px 15px;
            margin-top: 15px;
            border-radius: 5px;
            font-size: 10px;
        }
        
        .insights-box strong {
            color: #92400e;
            display: block;
            margin-bottom: 5px;
            font-size: 11px;
        }
        
        /* Footer */
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #d1d5db;
            text-align: center;
            font-size: 10px;
            color: #6b7280;
        }
        
        .footer p {
            margin: 5px 0;
        }
        
        .footer strong {
            color: #374151;
        }
        
        /* Page Break */
        .page-break {
            page-break-after: always;
        }
        
        /* Print Styles */
        @media print {
            body {
                padding: 0;
            }
            
            .question-section, .executive-summary, .info-section {
                page-break-inside: avoid;
            }
            
            .cover-page {
                page-break-after: always;
            }
            
            @page {
                margin: 1.5cm;
                size: A4;
            }
        }
    </style>
</head>
<body>
    {{-- Cover Page --}}
    <div class="cover-page">
        <h1>📊 LAPORAN HASIL SURVEI</h1>
        <div class="subtitle">{{ $kuesioner->judul }}</div>
        
        <div class="cover-info">
            <div class="cover-info-item">
                <span class="cover-info-label">Periode Survei:</span>
                <div style="margin-top: 5px;">
                    {{ \Carbon\Carbon::parse($kuesioner->tanggal_mulai)->format('d F Y') }} - 
                    {{ \Carbon\Carbon::parse($kuesioner->tanggal_selesai)->format('d F Y') }}
                </div>
            </div>
            <div class="cover-info-item">
                <span class="cover-info-label">Total Responden:</span>
                <div style="font-size: 24px; font-weight: 700; margin-top: 5px;">{{ $totalResponden }} Orang</div>
            </div>
            <div class="cover-info-item">
                <span class="cover-info-label">Target Responden:</span>
                <div style="margin-top: 5px;">{{ is_array($kuesioner->target_responden) ? implode(', ', array_map('ucfirst', $kuesioner->target_responden)) : ucfirst($kuesioner->target_responden) }}</div>
            </div>
            <div class="cover-info-item" style="margin-top: 30px; font-size: 12px;">
                Laporan dicetak pada<br>
                <strong>{{ now()->format('d F Y, H:i') }} WIB</strong>
            </div>
        </div>
        
        <div style="margin-top: 50px; font-size: 13px; opacity: 0.9;">
            SI-ELFA - Sistem Informasi Evaluasi Layanan Fakultas Akademik
        </div>
    </div>

    {{-- Page Header --}}
    <div class="page-header">
        <h1>{{ $kuesioner->judul }}</h1>
        <div class="subtitle">Analisis Komprehensif Hasil Survei</div>
        <div class="period">
            Periode: {{ \Carbon\Carbon::parse($kuesioner->tanggal_mulai)->format('d M Y') }} - 
            {{ \Carbon\Carbon::parse($kuesioner->tanggal_selesai)->format('d M Y') }}
        </div>
    </div>

    @php
        // Calculate statistics
        $likertQuestions = collect($analisis)->filter(fn($item) => $item['pertanyaan']->jenis_pertanyaan === 'likert');
        $avgScore = $likertQuestions->avg('rata_rata');
        $responseRate = $totalResponden > 0 ? 100 : 0;
        $completionRate = $totalResponden > 0 ? round(($totalResponden * $kuesioner->pertanyaan->count()) / ($totalResponden * $kuesioner->pertanyaan->count()) * 100, 1) : 0;
    @endphp

    {{-- Executive Summary --}}
    <div class="executive-summary">
        <h2>📋 Ringkasan Eksekutif</h2>
        <p style="color: #374151; margin-bottom: 10px;">
            Survei ini telah diisi oleh <strong>{{ $totalResponden }} responden</strong> dengan total 
            <strong>{{ $kuesioner->pertanyaan->count() }} pertanyaan</strong>. 
            @if($avgScore)
                Rata-rata kepuasan keseluruhan mencapai <strong>{{ number_format($avgScore, 2) }}/5.0</strong>
                @if($avgScore >= 4)
                    (Sangat Baik)
                @elseif($avgScore >= 3.5)
                    (Baik)
                @elseif($avgScore >= 3)
                    (Cukup Baik)
                @else
                    (Perlu Perbaikan)
                @endif
            @endif
        </p>
        
        <div class="summary-grid">
            <div class="summary-item">
                <div class="summary-label">Status Survei</div>
                <div class="summary-value">{{ $kuesioner->status_aktif ? '✓ Aktif' : '✗ Nonaktif' }}</div>
            </div>
            <div class="summary-item">
                <div class="summary-label">Target Responden</div>
                <div class="summary-value">{{ is_array($kuesioner->target_responden) ? implode(', ', array_map('ucfirst', $kuesioner->target_responden)) : ucfirst($kuesioner->target_responden) }}</div>
            </div>
            <div class="summary-item">
                <div class="summary-label">Tingkat Partisipasi</div>
                <div class="summary-value">{{ $responseRate }}%</div>
            </div>
            <div class="summary-item">
                <div class="summary-label">Tingkat Penyelesaian</div>
                <div class="summary-value">{{ $completionRate }}%</div>
            </div>
        </div>
    </div>

    {{-- Information Section --}}
    <div class="info-section">
        <h3>ℹ️ Informasi Survei</h3>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Judul Survei</span>
                <span class="info-value">{{ $kuesioner->judul }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Target Responden</span>
                <span class="info-value">{{ is_array($kuesioner->target_responden) ? implode(', ', array_map('ucfirst', $kuesioner->target_responden)) : ucfirst($kuesioner->target_responden) }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Tanggal Mulai</span>
                <span class="info-value">{{ \Carbon\Carbon::parse($kuesioner->tanggal_mulai)->format('d F Y') }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Tanggal Selesai</span>
                <span class="info-value">{{ \Carbon\Carbon::parse($kuesioner->tanggal_selesai)->format('d F Y') }}</span>
            </div>
            @if($kuesioner->deskripsi)
            <div class="info-item" style="grid-column: 1 / -1;">
                <span class="info-label">Deskripsi</span>
                <span class="info-value">{{ $kuesioner->deskripsi }}</span>
            </div>
            @endif
        </div>
    </div>

    {{-- Statistics Cards --}}
    <div class="stats">
        <div class="stat-card">
            <div class="stat-label">👥 Total Responden</div>
            <div class="stat-value">{{ $totalResponden }}</div>
            <div class="stat-subtext">Orang</div>
        </div>
        <div class="stat-card green">
            <div class="stat-label">❓ Total Pertanyaan</div>
            <div class="stat-value">{{ $kuesioner->pertanyaan->count() }}</div>
            <div class="stat-subtext">Pertanyaan</div>
        </div>
        <div class="stat-card blue">
            <div class="stat-label">📝 Total Jawaban</div>
            <div class="stat-value">{{ $totalResponden * $kuesioner->pertanyaan->count() }}</div>
            <div class="stat-subtext">Responses</div>
        </div>
        <div class="stat-card orange">
            <div class="stat-label">⭐ Rata-rata Skor</div>
            <div class="stat-value">{{ $avgScore ? number_format($avgScore, 1) : 'N/A' }}</div>
            <div class="stat-subtext">{{ $avgScore ? 'dari 5.0' : '' }}</div>
        </div>
    </div>

    <div style="page-break-before: always;"></div>

    {{-- Questions Analysis --}}
    <h2 style="margin-bottom: 20px; font-size: 18px; color: #111827; border-bottom: 3px solid #667eea; padding-bottom: 12px; font-weight: 700;">
        📊 Analisis Hasil Per Pertanyaan
    </h2>

    @foreach($analisis as $index => $item)
        <div class="question-section">
            <div class="question-header">
                <div class="question-title">
                    Pertanyaan {{ $index + 1 }} dari {{ $kuesioner->pertanyaan->count() }}
                </div>
                <div class="question-text">{{ $item['pertanyaan']->teks_pertanyaan }}</div>
                <div class="question-meta">
                    <span class="question-type">
                        @if($item['pertanyaan']->jenis_pertanyaan === 'likert')
                            ⭐ Skala Likert
                        @elseif($item['pertanyaan']->jenis_pertanyaan === 'pilihan_ganda')
                            ☑️ Pilihan Ganda
                        @else
                            ✍️ Isian Text
                        @endif
                    </span>
                    @if($item['pertanyaan']->kategori)
                        <span class="question-category">🏷️ {{ $item['pertanyaan']->kategori }}</span>
                    @endif
                    @if($item['pertanyaan']->wajib_diisi)
                        <span class="question-required">⚠️ Wajib</span>
                    @endif
                </div>
            </div>
            
            <div class="question-content">
                @if($item['pertanyaan']->jenis_pertanyaan === 'likert')
                    {{-- Likert Scale Analysis --}}
                    @php
                        $score = $item['rata_rata'];
                        $interpretation = '';
                        if($score >= 4.5) {
                            $interpretation = 'Sangat Memuaskan';
                        } elseif($score >= 3.5) {
                            $interpretation = 'Memuaskan';
                        } elseif($score >= 2.5) {
                            $interpretation = 'Cukup Memuaskan';
                        } elseif($score >= 1.5) {
                            $interpretation = 'Kurang Memuaskan';
                        } else {
                            $interpretation = 'Tidak Memuaskan';
                        }
                    @endphp
                    
                    <div class="score-display">
                        <div class="score-label">Rata-rata Skor Kepuasan</div>
                        <div class="score-value">{{ $score }}</div>
                        <div style="font-size: 16px; opacity: 0.9;">dari 5.0</div>
                        <div class="score-interpretation">{{ $interpretation }}</div>
                    </div>
                    
                    <div class="bar-chart">
                        @for($i = 1; $i <= 5; $i++)
                            @php
                                $data = $item['distribusi'][$i] ?? ['count' => 0, 'percentage' => 0];
                                $barClass = '';
                                if($i >= 4) $barClass = 'green';
                                elseif($i == 3) $barClass = 'yellow';
                                elseif($i <= 2) $barClass = 'red';
                                
                                $label = match($i) {
                                    1 => 'Sangat Buruk',
                                    2 => 'Buruk',
                                    3 => 'Netral',
                                    4 => 'Baik',
                                    5 => 'Sangat Baik',
                                };
                            @endphp
                            <div class="bar-item">
                                <span class="bar-label">{{ $i }}. {{ $label }}</span>
                                <div class="bar-container">
                                    <div class="bar-fill {{ $barClass }}" style="width: {{ $data['percentage'] }}%">
                                        @if($data['percentage'] > 12)
                                            <span class="bar-percentage">{{ $data['percentage'] }}%</span>
                                        @endif
                                    </div>
                                </div>
                                <span class="bar-count">{{ $data['count'] }} orang ({{ $data['percentage'] }}%)</span>
                            </div>
                        @endfor
                    </div>
                    
                    <div class="insights-box">
                        <strong>💡 Insight:</strong>
                        @php
                            $distribusiCollection = collect($item['distribusi'] ?? []);
                            $highest = $distribusiCollection->sortByDesc('count')->first();
                            $highestScale = $highest ? $distribusiCollection->search($highest) : null;
                        @endphp
                        @if($highest && $highestScale !== null && $highestScale !== false)
                            Mayoritas responden ({{ $highest['count'] ?? 0 }} orang atau {{ $highest['percentage'] ?? 0 }}%) memberikan penilaian skala {{ $highestScale }}.
                            @if($score >= 4)
                                Aspek ini mendapat apresiasi tinggi dari responden dan perlu dipertahankan.
                            @elseif($score >= 3)
                                Aspek ini menunjukkan kinerja yang cukup baik namun masih ada ruang untuk peningkatan.
                            @else
                                Aspek ini memerlukan perhatian khusus dan perbaikan segera.
                            @endif
                        @else
                            Belum ada data yang cukup untuk memberikan insight pada pertanyaan ini.
                        @endif
                    </div>

                @elseif($item['pertanyaan']->jenis_pertanyaan === 'pilihan_ganda')
                    {{-- Multiple Choice Analysis --}}
                    @php
                        $distribusiPG = collect($item['distribusi'] ?? []);
                        $mostChosen = $distribusiPG->sortByDesc('count')->first();
                        $mostChosenOption = $mostChosen ? $distribusiPG->search($mostChosen) : null;
                    @endphp
                    
                    @if($mostChosen && $mostChosenOption !== null && $mostChosenOption !== false)
                    <div style="background: #eff6ff; padding: 12px; border-radius: 6px; margin-bottom: 15px; border-left: 4px solid #3b82f6;">
                        <strong style="color: #1e40af; font-size: 12px;">Pilihan Terpopuler:</strong>
                        <div style="font-size: 14px; color: #1e3a8a; margin-top: 5px; font-weight: 600;">
                            "{{ $mostChosenOption }}" - {{ $mostChosen['count'] ?? 0 }} orang ({{ $mostChosen['percentage'] ?? 0 }}%)
                        </div>
                    </div>
                    @endif
                    
                    <div class="bar-chart">
                        @foreach(($item['distribusi'] ?? []) as $pilihan => $data)
                            <div class="bar-item">
                                <span class="bar-label" style="width: 150px;">{{ Str::limit($pilihan, 20) }}</span>
                                <div class="bar-container" style="width: calc(100% - 270px);">
                                    <div class="bar-fill green" style="width: {{ $data['percentage'] ?? 0 }}%">
                                        @if(($data['percentage'] ?? 0) > 12)
                                            <span class="bar-percentage">{{ $data['percentage'] }}%</span>
                                        @endif
                                    </div>
                                </div>
                                <span class="bar-count">{{ $data['count'] ?? 0 }} orang ({{ $data['percentage'] ?? 0 }}%)</span>
                            </div>
                        @endforeach
                    </div>
                    
                    @if($mostChosen && $mostChosenOption !== null && $mostChosenOption !== false)
                    <div class="insights-box">
                        <strong>💡 Insight:</strong>
                        Dari {{ $item['total_jawaban'] }} responden, pilihan "{{ $mostChosenOption }}" menjadi yang paling banyak dipilih dengan {{ $mostChosen['percentage'] ?? 0 }}% suara. 
                        Distribusi ini menunjukkan preferensi dominan responden terhadap opsi tersebut.
                    </div>
                    @endif

                @elseif($item['pertanyaan']->jenis_pertanyaan === 'isian')
                    {{-- Text Answers --}}
                    @php
                        $jawabanText = $item['jawaban_text'] ?? collect([]);
                        $jawabanCount = $jawabanText->count();
                    @endphp
                    
                    <div style="background: #eff6ff; padding: 12px; border-radius: 6px; margin-bottom: 15px; border-left: 4px solid #3b82f6;">
                        <strong style="color: #1e40af; font-size: 11px;">Total Jawaban Text:</strong>
                        <div style="font-size: 18px; color: #1e3a8a; margin-top: 4px; font-weight: 700;">
                            {{ $jawabanCount }} Jawaban
                        </div>
                    </div>
                    
                    @if($jawabanCount > 0)
                    <div style="max-height: 400px; overflow-y: auto;">
                        <strong style="font-size: 11px; color: #6b7280; display: block; margin-bottom: 10px;">
                            Sample Jawaban (Menampilkan 20 jawaban pertama):
                        </strong>
                        @foreach($jawabanText->take(20) as $idx => $jawaban)
                            <div class="text-answer">
                                <strong style="color: #6366f1; font-size: 10px;">Responden #{{ $idx + 1 }}:</strong>
                                <div style="margin-top: 4px;">{{ $jawaban }}</div>
                            </div>
                        @endforeach
                        @if($jawabanCount > 20)
                            <p style="font-style: italic; color: #6b7280; margin-top: 12px; text-align: center; background: #f9fafb; padding: 10px; border-radius: 6px;">
                                ... dan {{ $jawabanCount - 20 }} jawaban lainnya
                            </p>
                        @endif
                    </div>
                    
                    <div class="insights-box">
                        <strong>💡 Insight:</strong>
                        Terkumpul {{ $jawabanCount }} jawaban berbasis text dari responden. 
                        Jawaban-jawaban ini memberikan perspektif kualitatif yang berharga untuk memahami pengalaman dan masukan responden secara mendalam.
                    </div>
                    @else
                    <p style="text-align: center; color: #6b7280; padding: 20px; font-style: italic;">
                        Belum ada jawaban untuk pertanyaan ini.
                    </p>
                    @endif
                @endif

                <div class="answer-count">
                    <strong>📊 Statistik Jawaban:</strong>
                    <div style="margin-top: 6px; font-size: 11px; color: #4b5563;">
                        Total responden yang menjawab: <strong>{{ $item['total_jawaban'] }} orang</strong>
                        ({{ $totalResponden > 0 ? round(($item['total_jawaban'] / $totalResponden) * 100, 1) : 0 }}% dari total responden)
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- Footer --}}
    <div class="footer">
        <p><strong>Laporan dicetak pada:</strong> {{ now()->format('d F Y, H:i') }} WIB</p>
        <p style="margin-top: 8px; font-size: 11px; color: #374151;">
            <strong>SI-ELFA</strong> - Sistem Informasi Evaluasi Layanan Fakultas Akademik
        </p>
        <p style="margin-top: 5px; font-size: 9px;">
            Laporan ini bersifat rahasia dan hanya untuk keperluan internal institusi
        </p>
    </div>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
