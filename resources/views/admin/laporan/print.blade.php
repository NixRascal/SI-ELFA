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
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #333;
        }
        
        .header h1 {
            font-size: 20px;
            margin-bottom: 5px;
        }
        
        .header p {
            font-size: 14px;
            color: #666;
        }
        
        .info-section {
            margin-bottom: 25px;
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }
        
        .info-item {
            margin-bottom: 10px;
        }
        
        .info-label {
            font-weight: bold;
            color: #555;
            display: block;
            margin-bottom: 3px;
        }
        
        .info-value {
            color: #333;
        }
        
        .stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 25px;
        }
        
        .stat-card {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
        }
        
        .stat-label {
            font-size: 11px;
            color: #666;
            text-transform: uppercase;
        }
        
        .stat-value {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-top: 5px;
        }
        
        .question-section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }
        
        .question-header {
            background: #e9ecef;
            padding: 10px 15px;
            border-radius: 5px 5px 0 0;
            margin-bottom: 0;
        }
        
        .question-title {
            font-weight: bold;
            font-size: 13px;
            margin-bottom: 5px;
        }
        
        .question-text {
            color: #555;
        }
        
        .question-type {
            display: inline-block;
            background: #6366f1;
            color: white;
            padding: 2px 8px;
            border-radius: 3px;
            font-size: 10px;
            margin-left: 10px;
        }
        
        .question-content {
            border: 1px solid #e9ecef;
            border-top: none;
            padding: 15px;
            border-radius: 0 0 5px 5px;
        }
        
        .average-score {
            font-size: 16px;
            font-weight: bold;
            color: #6366f1;
            margin-bottom: 15px;
        }
        
        .bar-chart {
            margin-bottom: 10px;
        }
        
        .bar-item {
            margin-bottom: 8px;
        }
        
        .bar-label {
            display: inline-block;
            width: 80px;
            font-size: 11px;
        }
        
        .bar-container {
            display: inline-block;
            width: calc(100% - 180px);
            height: 20px;
            background: #e9ecef;
            border-radius: 3px;
            vertical-align: middle;
            position: relative;
            overflow: hidden;
        }
        
        .bar-fill {
            height: 100%;
            background: #6366f1;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding-right: 5px;
        }
        
        .bar-fill.green {
            background: #10b981;
        }
        
        .bar-percentage {
            color: white;
            font-size: 10px;
            font-weight: bold;
        }
        
        .bar-count {
            display: inline-block;
            width: 90px;
            text-align: right;
            font-size: 11px;
            margin-left: 10px;
        }
        
        .text-answer {
            background: #f8f9fa;
            padding: 8px 12px;
            margin-bottom: 5px;
            border-radius: 3px;
            font-size: 11px;
        }
        
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
        
        @media print {
            body {
                padding: 10px;
            }
            
            .question-section {
                page-break-inside: avoid;
            }
            
            @page {
                margin: 2cm;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN HASIL SURVEI</h1>
        <p>{{ $kuesioner->judul }}</p>
        <p style="font-size: 11px; margin-top: 5px;">
            Periode: {{ \Carbon\Carbon::parse($kuesioner->tanggal_mulai)->format('d M Y') }} - 
            {{ \Carbon\Carbon::parse($kuesioner->tanggal_selesai)->format('d M Y') }}
        </p>
    </div>

    <div class="info-section">
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Target Responden:</span>
                <span class="info-value">{{ ucfirst($kuesioner->target_responden) }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Status:</span>
                <span class="info-value">{{ $kuesioner->status_aktif ? 'Aktif' : 'Nonaktif' }}</span>
            </div>
            @if($kuesioner->deskripsi)
            <div class="info-item" style="grid-column: 1 / -1;">
                <span class="info-label">Deskripsi:</span>
                <span class="info-value">{{ $kuesioner->deskripsi }}</span>
            </div>
            @endif
        </div>
    </div>

    <div class="stats">
        <div class="stat-card">
            <div class="stat-label">Total Responden</div>
            <div class="stat-value">{{ $totalResponden }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Total Pertanyaan</div>
            <div class="stat-value">{{ $kuesioner->pertanyaan->count() }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Total Jawaban</div>
            <div class="stat-value">{{ $totalResponden * $kuesioner->pertanyaan->count() }}</div>
        </div>
    </div>

    <h2 style="margin-bottom: 20px; font-size: 16px; border-bottom: 2px solid #333; padding-bottom: 10px;">
        Analisis Hasil Survei
    </h2>

    @foreach($analisis as $index => $item)
        <div class="question-section">
            <div class="question-header">
                <div class="question-title">
                    Pertanyaan {{ $index + 1 }}
                    <span class="question-type">{{ str_replace('_', ' ', $item['pertanyaan']->jenis_pertanyaan) }}</span>
                </div>
                <div class="question-text">{{ $item['pertanyaan']->teks_pertanyaan }}</div>
            </div>
            
            <div class="question-content">
                @if($item['pertanyaan']->jenis_pertanyaan === 'likert')
                    <div class="average-score">
                        Rata-rata Skor: {{ $item['rata_rata'] }} / 5.0
                    </div>
                    
                    <div class="bar-chart">
                        @for($i = 1; $i <= 5; $i++)
                            @php
                                $data = $item['distribusi'][$i] ?? ['count' => 0, 'percentage' => 0];
                            @endphp
                            <div class="bar-item">
                                <span class="bar-label">Skala {{ $i }}</span>
                                <div class="bar-container">
                                    <div class="bar-fill" style="width: {{ $data['percentage'] }}%">
                                        @if($data['percentage'] > 15)
                                            <span class="bar-percentage">{{ $data['percentage'] }}%</span>
                                        @endif
                                    </div>
                                </div>
                                <span class="bar-count">{{ $data['count'] }} orang</span>
                            </div>
                        @endfor
                    </div>

                @elseif($item['pertanyaan']->jenis_pertanyaan === 'pilihan_ganda')
                    <div class="bar-chart">
                        @foreach($item['distribusi'] as $pilihan => $data)
                            <div class="bar-item">
                                <span class="bar-label" style="width: 150px;">{{ Str::limit($pilihan, 20) }}</span>
                                <div class="bar-container" style="width: calc(100% - 260px);">
                                    <div class="bar-fill green" style="width: {{ $data['percentage'] }}%">
                                        @if($data['percentage'] > 15)
                                            <span class="bar-percentage">{{ $data['percentage'] }}%</span>
                                        @endif
                                    </div>
                                </div>
                                <span class="bar-count">{{ $data['count'] }} orang</span>
                            </div>
                        @endforeach
                    </div>

                @elseif($item['pertanyaan']->jenis_pertanyaan === 'isian')
                    <div style="max-height: 300px; overflow-y: auto;">
                        @foreach($item['jawaban_text']->take(20) as $jawaban)
                            <div class="text-answer">{{ $jawaban }}</div>
                        @endforeach
                        @if($item['jawaban_text']->count() > 20)
                            <p style="font-style: italic; color: #666; margin-top: 10px;">
                                ... dan {{ $item['jawaban_text']->count() - 20 }} jawaban lainnya
                            </p>
                        @endif
                    </div>
                @endif

                <p style="margin-top: 15px; padding-top: 10px; border-top: 1px solid #ddd; font-size: 11px; color: #666;">
                    Total Jawaban: <strong>{{ $item['total_jawaban'] }}</strong>
                </p>
            </div>
        </div>
    @endforeach

    <div class="footer">
        <p>Laporan dicetak pada {{ now()->format('d F Y, H:i') }} WIB</p>
        <p>SI-ELFA - Sistem Informasi Evaluasi Layanan Fakultas Akademik</p>
    </div>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
