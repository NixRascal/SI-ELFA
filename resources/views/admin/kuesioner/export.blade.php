<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $kuesioner->judul }} - Export</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            padding: 20px;
            max-width: 210mm;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            padding: 20px 0;
            border-bottom: 3px solid #2563eb;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 24px;
            color: #1e40af;
            margin-bottom: 10px;
        }

        .header .subtitle {
            color: #6b7280;
            font-size: 14px;
        }

        .info-section {
            background: #f3f4f6;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .info-item {
            padding: 10px 0;
        }

        .info-label {
            font-size: 12px;
            color: #6b7280;
            text-transform: uppercase;
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        .info-value {
            font-size: 14px;
            color: #111827;
            font-weight: 500;
        }

        .description {
            background: #eff6ff;
            padding: 15px;
            border-left: 4px solid #2563eb;
            margin-bottom: 30px;
            font-size: 14px;
            color: #1e40af;
        }

        .questions-section h2 {
            font-size: 18px;
            color: #1e40af;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e5e7eb;
        }

        .question {
            page-break-inside: avoid;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .question-header {
            display: flex;
            align-items: start;
            margin-bottom: 15px;
        }

        .question-number {
            background: #2563eb;
            color: white;
            width: 32px;
            height: 32px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 15px;
            flex-shrink: 0;
        }

        .question-content {
            flex: 1;
        }

        .question-text {
            font-size: 15px;
            font-weight: 500;
            color: #111827;
            margin-bottom: 10px;
        }

        .question-meta {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
        }

        .badge-type {
            background: #e5e7eb;
            color: #374151;
        }

        .badge-category {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-required {
            background: #fee2e2;
            color: #991b1b;
        }

        .options {
            margin-top: 15px;
            padding-left: 47px;
        }

        .options-title {
            font-size: 12px;
            color: #6b7280;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .option-item {
            padding: 8px 0;
            padding-left: 20px;
            position: relative;
            font-size: 13px;
            color: #374151;
        }

        .option-item:before {
            content: "○";
            position: absolute;
            left: 0;
            color: #9ca3af;
        }

        .scale-container {
            margin-top: 15px;
            padding-left: 47px;
        }

        .scale-title {
            font-size: 12px;
            color: #6b7280;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .scale-items {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .scale-item {
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
        }

        .scale-1,
        .scale-2 {
            background: #fee2e2;
            color: #991b1b;
        }

        .scale-3 {
            background: #fef3c7;
            color: #92400e;
        }

        .scale-4,
        .scale-5 {
            background: #d1fae5;
            color: #065f46;
        }

        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #e5e7eb;
            text-align: center;
            color: #6b7280;
            font-size: 12px;
        }

        @media print {
            body {
                padding: 0;
            }

            .no-print {
                display: none;
            }

            .question {
                page-break-inside: avoid;
            }
        }

        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #2563eb;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        .print-button:hover {
            background: #1d4ed8;
        }
    </style>
</head>

<body>
    <button onclick="window.print()" class="print-button no-print">
        🖨️ Print / Save as PDF
    </button>

    <!-- Header -->
    <div class="header">
        <h1>{{ $kuesioner->judul }}</h1>
        <p class="subtitle">Kuesioner
            {{ is_array($kuesioner->target_responden) ? collect($kuesioner->target_responden)->map(fn($t) => ucfirst($t))->join(', ') : ucfirst($kuesioner->target_responden) }}
        </p>
    </div>

    <!-- Bagian Info -->
    <div class="info-section">
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Target Responden</span>
                <span
                    class="info-value">{{ is_array($kuesioner->target_responden) ? collect($kuesioner->target_responden)->map(fn($t) => ucfirst($t))->join(', ') : ucfirst($kuesioner->target_responden) }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Status</span>
                <span class="info-value">{{ $kuesioner->status_aktif ? 'Aktif' : 'Nonaktif' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Tanggal Mulai</span>
                <span class="info-value">{{ \Carbon\Carbon::parse($kuesioner->tanggal_mulai)->format('d M Y') }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Tanggal Selesai</span>
                <span
                    class="info-value">{{ \Carbon\Carbon::parse($kuesioner->tanggal_selesai)->format('d M Y') }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Dibuat Oleh</span>
                <span class="info-value">{{ $kuesioner->admin->nama ?? 'Admin' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Jumlah Pertanyaan</span>
                <span class="info-value">{{ $kuesioner->pertanyaan->count() }} Pertanyaan</span>
            </div>
        </div>
    </div>

    <!-- Deskripsi -->
    @if($kuesioner->deskripsi)
        <div class="description">
            <strong>Deskripsi:</strong> {{ $kuesioner->deskripsi }}
        </div>
    @endif

    <!-- Pertanyaan -->
    <div class="questions-section">
        <h2>Daftar Pertanyaan</h2>

        @foreach($kuesioner->pertanyaan as $index => $pertanyaan)
            <div class="question">
                <div class="question-header">
                    <div class="question-number">{{ $index + 1 }}</div>
                    <div class="question-content">
                        <div class="question-text">{{ $pertanyaan->teks_pertanyaan }}</div>
                        <div class="question-meta">
                            <span class="badge badge-type">
                                @if($pertanyaan->jenis_pertanyaan === 'likert')
                                    Skala Likert
                                @elseif($pertanyaan->jenis_pertanyaan === 'pilihan_ganda')
                                    Pilihan Ganda
                                @else
                                    Isian
                                @endif
                            </span>
                            @if($pertanyaan->kategori)
                                <span class="badge badge-category">{{ $pertanyaan->kategori }}</span>
                            @endif
                            @if($pertanyaan->wajib_diisi)
                                <span class="badge badge-required">Wajib Diisi</span>
                            @endif
                        </div>
                    </div>
                </div>

                @if($pertanyaan->jenis_pertanyaan === 'pilihan_ganda' && $pertanyaan->opsi_jawaban)
                    <div class="options">
                        <div class="options-title">Opsi Jawaban:</div>
                        @foreach($pertanyaan->opsi_jawaban as $opsi)
                            <div class="option-item">{{ $opsi }}</div>
                        @endforeach
                    </div>
                @elseif($pertanyaan->jenis_pertanyaan === 'likert')
                    <div class="scale-container">
                        <div class="scale-title">Skala Penilaian:</div>
                        <div class="scale-items">
                            <span class="scale-item scale-1">1 - Sangat Tidak Setuju</span>
                            <span class="scale-item scale-2">2 - Tidak Setuju</span>
                            <span class="scale-item scale-3">3 - Netral</span>
                            <span class="scale-item scale-4">4 - Setuju</span>
                            <span class="scale-item scale-5">5 - Sangat Setuju</span>
                        </div>
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Dokumen ini digenerate pada {{ now()->format('d M Y H:i') }}</p>
        <p>© {{ now()->year }} SI-ELFA - Sistem Informasi E-Learning Faculty Assesment</p>
    </div>
</body>

</html>